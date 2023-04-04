<?php

namespace App\Http\Controllers;

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
use RealRashid\SweetAlert\Facades\Alert;

use function PHPSTORM_META\map;

class SuperAppController extends Controller
{
    public function dashboard(Request $req)
    {
        $jurusan = Jurusan::whereHas("siswa.angkatan", function ($q) {
            $q->where(DB::raw("tahun_mulai + 2"), ">", date("Y"));
        })->withCount(["siswa" => function ($q) {
            $q->whereHas('catatan_sikap.kategori', function ($j) {
                $j->where("kategori", "Merokok");
            });
        }])->with(["siswa" => function ($q) {
            $q->whereHas('catatan_sikap.kategori', function ($j) {
                $j->where("kategori", "Merokok");
            });
        }])->get();

        $jurusan = $jurusan->map(function ($jurusan) {
            return [
                "jurusan" => $jurusan,
                "angkatan" => $jurusan->siswa->groupBy('id_angkatan')
            ];
        });

        // dd($jurusan);

        //Metode Angkatan;

        $angkatan = Angkatan::where(DB::raw("tahun_mulai + 3
       "), "<", date("Y") + 3)->where(DB::raw("tahun_mulai + 3
       "), ">", date("Y"))->orWhere(
            function ($q) {
                $q->where("tahun_mulai", date("Y") - 3)->where("bulan_mulai", ">", Carbon::now()->month);
            }
        )->orWhere(
            function ($q) {
                $q->where("tahun_mulai", date("Y"))->where("bulan_mulai", "<=", Carbon::now()->month);
            }
        )->with(["siswa.catatan_sikap.kategori" => function ($q) {
            $q->where("kategori", "Merokok");
        }])->get();

        $angkatan = $angkatan->map(function ($akt) {
            $jurusan = [];
            $jumlahpelaku = [];

            foreach ($akt->siswa->groupBy("id_jurusan") as $i => $jrs) {
                $namajurusan = Jurusan::find($i)->jurusan;
                array_push($jurusan, $namajurusan);

                $jml = $jrs->map(function ($q) {
                    if ($q->catatan_sikap != null) {
                        if ($q->catatan_sikap->count() > 0) {
                            return 1;
                        } else {
                            return 0;
                        };
                    } else {
                        return 0;
                    }
                });

                array_push($jumlahpelaku, array_sum($jml->toArray()));
            }
            return [
                "labelJurusan" => $jurusan,
                "jumlahpelaku" => $jumlahpelaku,
            ];
        });

        if ($req->has("requestJson")) {

            return json_encode($angkatan);
        } else {
            return view("dashboard.index");
        }
    }

    public function dashboardFunc(Request $req)
    {
    }
    public function datasiswa(Request $req)
    {
        $siswa = Siswa::all();

        $angkatan = Angkatan::aktif()->get();

        $jurusan = Jurusan::all();

        $angkatanList = [
            date("Y") - 2011, date("Y") - 2011 - 1, date("Y") - 2011 - 2
        ];

        $therole = Auth::user()->getRoleNames()->first();

        $exceptedRole = [
            "Pamong Putra", "Kepala Sekolah", "Kesiswaan", "Pamong Putri", "Admin",
        ];

        $permission =  TeacherHasTeaching::where("id_guru", auth()->user()->id);

        $kelas = [];

        foreach ($angkatan as $i => $akt) {
            $p = $permission->where("id_angkatan", $akt->id_angkatan)->count();

            if ($p > 0 or in_array($therole, $exceptedRole) or in_array($therole, ["Admin","Guru BK","Kepala Sekolah"])) {
                $kelas[$akt->kelas()] =
                    [
                        "angkatan" => $akt->id_angkatan,
                        "jumlahsiswa" => Siswa::where("id_angkatan", $akt->id_angkatan)->count()
                    ];
            }
        }

        //d($kelas);

        return view("datasiswa.index", ["jurusan"=>$jurusan, "angkatan"=>$angkatan,"kelas" => $kelas, "siswa" => $siswa]);
    }

    public function carisiswa(Request $req){
        $siswa = new Siswa();

        if($req->filled("nama")){
            $siswa = $siswa->where("nama_siswa","LIKE","%".$req->nama."%");
        }

        if($req->filled("angkatan")){
            $siswa = $siswa->where("id_angkatan",$req->angkatan);
        }

        if($req->filled("jurusan")){
            $siswa = $siswa->where("id_jurusan",$req->jurusan);
        }

        return view("datasiswa.siswakelas", ["siswa"=>$siswa->get()]);
    }

    public function siswakelas($angkatan, $jurusan)
    {
        $siswa = Siswa::where("id_angkatan", $angkatan)->where("id_jurusan", $jurusan)->orderBy("no_absen","asc")->get();
        return view("datasiswa.siswakelas", ["siswa" => $siswa]);
    }

    public function profilsiswa($nis)
    {
        // $kategori = Kategori::with("aspek4b")->get();

        //Catatan Eraport
        $catatanEraport = DetailPG::where("nis_siswa", $nis)->with(["parent.penilai","aspek_dpg.aspek4B"])->with(["aspek_dpg"=>function($q){
            $q->where("nilai",1);
        }])->get();

        $catatanPositif = CatatanSikap::whereHas("kategori", function($q){
            $q->where("tindakan", "Positif");
        })->where("nis_siswa",$nis)->get();
        $catatanNegatif = CatatanSikap::whereHas("kategori", function($q){
            $q->where("tindakan", "Negatif");
        })->where("nis_siswa",$nis)->get();

        $catatankonseling = PengajuanKonseling::where("nis_siswa", $nis)->where("status","Selesai")->get();

        $siswa = Siswa::with(["detail","alamat"])->find($nis);

        return view("datasiswa.profilsiswa", ["siswa" => $siswa, "catataneraport"=>$catatanEraport, "catatankonseling"=>$catatankonseling, "catatanNegatif"=>$catatanNegatif, "catatanPositif"=>$catatanPositif]);
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

    public function datajurusan($angkatan)
    {
        $jurusan = Siswa::where("id_angkatan", $angkatan)->with("jurusan")->get()->groupBy("id_jurusan");

        $jurusanall = Jurusan::all();
        return view("datasiswa.datajurusan", ["jurusan" => $jurusan, "angkatan" => $angkatan, "jurusanall" => $jurusanall]);
    }

    public function tambahsiswa(Request $req)
    {
        $siswa = $req->input();
        unset($siswa["_token"]);
        DB::beginTransaction();
        try {
            $find = Siswa::find($siswa['nis']);
            if (!$find) {
                $datasiswa = Siswa::create($siswa);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
        return redirect()->back();
    }

    public function tambahsiswaexcel(Request $req)
    {
        $siswa = Excel::import(new SiswaImport, $req->file('file_excel'));

        return redirect()->back();
    }

    public function eraportkelas($angkatan, $jurusan)
    {
        $pg = PenilaianGuru::with("detail_pg")->where("id_penilai", Auth::user()->id)->get();
        $kelas = Siswa::where("id_angkatan", $angkatan)->where("id_jurusan", $jurusan)->first()->kelasdanjurusan();

        $params = $angkatan . ":" . $jurusan;

        $eraport = PenilaianGuru::where("id_penilai", Auth::user()->id)->where("id_angkatan", $angkatan)->where("id_jurusan", $jurusan)->get();

        return view("eraport.raportkelas", ["penilain_guru" => $pg, "kelas" => $kelas, "params" => $params, "eraport" => $eraport]);
    }

    public function validasieraport(Request $req)
    {
        $tablevalidasi = [];
        $tablevalidasi["Rentang Waktu Penilaian"] = false;
        $tablevalidasi["Kesamaan Jumlah Siswa"] = false;
        $tablevalidasi["Letak Kolom Kelas dan Jurusan"] = false;
        $tablevalidasi["Kelas ditemukan"] = false;
        $tablevalidasi["Jurusan sesuai"] = false;
        $param =  explode(":", $req->param);
        $angkatan = Angkatan::find($param[0]);
        $jurusanril = Jurusan::find($param[1]);

        $kelasril = $angkatan->kelas();

        //Excel Sheet
        $rows = Excel::toArray(new Raport, $req->file('file'));

        $finallyRow = null;
        $bulan = ltrim(date("m", strtotime($req->tanggal)), 0);
        //Valdasi rentang waktu

        $tablevalidasi["Rentang Waktu Penilaian"] = PenilaianGuru::whereMonth("tanggal_penilaian", $bulan)->whereYear("tanggal_penilaian", date("Y", strtotime($req->tanggal)))->where("id_penilai", Auth::user()->id)->where("id_angkatan", $param[0])->where("id_jurusan", $jurusanril->id_jurusan)->count() > 0 ? false : true;

        foreach ($rows as $i => $rws) {
            if (isset($rws[3][1])) {
                $tablevalidasi["Letak Kolom Kelas dan Jurusan"] = true;
                $kelasclear = trim(str_replace(":", "", $rws[3][1]));
                $kelasclear = explode(" ", $kelasclear);
                $kelas =  $this->roman_to_decimal($kelasclear[0]);
                $jurusan = $kelasclear[1];
                if ($kelas == $kelasril) {
                    $tablevalidasi["Kelas ditemukan"] = true;
                    if ($jurusanril->jurusan == $jurusan) {
                        $tablevalidasi["Jurusan sesuai"] = true;
                        $finallyRow = $rws;
                    } else {
                    }
                } else {
                }
            }
        }

        //dd($finallyRow);

        //Kalkulasi Jumlah siswa
        $jumlahsiswa = Siswa::where('id_angkatan', $angkatan->id_angkatan)->where("id_jurusan", $jurusanril->id_jurusan)->count();
        $jumlahsiswaexcel = 0;

        // dd($finallyRow);

        foreach ($finallyRow[6] as $i => $fr) {
            if ($i > 1) {
                if ($fr != null) {
                    $jumlahsiswaexcel += 1;
                } else {
                    break;
                }
            }
        }
        //  dd($jumlahsiswaexcel);
        if ($jumlahsiswa == $jumlahsiswaexcel) {
            $tablevalidasi["Kesamaan Jumlah Siswa"] = true;
        }

        $permission = true;
        foreach ($tablevalidasi as $ts) {
            if ($ts == false) {
                $permission = false;
                break;
            }
        }

        if ($permission == true) {
            $req->session()->put('dataraport', ['dataraport' => $finallyRow, "angkatan" => $angkatan->id_angkatan, "jurusan" => $jurusanril->id_jurusan, "tanggal_penilaian" => $req->tanggal]);
        } else {
            $req->session()->forget('dataraport');
        }

        //Make Preview
        $datasiswa = Siswa::where("id_angkatan", $angkatan->id_angkatan)->where("id_jurusan", $jurusanril->id_jurusan)->get();

        $aspek4b = Aspek4B::all()->groupBy("point")->groupBy("subpoint");

        $generateEraport = $this->injectraport($finallyRow, $angkatan->id_angkatan, $jurusanril->id_jurusan, $req->tanggal);

        $listSiswa = $generateEraport[0];
        $keterangan = $generateEraport[1];

        //Make Preview
        $aspeks = [];

        //  dd($listSiswa);
        foreach ($listSiswa as $i => $ls) {
            $aspek = Aspek4B::where("no_aspek", $ls["no_aspek"])->where("no_point", $ls["no_point"])->where("no_subpoint", $ls["no_subpoint"])->first();

            $namasiswa = Siswa::with("jurusan")->where("id_angkatan", $angkatan->id_angkatan)->where("id_jurusan",  $jurusanril->id_jurusan)->where("no_absen", $ls["no_absen"])->first();

            $aspeks[$ls["no_aspek"] . ":" . $ls["no_subpoint"] . ":" . $ls["no_point"]]["aspek"] = $aspek->keterangan;
            $aspeks[$ls["no_aspek"] . ":" . $ls["no_subpoint"] . ":" . $ls["no_point"]]["point"] = $aspek->point;
            $aspeks[$ls["no_aspek"] . ":" . $ls["no_subpoint"] . ":" . $ls["no_point"]]["subpoint"] = $aspek->subpoint;

            $aspeks[$ls["no_aspek"] . ":" . $ls["no_subpoint"] . ":" . $ls["no_point"]]["siswa"][$ls["no_absen"]]["nama"] = $namasiswa->nama_siswa;
            $aspeks[$ls["no_aspek"] . ":" . $ls["no_subpoint"] . ":" . $ls["no_point"]]["siswa"][$ls["no_absen"]]["nilai"] = $ls["nilai"];
        }

        return view("outputeraport.eraportkelas", ['table' => $tablevalidasi, "aspek" => $aspeks, "kelas" => date("Y") -  $angkatan->tahun_mulai + 9, "jurusan" => $jurusanril->jurusan, "tanggal" => $req->tanggal, "keterangan" => $keterangan]);
    }

    public function updateeraport(Request $req)
    {
        //Update ADPG
        foreach ($req->adpg as $i => $ads) {
            $adpg = AspekDPG::find($i);
            if ($adpg->nilai != $ads) {
                $adpg->nilai = $ads;
                $adpg->save();
            }
        }

        //Update DPG
        foreach ($req->ktr as $i => $dps) {
            $dpg = DetailPG::find($i);
            if ($dpg->keterangan != $dps) {
                $dpg->keterangan = $dps;
                $dpg->save();
            }
            if ($dpg->followup != $req->fwu[$i]) {
                $dpg->followup = $req->fwu[$i];
                $dpg->save();
            }
        }

        //Update PG

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

    public function rekaperaportdetail($params)
    {
        //dd($params);
        list($tahun, $bulan, $angkatan, $jurusan) = explode(":", $params);

        $siswa = Siswa::where("id_angkatan", $angkatan)->where("id_jurusan", $jurusan)->orderBy("no_absen", "asc")->get();
        $aspek4b = Aspek4B::all();

        $kelas = Angkatan::find($angkatan)->kelas();
        $jurusan = Jurusan::find($jurusan);

        //  dd($aspek4b);

        $rekaplist = [];

        foreach ($aspek4b as $j => $asp4b) {

            foreach ($siswa as $s => $sws) {
                $qpasrama = AspekDPG::where("id_aspek", $asp4b->id_aspek)->whereHas("detailPG.siswa", function ($q) use ($sws) {
                    $q->where("nis_siswa", $sws->nis);
                })->whereHas("detailPG.parent", function ($q) use ($bulan, $tahun) {
                    $q->whereMonth("tanggal_penilaian", $bulan)->whereYear("tanggal_penilaian", $tahun);
                })->whereHas("detailPG.parent.penilai.roles.role", function ($q) {
                    $q->whereIn("name", ["Pamong Putra", "Pamong Putri"]);
                });

                $nis = $sws->nis;

                $countasrama = PenilaianGuru::whereYear("tanggal_penilaian", $tahun)->whereMonth("tanggal_penilaian", $bulan)->whereHas("penilai.roles.role", function ($q) {
                    $q->whereIn("name", ["Pamong Putra", "Pamong Putri"]);
                })->whereHas("detail_pg", function ($q) use ($nis) {
                    $q->where("nis_siswa", $nis);
                })->groupBy("id_penilai")->count();

                $qpsekolah = AspekDPG::where("id_aspek", $asp4b->id_aspek)->whereHas("detailPG.siswa", function ($q) use ($sws) {
                    $q->where("nis_siswa", $sws->nis);
                })->whereHas("detailPG.parent", function ($q) use ($bulan, $tahun) {
                    $q->whereMonth("tanggal_penilaian", $bulan)->whereYear("tanggal_penilaian", $tahun);
                })->whereHas("detailPG.parent.penilai.roles.role", function ($q) {
                    $q->whereNotIn("name", ["Pamong Putra", "Pamong Putri"]);
                });

                $countsekolah = PenilaianGuru::whereYear("tanggal_penilaian", $tahun)->whereMonth("tanggal_penilaian", $bulan)->whereHas("penilai.roles.role", function ($q) {
                    $q->whereNotIn("name", ["Pamong Putra", "Pamong Putri"]);
                })->whereHas("detail_pg", function ($q) use ($nis) {
                    $q->where("nis_siswa", $nis);
                })->groupBy("id_penilai")->count();

                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["point"] = $asp4b->point;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["subpoint"] = $asp4b->subpoint;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["aspek"] = $asp4b->keterangan;

                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["data"] = $sws;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["nilai_asrama"]['count'] = $countasrama;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["nilai_asrama"]['jumlah'] = $qpasrama->sum("nilai");
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["nilai_asrama"]['jumlah_akumulatif'] = $countasrama != 0 ? $qpasrama->sum("nilai") / $countasrama : 0;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["nilai_sekolah"]['count'] = $countsekolah;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["nilai_sekolah"]['jumlah'] = $qpsekolah->sum("nilai");
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["nilai_sekolah"]['jumlah_akumulatif'] = $countsekolah != 0 ? $qpsekolah->sum("nilai") / $countsekolah : 0;
            }
        }

        return view("eraport.rekaperaportdetail", ["siswa" => $siswa, "rekaplist" => $rekaplist, "kelas" => $kelas, "jurusan" => $jurusan->jurusan]);
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
    public function senderaport(Request $req)
    {
        $aspek = $req->input()["aspek"];
        $absen = reset($req->input()["aspek"]);

        $angkatan = date("Y") - 2010 - ($req->kelas - 9);

        $jurusan = Jurusan::where("jurusan", $req->jurusan)->first()->id_jurusan;
        DB::beginTransaction();
        try {
            //Make Penilaian guru
            $pg = new PenilaianGuru();
            $pg->id_angkatan = $angkatan;
            $pg->id_jurusan = $jurusan;
            $pg->id_penilai = Auth::user()->id;
            $pg->keterangan = "New Raport";
            $pg->tanggal_penilaian = $req->tanggal;
            $pg->save();

            foreach ($absen as $a => $asp) {

                $siswa = Siswa::where("no_absen", $a)->where("id_angkatan", $angkatan)->where("id_jurusan", $jurusan)->first();
                $nis = $siswa->nis;
                $no = $siswa->no_absen;

                $dp = DetailPG::create([
                    "id_pg" => $pg->id_pg,
                    "nis_siswa" => $nis,
                    "keterangan" => isset($req->ktr[$a]) ? $req->ktr[$a] : "-",
                    "followup" => isset($req->fwu[$a]) ? $req->fwu[$a] : "-",
                ]);

                echo $dp->id_dpg;

                foreach ($aspek as $as => $aspi) {
                    $arr = explode(":", $as);
                    $aspeks = Aspek4B::where("no_aspek", $arr[0])->where("no_subpoint", $arr[1])->where("no_point", $arr[2])->first()->id_aspek;
                    echo $nis;
                    $dapg = AspekDPG::create([
                        "id_dpg" => $dp->id_dpg,
                        "id_aspek" => $aspeks,
                        "nilai" => $aspi[$no]
                    ]);
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th);
            //throw $th;
        }
    }

    public function lihateraport($id)
    {
        $pg = PenilaianGuru::with("detail_pg.siswa", "detail_pg.aspek_dpg.aspek4b")->find($id);

        // dd($pg);
        $aspek = [];

        //foreach
        foreach ($pg->detail_pg->first()->aspek_dpg as $i => $ask) {
            $aspek[$ask->aspek4b->no_aspek . ":" . $ask->aspek4b->no_subpoint . ":" . $ask->aspek4b->no_point]["aspek"] = $ask->aspek4b->keterangan;
            $aspek[$ask->aspek4b->no_aspek . ":" . $ask->aspek4b->no_subpoint . ":" . $ask->aspek4b->no_point]["point"] = $ask->aspek4b->point;
            $aspek[$ask->aspek4b->no_aspek . ":" . $ask->aspek4b->no_subpoint . ":" . $ask->aspek4b->no_point]["subpoint"] = $ask->aspek4b->subpoint;

            $id_aspek = $ask->id_aspek;

            $siswa = AspekDPG::whereHas("detailPG", function ($q) use ($id_aspek, $id) {
                $q->where("id_pg", $id);
            })->with("detailPG.siswa")->where("id_aspek", $id_aspek)->get();

            foreach ($siswa as $j => $sis) {
                $aspek[$ask->aspek4b->no_aspek . ":" . $ask->aspek4b->no_subpoint . ":" . $ask->aspek4b->no_point]["siswa"][(string)$sis->detailPG->nis_siswa]["nama"] = $sis->detailPG->siswa->nama_siswa;
                $aspek[$ask->aspek4b->no_aspek . ":" . $ask->aspek4b->no_subpoint . ":" . $ask->aspek4b->no_point]["siswa"][(string)$sis->detailPG->nis_siswa]["nilai"] = $sis->nilai;
                $aspek[$ask->aspek4b->no_aspek . ":" . $ask->aspek4b->no_subpoint . ":" . $ask->aspek4b->no_point]["siswa"][(string)$sis->detailPG->nis_siswa]["id_adpg"] = $sis->id_adpg;
            }
        }

        $keterangan = [];
        foreach ($pg->detail_pg as $d => $dpg) {
            $keterangan[$dpg->nis_siswa]["keterangan"] = $dpg->keterangan;
            $keterangan[$dpg->nis_siswa]["followup"] = $dpg->followup;
            $keterangan[$dpg->nis_siswa]["no"] = $dpg->siswa->no_absen;
            $keterangan[$dpg->nis_siswa]["id_dpg"] = $dpg->id_dpg;
        }

        return view("eraport.lihateraport", ['aspek' => $aspek, "keterangan_laporan" => $pg->keterangan, "tanggal" => $pg->tanggal_penilaian, "keterangan" => $keterangan]);
    }

    public function konfigurasiumum(Request $req)
    {

        return view("konfigurasiumum.index");
    }

    public function tambahkategori(Request $req)
    {
        $kategori = $req->kategori;
        $tindakan = $req->tindakan;
        $aspekterkait = '';

        foreach ($req->id_aspek as $i => $ids) {
            $aspekterkait .= $ids . (isset($req->id_aspek[$i + 1]) ? "," : '');
        }

        DB::beginTransaction();
        try {
            $kategories = Kategori::create([
                'kategori' => $kategori,
                'tindakan' => $tindakan,
                'aspek_berkaitan' => $aspekterkait,
                'nilai' => $req->tindakan == 'Positif' ? 4 : 1
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }

        return redirect()->back();
    }

    public function konfigurasiangkatan(Request $req)
    {
        $angkatan = Angkatan::all();
        return view("konfigurasiumum.konfigurasiangkatan", ["angkatan" => $angkatan]);
    }

    public function tambahangkatan(Request $req)
    {
        $angkatan = Angkatan::find($req->angkatan);
        if ($angkatan) {
            return redirect()->back();
        } else {
            $angkatan = Angkatan::create([
                'id_angkatan' => $req->angkatan,
                "tahun_mulai" => $req->tahun_mulai,
                "bulan_mulai" => $req->bulan_mulai,
            ]);

            return redirect()->back();
        }
    }

    public function konfigurasijurusan(Request $req)
    {
        $jurusan = Jurusan::all();
        return view("konfigurasiumum.konfigurasijurusan", ["jurusan" => $jurusan]);
    }

    public function tambahjurusan(Request $req)
    {
        $check = Jurusan::where("jurusan", $req->jurusan)->get();
        if ($check->count() < 1) {

            $jurusan = Jurusan::create([
                'jurusan' => $req->jurusan,
                "keterangan" => $req->keterangan,
            ]);
        }
        return redirect()->back();
    }

    public function konfigurasipengguna(Request $req)
    {
        $user = User::get();
        return view("konfigurasiumum.konfigurasipengguna.index", ["user" => $user]);
    }

    public function konfigurasikategori(Request $req)
    {
        if ($req->has("requestJson")) {
            $dataaspek = Aspek4B::all()->groupBy("point");
            $das = [];

            foreach ($dataaspek as $i => $da) {
                array_push($das, [
                    'point' => $i,
                    'aspek' => $da
                ]);
            }
            return json_encode($das);
        }

        $kategori = Kategori::all();
        $kategori = $kategori->map(function ($ktr) {
            $aspek = explode(',', $ktr->aspek_berkaitan);
            $asp = Aspek4B::whereIn('id_aspek', $aspek)->get()->groupBy('point');
            return ['kategori' => $ktr, 'aspek' => $asp];
        });

        return view('konfigurasiumum.konfigurasikategori.index', ['kategori' => $kategori]);
    }

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

    public function tambaheraportmanual($params)
    {
        $arr = explode(":", $params);
        $jurusan = $arr[1];
        $angkatan = $arr[0];

        $aspek = Aspek4B::all();

        $aspekfinal = [];

        $kelas = Angkatan::find($angkatan)->kelas();;
        $myrole = Auth::user()->getRoleNames()[0];

        foreach ($aspek as $i => $asp) {
            $siswa = Siswa::where("id_angkatan", $angkatan)->where("id_jurusan", $jurusan);

            switch ($myrole) {
                case 'Pamong Putra':
                    $siswa = $siswa->where("jenis_kelamin", "Laki-laki");
                    break;

                case 'Pamong Putri':
                    $siswa = $siswa->where("jenis_kelamin", "Perempuan");
                    break;
                default:
                    # code...
                    break;
            }

            $aspekfinal[$asp->no_aspek . ":" . $asp->no_subpoint . ":" . $asp->no_point] = [
                "id_aspek" => $asp->id_aspek,
                "aspek" => $asp->keterangan,
                "point" => $asp->point,
                "subpoint" => $asp->subpoint,
                "siswa" => $siswa->get()
            ];
        }

        $jurusanril = Jurusan::find($jurusan);
        $jurusanarr = Jurusan::whereHas("siswa", function ($q) use ($angkatan) {
            $q->where("id_angkatan", $angkatan);
        })->get();

        return view("eraport.tambaheraportmanual", ["aspek" => $aspekfinal, "kelas" => $kelas, "jurusan" => $jurusanril, "jurusanarr" => $jurusanarr, "params" => $params]);
    }

    public function tambaheraportmanualstore(Request $req)
    {
        //dd($req);
        list($angkatan, $jurusan) = explode(":", $req->params);
        DB::beginTransaction();
        try {
            //Tambah Penilaian Guru;
            $pg = PenilaianGuru::create([
                "id_angkatan" => $angkatan,
                "id_jurusan" => $jurusan,
                "keterangan" => $req->keterangan,
                "tanggal_penilaian" => $req->tanggal,
                "id_penilai" => Auth::user()->id,
            ]);

            //Tambah Detail Penilaian Guru;
            foreach ($req->dpg as $i => $dpgs) {
                $dpg = DetailPG::create([
                    "id_pg" => $pg->id_pg,
                    'nis_siswa' => $i,
                    "keterangan" => $req->ktr[$i],
                    "followup" => $req->fwu[$i],
                ]);

                foreach ($dpgs as $j => $adpg) {
                    $adpgd = AspekDPG::create([
                        "id_dpg" => $dpg->id_dpg,
                        "id_aspek" => $j,
                        "nilai" => $adpg,
                    ]);
                }
            }
            //Tambah ADPG

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            //throw $th;
        }

        return redirect()->route("eraport.kelas", ["angkatan" => $angkatan, "jurusan" => $jurusan]);
    }

    public function hakakseskelas($id)
    {
        $user = User::find($id);
        $hakases = TeacherHasTeaching::where("id_guru", $id)->with("angkatan")->get();

        $angkatan = Angkatan::all();
        $jurusan = Jurusan::all();
        return view("konfigurasiumum.konfigurasipengguna.hakakses", ["id" => $id, "hakakses" => $hakases, "angkatan" => $angkatan, "jurusan" => $jurusan, "user" => $user]);
    }

    public function tambahhakakseskelas(Request $req)
    {
        $angkatan = $req->angkatan;
        $jurusan = $req->jurusan;

        DB::beginTransaction();
        try {
            $hakakses = TeacherHasTeaching::create([
                "id_guru" => $req->id_user,
                "id_angkatan" => $angkatan,
                "id_jurusan" => $jurusan,
                "dari" => $req->dari,
                "sampai" => $req->sampai,
                "sebagai" => $req->sebagai
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }

        return redirect()->back();
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
    public function registersiswa(Request $req){
        return view("auth.registersiswa");
    }

    public function registersiswastore(Request $req){
        $req->validate([
            'nis' => ['required', 'max:255'],
            'password' => ['required', 'confirmed'],
        ]);

        //check the password
        //Update password 
        $siswa = Siswa::find($req->nis);

        if($siswa->password != null){
            return redirect()->back()->with("error", "Akun ini sudah memiliki kata sandi");
        }

        $siswa->password = Hash::make($req->password);
        $siswa->save();

        event(new Registered($siswa));

        Auth::guard("siswa")->login($siswa);

        return redirect()->route("siswa.pengajuankonseling");

    }

    public function loginsiswa(Request $req){
        return view("auth.loginsiswa");
    }

    public function profil(Request $req){
        $day = [
            ["label"=>"Senin", "lc"=>1],
            ["label"=>"Selasa", "lc"=>2],
            ["label"=>"Rabu", "lc"=>3],
            ["label"=>"Kamis", "lc"=>4],
            ["label"=>"Jumat", "lc"=>5],
        ];

        $jadwalkonseling = JadwalKonseling::where("id_konselor", Auth::user()->id)->get();

        return view("profil.index", ["hari"=>$day, "jadwalkonseling"=>$jadwalkonseling]);
    }

    public function storejadwal(Request $req){
       // dd($req);
        DB::beginTransaction();
        try {
            //Check Jadwal

            $jadwal = new JadwalKonseling();
            $jadwal->id_konselor = Auth::user()->id;
            $jadwal->keterangan= $req->keterangan;
            $jadwal->minggu=$req->minggu;
            $jadwal->bulan=$req->bulan;
            $jadwal->tahun =date("Y");
            $jadwal->status = "Berjalan";
            
            $jadwal->save();
            
            foreach($req->jadwal as $i => $jwl){
                foreach($jwl as $djk){
                    $djk = DetailJK::create([
                        "id_jk"=>$jadwal->id_jk,
                        "hari"=>ucwords($i),
                        "dari"=>$djk["dari"],
                        "sampai"=>$djk["sampai"]
                    ]);
                }
            }

            DB::commit();
            dd($jadwal->id_jk);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    public function lihatjadwal($id){
        $jk = [];
        $jk["jadwal_konseling"] = JadwalKonseling::find($id);
        $jk["detail"] = DetailJK::withCount("bookedby")->where("id_jk", $id)->get()->groupby("hari");
        return view("bk.lihatjadwal", ["jadwalkonseling"=>$jk]);
    }

    public function loginsiswaattempt(LoginRequestSiswa $request){
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->route("siswa.pengajuankonseling");
    }

    public function logoutsiswa(Request $request){
        Auth::guard('siswa')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function pengajuankonseling(Request $req){
        $konselor = User::role("Guru BK")->get();
        $konselorwithjadwal = [];
        
        foreach($konselor as $ko){
            $idkonselor = $ko->id;
            $jadwalmingguini = DetailJK::with("jadwal")->whereHas("jadwal", function($q) use($idkonselor){
                $q->where("id_konselor",$idkonselor)->where("tahun", Carbon::now()->year)->where("bulan",1)->where("minggu", Carbon::now()->weekOfMonth);
            })->whereDoesntHave("bookedby")->where("hari", ">=",Carbon::now()->dayOfWeek)->get();
            $jadwal = count($jadwalmingguini) > 0 ? $jadwalmingguini->first()
            array_push($konselorwithjadwal, [
                "user"=>$ko,
                "id_jk"=>
                "jadwal_minggu_ini"=>count($jadwalmingguini)]
            );
        }

       
        return view("siswa.pengajuankonseling", ["konselor"=>$konselorwithjadwal]);
    }

    public function ajukansesi($id){
        
    }


    public function carikonselor(Request $req){
        $konselor = User::role("Guru BK")->where("name","LIKE","%".$req->kw."%")->get();
        return json_encode(["konselor"=>$konselor]);
    }

    public function pengajuankonselingstore(Request $req){
        $req->validate([
            "id_konselor"=>["required"]
        ]);

        $nis = Auth::user()->nis;

        DB::beginTransaction();
        try {
            $pk = PengajuanKonseling::create([
                "id_konselor"=>$req->id_konselor,
                "nis_siswa"=>$nis,
                "keterangan"=>$req->keterangan,
                "tanggal"=>$req->tanggal,
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }

        return redirect()->back();
    }

    public function riwayatkonseling(Request $req){
        $riwayat = PengajuanKonseling::with("konselor")->where("nis_siswa", Auth::user()->nis)->get();
        return 
        view("siswa.riwayatkonseling", ["riwayat"=>$riwayat]);
    }

    public function reservasikonseling(Request $req){
        $reservasikonseling = PengajuanKonseling::where("id_konselor",Auth::user()->id)->with("pengaju");
        if($req->filled("nama")){
            $nama = $req->nama;
            $reservasikonseling = $reservasikonseling->whereHas("pengaju", function($q) use($nama){
                $q->where("nama_siswa","LIKE","%".$nama."%");
            });
        }

        if($req->filled("dari") and  $req->filled("sampai")){
            $dari = Carbon::parse($req->dari)->toDateTimeString();
            $sampai = Carbon::parse($req->sampai)->toDateTimeString();
            $reservasikonseling = $reservasikonseling->whereBetween("tanggal",[$dari, $sampai]);
        }

        if($req->filled("status")){
            $reservasikonseling = $reservasikonseling->where("status", $req->status);
        }

        return view("bk.reservasikonseling", ["reservasikonseling"=>$reservasikonseling->get()]);
    }

    public function tolakreservasi(Request $req){
        $rk = PengajuanKonseling::find($req->id);
        $rk->status = "Ditolak";
        $rk->save();
    }

    public function tanggapireservasi(Request $req){
        $rk = PengajuanKonseling::find($req->id_pk);
        $rk->catatan_konselor = $req->catatan_konselor;
        $rk->tanggal_ck = Carbon::now()->toDateTimeString();
        $rk->status = "Selesai";
        $rk->save();

        Alert::success("Reservasi berhasil ditanggapi");
        return redirect()->back();
    }

    public function ubahjadwalreservasi(Request $req){
        $rk = PengajuanKonseling::find($req->id_pk);
        $rk->tanggal = $req->tanggal;
        $rk->save();
        Alert::success("Jadwal Berhasil diubah");
        return redirect()->back();
    }
}
