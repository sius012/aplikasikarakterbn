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
use Maatwebsite\Excel\Excel;
use App\Models\Siswa;

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
}