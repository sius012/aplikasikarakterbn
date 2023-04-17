<?php

namespace App\Http\Controllers\DataSiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenilaianGuru;
use Auth;
use App\Models\Aspek4B;
use App\Models\AspekDPG;
use App

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

}
