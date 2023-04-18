<?php

namespace App\Http\Controllers\DataSiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenilaianGuru;
use Auth;
use App\Models\Aspek4B;
use App\Models\AspekDPG;
use App\Models\DetailPG;
use App\Models\Jurusan;
use App\Models\Angkatan;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use App\Imports\Raport;
use Maatwebsite\Excel\Facades\Excel;

class RKGController extends Controller
{
    public function eraportkelas($angkatan, $jurusan)
    {
        $pg = PenilaianGuru::with("detail_pg")->where("id_penilai", Auth::user()->id)->get();
        $kelas = Siswa::where("id_angkatan", $angkatan)->where("id_jurusan", $jurusan)->first()->kelasdanjurusan();

        $params = $angkatan . ":" . $jurusan;

        $eraport = PenilaianGuru::where("id_penilai", Auth::user()->id)->where("id_angkatan", $angkatan)->where("id_jurusan", $jurusan)->get();


        return view("eraport.raportkelas", ["penilain_guru" => $pg, "kelas" => $kelas, "params" => $params, "eraport" => $eraport]);
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

       // dd($rows);
        $finallyRow = null;
        $bulan = ltrim(date("m", strtotime($req->tanggal)), 0);
        //Valdasi rentang waktu

        $tablevalidasi["Rentang Waktu Penilaian"] = PenilaianGuru::whereMonth("tanggal_penilaian", $bulan)->whereYear("tanggal_penilaian", date("Y", strtotime($req->tanggal)))->where("id_penilai", Auth::user()->id)->where("id_angkatan", $param[0])->where("id_jurusan", $jurusanril->id_jurusan)->count() > 0 ? false : true;

        foreach ($rows as $i => $rws) {
            if (isset($rws[3][1])) {
                $tablevalidasi["Letak Kolom Kelas dan Jurusan"] = true;
                $kelasclear = trim(str_replace(":", "", $rws[3][1]));
                $kelasclear = explode(" ", $kelasclear);
                $kelas =  roman_to_decimal($kelasclear[0]);
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
          //  echo ($namasiswa->nama_siswa);
            $aspeks[$ls["no_aspek"] . ":" . $ls["no_subpoint"] . ":" . $ls["no_point"]]["aspek"] = $aspek->keterangan;
            $aspeks[$ls["no_aspek"] . ":" . $ls["no_subpoint"] . ":" . $ls["no_point"]]["point"] = $aspek->point;
            $aspeks[$ls["no_aspek"] . ":" . $ls["no_subpoint"] . ":" . $ls["no_point"]]["subpoint"] = $aspek->subpoint;

            $aspeks[$ls["no_aspek"] . ":" . $ls["no_subpoint"] . ":" . $ls["no_point"]]["siswa"][$ls["no_absen"]]["nama"] = $namasiswa->nama_siswa;
            $aspeks[$ls["no_aspek"] . ":" . $ls["no_subpoint"] . ":" . $ls["no_point"]]["siswa"][$ls["no_absen"]]["nilai"] = $ls["nilai"];
        }



        return view("outputeraport.eraportkelas", ['table' => $tablevalidasi, "aspek" => $aspeks, "kelas" => date("Y") -  $angkatan->tahun_mulai + 9, "jurusan" => $jurusanril->jurusan, "tanggal" => $req->tanggal, "keterangan" => $keterangan]);
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
                if (!hasNumber((string) $row[0])) {
                    if ($i != 7) {
                        if (hasNumber((string) $rows[$i - 1][0])) {

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

                        if (hasNumber((string) $rows[$i - 1][0]) and $rows[$i][0] == "Keterangan") {

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

    public function hapusRKG($id){
        $pg = PenilaianGuru::with("detail_pg")->find($id);
        $dpg = DetailPG::with("aspek_dpg")->where("id_pg",$id)->first();

       // dd($pg);
        if($pg->id_penilai == Auth::user()->id){
          //  dd($pg->detail_pg);
            $dpg->aspek_dpg()->delete();
            $pg->detail_pg()->delete();
            $pg->delete();
        }
    }
}
