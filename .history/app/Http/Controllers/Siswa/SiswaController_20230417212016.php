<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillingKonseling;
use App\Models\User;
use App\Models\DetailJK;

class SiswaController extends Controller
{
    public function pengajuankonseling(Request $req)
    {
        $konselor = User::role("Guru BK")->get();
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
                    "jadwal_minggu_ini" => count($jadwalmingguini)
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

    public function getinfosesi(Request $req)
    {
        $bk = BillingKonseling::with("detailJK.jadwal", "pemesan")->find($req->id);
        return json_encode($bk);
    }
    public function batalkonseling(Request $req)
    {
        $bk = BillingKonseling::find($req->id);
        $bk->delete();
    }
    
}
