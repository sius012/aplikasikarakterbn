<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillingKonseling;
use App\Models\User;
use App\Models\DetailJK;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\JadwalKonseling;
use RealRashid\SweetAlert\Facades\Alert;
use App\Events\BuatReservasi;
use App\Models\UserDis;
use App\Models\Jurusan;
use App\Models\Angkatan
use Auth;


class SiswaController extends Controller
{
    public function pengajuankonseling(Request $req)
    {
        $konselor = User::role(["Admin","Konselor"])->get();
        $konselorwithjadwal = [];

        foreach ($konselor as $ko) {
            $idkonselor = $ko->id;
            $jadwalmingguini = DetailJK::with("jadwal")->whereHas("jadwal", function ($q) use ($idkonselor) {
                $q->where("id_konselor", $idkonselor)->where("tahun", Carbon::now()->year)->where("bulan", Carbon::now()->month)->where("minggu", Carbon::now()->weekOfMonth);
            })->whereDoesntHave("bookedby")->where("hari", ">=", Carbon::now()->dayOfWeek)->get();
            $jadwal = count($jadwalmingguini) > 0 ? $jadwalmingguini->first()->id_jk : null;
            array_push(
                $konselorwithjadwal,
                [
                    "user" => $ko,
                    "id_jk" => $jadwal,
                    "jadwal_minggu_ini" => count($jadwalmingguini),
                    "pp"=>UserDis::find($idkonselor)->getPhotoProfile() == null ? asset("photoprofile/placeholder.jpeg") : UserDis::find($idkonselor)->getPhotoProfile()
                ]
            );
        }

        $finallyreturn = ["konselor" => $konselorwithjadwal];

        if ($req->filled("id")) {
            //checking ready session
            $id_jk = $req->id;
            $validation = DetailJK::with("jadwal")->whereHas("jadwal", function ($q) use ($id_jk) {
                $q->where("id_jk", $id_jk)->where("tahun", Carbon::now()->year)->where("bulan", Carbon::now()->month)->where("minggu", Carbon::now()->weekOfMonth);
            })->whereDoesntHave("bookedby")->where("hari", ">=", Carbon::now()->dayOfWeek)->get();

            $finallyreturn["detailjadwal"] = $validation->groupBy("hari");
        }




        return view("siswa.pengajuankonseling", $finallyreturn);
    }

    public function ajukansesi($id)
    {
    }


    public function carikonselor(Request $req)
    {
        $konselor = User::role("Guru BK")->where("name", "LIKE", "%" . $req->kw . "%")->get();
        return json_encode(["konselor" => $konselor]);
    }

    public function pengajuankonselingstore(Request $req)
    {
        //checking when billing not booked
        $booked = BillingKonseling::where("id_djk", $req->sesi)->count();
        if ($booked < 1) {
            $nis = Auth::user()->nis;

            DB::beginTransaction();
            try {
                $pk = BillingKonseling::create([
                    "nis_siswa" => Auth::user()->nis,
                    "id_djk" => $req->sesi,
                    "keterangan_siswa" => $req->keterangan,
                    "status" => "Dipesan"
                ]);

                $djk = DetailJK::with("jadwal")->find($req->sesi);
                $jk = JadwalKonseling::find($djk->id_jk);

                //Notif

                Notification::create([
                    'judul_notif' => "Konseling Masuk",
                    "isi_notif" => Auth::user()->nama_siswa . " Menangajukan sesi konseling",
                    'status' => "unread",
                    "created_at" => Carbon::now()->format('Y-m-d H:i:s'),
                    "id_user" => $jk->id_konselor
                ]);

                BuatReservasi::dispatch(Auth::user()->nama_siswa, Auth::user()->kelasdanjurusan(), $djk->tanggal, $djk->pertemuan_ke, $req->keterangan, $djk->jadwal->id_konselor, Auth::user()->getimageurl());
                // BuatPesan::dispatch("Reservasi Masuk");
                //Notif DB

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                dd($th);
                Alert::error("Pemesanan Batal");
                return redirect()->back();
            }
            Alert::success("Reservasi Berhasil", "Guru BK akan segera merespon");
            return redirect()->route("siswa.riwayatkonseling");
        } else {
            Alert::error("Pengajuan Gagal", "Sesi ini sudah tidak tersedia");
            return redirect()->back();
        }
    }

    public function riwayatkonseling(Request $req)
    {
        $riwayat = BillingKonseling::where("nis_siswa", Auth::user()->nis)->with("detailjk.jadwal.konselor")->get();
        return view("siswa.riwayatkonseling", ["riwayat" => $riwayat]);
    }


    public function batalkonseling(Request $req)
    {
        $bk = BillingKonseling::find($req->id);
        $bk->delete();
    }
    
    public function profilsiswa(Request $req)
    {
        // $kategori = Kategori::with("aspek4b")->get();
        $nis = Auth::user()->nis;
 
        //Catatan Eraport
        $catatanEraport = DetailPG::where("nis_siswa", $nis)->with(["parent.penilai"])->with( "aspek_dpg", function($q){
            $q->where("nilai", "<", 2)->with("aspek4B");
        })->whereHas("aspek_dpg", function ($q) {
            $q->where("nilai", 1);
        })->get();
        

        $jurusanAll = Jurusan::all();
        $angkatanAll = Angkatan::all();
        
        $catatanasrama = CatatanSikap::with(["penilai","kategori"])->with("lampiran")->where("nis_siswa", $nis)->get();
       

        $catatankonseling = BillingKonseling::where("nis_siswa", $nis)->with("detailjk.jadwal.konselor")->where("status", "Selesai")->get();

        $siswa = Siswa::with(["detail", "alamat"])->find($nis);

        //validate 
        $checker = TeacherHasTeaching::where("id_angkatan",$siswa->id_angkatan)->where("id_jurusan",$siswa->id_jurusan)->waliKelas(date("Y-m-d"))->get()->count();
        if(regularPermission(Auth::user()->getRoleNames()->toArray(),["Guru BK","Admin","Kesiswaan","Pamong Putra","Pamong Putri","Kepala Sekolah"])){
            if(regularPermission(Auth::user()->getRoleNames()->toArray(),["Pamong Putri"]) and $siswa->jenis_kelamin == "L"){
                Alert::error("Tidak dapat melihat data siswa","anda tidak memiliki hak akses untuk data aspa");
               return redirect()->route("datasiswa");
            }else if(regularPermission(Auth::user()->getRoleNames()->toArray(),["Pamong Putri"]) and $siswa->jenis_kelamin == "P"){
                Alert::error("Tidak dapat melihat data siswa","anda tidak memiliki hak akses untuk data aspi");
                return redirect()->route("datasiswa");
            }
        }else if($checker > 0){
            
        }else{
            Alert::error("Tidak dapat melihat data siswa","anda tidak memiliki hak akses untuk ".$siswa->angkatan->kelas()." ".$siswa->jurusan->jurusan);
            return redirect()->route("datasiswa");
        }
        return view("datasiswa.profilsiswa", ["angkatan"=>$angkatanAll, "jurusan"=>$jurusanAll,"siswa" => $siswa, "catataneraport" => $catatanEraport, "riwayatkonseling" => $catatankonseling, "catatanAsrama"=>$catatanasrama]);
    }
}
