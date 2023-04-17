<?php

namespace App\Http\Controllers;

use App\Events\BuatPesan;
use App\Events\BuatReservasi;
use App\Http\Requests\Auth\LoginRequestSiswa;
use App\Models\Angkatan;
use App\Models\Aspek4B;
use App\Models\CatatanSikap;
use App\Models\Jurusan;
use App\Models\Kategori;
use App\Models\Lampiran;
use App\Models\PenilaianGuru;
use App\Models\Project;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\AspekDPG;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Raport;
use App\Models\DetailPG;
use App\Models\User;
use App\Imports\SiswaImport;
use App\Models\AlamatSiswa;
use App\Models\BillingKonseling;
use App\Models\DetailJK;
use App\Models\DetailSiswa;
use App\Models\ModelHasRoles;
use App\Models\PengajuanKonseling;
use Spatie\Permission\Models\Role;
use App\Models\TeacherHasTeaching;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Models\JadwalKonseling;
use App\Models\Notification;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use function PHPSTORM_META\map;

class SuperAppController extends Controller
{

    public function dashboardFunc(Request $req)
    {
    }
   

   


    public static function kategori(array $params)
    {
        // $point = Aspek4B::get()->groupBy("no_point");

        // $newpoint = [];

        // foreach($point as $i => $ps){
        //     $newpoint[$i]["point"] = $ps[0];
        //     $subpoint = Aspek4B::where("no_point", $ps[0]->no_point)->get()->groupBy("no_subpoint");
        //     foreach($subpoint as $j => $sp){
        //         $aspek = Aspek4B::where("no_point", $ps[0]->no_point)->where("no_subpoint",$sp[0]->no_subpoint)->get();
        //         foreach($aspek as $k =>$ask){
        //             $newpoint[$i]["subpoint"][$j][$k] = $ask;

        //         }

        //     }
        // }

        // return $newpoint;

        $kategori = new Kategori;

        if (isset($params["tindakan"])) {
            $kategori = $kategori->where("tindakan", $params["tindakan"]);
        }

        $newkategori = [];

        foreach ($kategori->get() as $i => $ktg) {
            $aspekterkait = Aspek4B::whereIn("id_aspek", explode(",", $ktg->aspek_berkaitan))->get();
            $newkategori[$i]["ktg"] = $ktg;
            $newkategori[$i]["aspek_terkait"] = $aspekterkait;
        }

        return $newkategori;
    }

    //catatan
    public function tambahcatatan(Request $req)
    {
        DB::beginTransaction();

        try {
            $catatansikap = new CatatanSikap();

            $catatansikap->id_penilai = Auth::user()->id;
            $catatansikap->nis_siswa = $req->nis;
            $catatansikap->id_kategori = $req->kategori;
            $catatansikap->visibilitas = $req->visibilitas;
            $catatansikap->keterangan = $req->keterangan;
            $catatansikap->tanggal = Carbon::now()->toDateTimeString();

            $catatansikap->save();

            $lampiran = new Lampiran();

            $image = $req->file('lampiran');
            $imageName = $catatansikap->id_cs . "_" . date("Y-m-d") . '.' . $image->extension();
            $image->move(public_path('lampiran'), $imageName);

            $lampiran->id_cs = $catatansikap->id_cs;
            $lampiran->nama_file = $imageName;
            $lampiran->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th);
        }
        return redirect()->back();
    }


    public function rekaperaport($angkatan, $jurusan)
    {
        $jurusanril = Jurusan::find($jurusan);
        $jumlahbulan = 12;

        $rekapbulan = [];
        for ($i = 1; $i <=  $jumlahbulan; $i++) {
            $arr["judul"] = "Rekap Eraport Kelas " . $jurusanril->jurusan;

            $querySekolah = PenilaianGuru::where("id_angkatan", $angkatan)->where("id_jurusan", $jurusan)->whereMonth("tanggal_penilaian", $i)->whereYear("tanggal_penilaian", date("Y"));

            $arr["pg"]["sekolah"]["data"] = $querySekolah->get();
            $arr["pg"]["sekolah"]["jumlah"] = $querySekolah->count();

            $arr["params"] = date("Y") . ":" . $i . ":" . $angkatan . ":" . $jurusan;
            array_push($rekapbulan, $arr);
        }

        //  dd($rekapbulan);

        return view("eraport.rekaperaport", ["rekapbulan" => $rekapbulan]);
    }



    public function injectraport($row, $akn, $jrs, $tgl)
    {
        // dd($req->session()->get('dataraport'));

        $rows = $row;
        $angkatan = $akn;
        $jurusan = $jrs;
        $tanggal =  $tgl;

        $penilaians = [];
        $ketarangan = [];
        $listSiswa = [];

        $currentpoint = [
            "point" => "ini",
            "no" => "init"
        ];
        $currentsubpoint = [
            "point" => "init",
            "no" => "init"
        ];

        //Make Penilaian
        foreach ($rows as $i => $row) {
            if ($i > 6) {
                if (!$this->hasNumber((string) $row[0])) {
                    if ($i != 7) {
                        if ($this->hasNumber((string) $rows[$i - 1][0])) {

                            $currentsubpoint["no"] = $rows[$i][0];
                            $currentsubpoint["point"] = $rows[$i][1];
                        } else {
                            $currentpoint["point"] = $rows[$i - 1][1];
                            $currentpoint["no"] = $rows[$i - 1][0];
                            $currentsubpoint["point"] = $rows[$i][1];
                            $currentsubpoint["no"] = $rows[$i][0];
                        }
                    } else {
                        $currentsubpoint["point"] = $rows[$i + 1][1];
                        $currentsubpoint["no"] = $rows[$i + 1][0];
                        $currentpoint["point"] = "hello";
                        $currentpoint["no"] = "hello";
                    }

                    //gettheketerangan
                    if (isset($rows[$i - 1])) {

                        if ($this->hasNumber((string) $rows[$i - 1][0]) and $rows[$i][0] == "Keterangan") {

                            foreach ($row as $j => $rk) {

                                if ($j > 1) {

                                    if ($row[$j] != null) {
                                        array_push($ketarangan, [
                                            "no" => $j - 1,
                                            "keterangan" => $rk,
                                            "followup" => $rows[$i + 1][$j],

                                        ]);

                                        array_push($listSiswa, $j - 1);
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $pointArr = explode("=", $currentpoint["point"]);
                    $value =  [
                        "point" => str_replace([":"], "", $pointArr[0]),
                        "no_aspek" => $row[0],
                        "no_point" => str_replace(["."], "", $currentpoint["no"]),
                        "no_subpoint" => str_replace(["."], "", $currentsubpoint["no"])
                    ];
                    //   array_push($nilai4b,$value);
                    foreach ($row as $r => $rowia) {

                        if ($row[$r] != null and $r > 1) {

                            $penilaian = array_merge([
                                "no_absen" => $r - 1,
                                "nilai" => $rowia,

                            ], $value);

                            array_push($penilaians, $penilaian);
                        }
                    }
                }
            }
        }
        //dd($penilaians);

        //    dd($ketarangan);

        //  $rows = Excel::toArray(new Raport, $req->file('file'))[1];
        return [$penilaians, $ketarangan];
    }

    //Send Raport
    

   

   



   

  

    public function hasNumber($str)
    {
        $isThereNumber = false;
        for ($i = 0; $i < strlen($str); $i++) {
            if (ctype_digit($str[$i])) {
                $isThereNumber = true;

                return $isThereNumber;
                break;
            }
        }
    }

    

   

    
    public function beranda()
    {
        $kategori = Kategori::all();

        $role = Auth::user()->getRoleNames()[0];

        $cs = CatatanSikap::with(["siswa", "penilai", "lampiran"])->where("visibilitas", "Semua");

        if (in_array($role, ["Pamong Putra", "Pamong Putri"])) {
            $cs = $cs->orWhere("visibilitas", "Asrama");
        } else if (in_array($role, ["Guru"])) {
            $cs = $cs->orWhere("visibilitas", "Sekolah");
        }

        $cs = $cs->get();

        return view("beranda.index", ["kategori" => $kategori, "catatan_sikap" => $cs]);
    }

    public function listsiswa(Request $req)
    {
        $siswa = Siswa::where("nama_siswa", "LIKE", "%" . $req->kw . "%")->get();
        return json_encode($siswa);
    }

    function roman_to_decimal($roman_numeral)
    {
        $romans = array("M" => 1000, "CM" => 900, "D" => 500, "CD" => 400, "C" => 100, "XC" => 90, "L" => 50, "XL" => 40, "X" => 10, "IX" => 9, "V" => 5, "IV" => 4, "I" => 1);
        $decimal = 0;
        foreach ($romans as $key => $value) {
            while (strpos($roman_numeral, $key) === 0) {
                $decimal += $value;
                $roman_numeral = substr($roman_numeral, strlen($key));
            }
        }
        return $decimal;
    }

    public function injectsiswa(Request $req)
    {
        return view("datasiswa.injectsiswa");
    }
    public function injectsiswastore(Request $req)
    {
    }

    //Siswa
    public function registersiswa(Request $req)
    {
        return view("auth.registersiswa");
    }

    public function registersiswastore(Request $req)
    {
        $req->validate([
            'nis' => ['required', 'max:255'],
            'password' => ['required', 'confirmed'],
        ]);

        //check the password
        //Update password 
        $siswa = Siswa::find($req->nis);

        if ($siswa->password != null) {
            return redirect()->back()->with("error", "Akun ini sudah memiliki kata sandi");
        }

        $siswa->password = Hash::make($req->password);
        $siswa->save();


        event(new Registered($siswa));

        Auth::guard("siswa")->login($siswa);

        Alert::success("Akun Berhasil diaktifkan", "Halo " . $siswa->nama_siswa . ", Selamat Datang di BKBN :)");

        return redirect()->route("siswa.pengajuankonseling");
    }

    public function loginsiswa(Request $req)
    {
        return view("auth.loginsiswa");
    }

   

   


    public function loginsiswaattempt(LoginRequestSiswa $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->route("siswa.pengajuankonseling");
    }

    public function logoutsiswa(Request $request)
    {
        Auth::guard('siswa')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

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
    

   

    public function injectphotoprofile()
    {
        $files = File::directories(public_path("pasfoto/"));

        foreach ($files as $fm) {
            $arrangkatan = explode(DIRECTORY_SEPARATOR, $fm);
            $key = key(array_slice($arrangkatan, -1, 1, true));
            $angkatan = ltrim($arrangkatan[$key], "A");
            foreach (File::directories($fm) as $file) {
                $arrjurusan = explode(DIRECTORY_SEPARATOR, $file);
                $keyj = key(array_slice($arrjurusan, -1, 1, true));
                $jurusana = explode(" ", $arrjurusan[$keyj]);
                $jurusan = isset($jurusana[2]) ? $jurusana[2] : $jurusana[0];
                echo $jurusan;
                foreach (File::files($file) as $i => $j) {
                    $jurusandata = Jurusan::where("jurusan", $jurusan)->orWhere("keterangan", $jurusan)->first();
                    echo $jurusandata->jurusan;
                    $filename = explode(".", $j->getFilename());
                    $siswa = Siswa::where("id_jurusan", $jurusandata->id_jurusan)->where("id_angkatan", $angkatan)->where("nama_siswa", "LIKE", "%" . $filename[0] . "%")->first();
                    if ($siswa) {
                        $name = $siswa->id_jurusan . "_" . $siswa->id_angkatan . "_" . $siswa->nis . "_" . "." . "jpg";
                        $siswa->foto_profil = $name;
                        $siswa->save();
                        Storage::disk("public_disk")->put("siswa/" . $angkatan . "/" . $jurusandata->jurusan . "/" . $name, file_get_contents($j));
                    }
                    // echo ($i+1).".".$j->getFilename()."<br>";
                }
                echo "<br>";
            }
        }



        // dd("tes");
    }
}
