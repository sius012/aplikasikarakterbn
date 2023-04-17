<?php

namespace App\Http\Controllers\DataSiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use An


class DataSiswaController extends Controller
{
    public function index(Request $req)
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

            if ($p > 0 or in_array($therole, $exceptedRole) or in_array($therole, ["Admin", "Guru BK", "Kepala Sekolah"])) {
                $kelas[$akt->kelas()] =
                    [
                        "angkatan" => $akt->id_angkatan,
                        "jumlahsiswa" => Siswa::where("id_angkatan", $akt->id_angkatan)->count()
                    ];
            }
        }

        //d($kelas);

        return view("datasiswa.index", ["jurusan" => $jurusan, "angkatan" => $angkatan, "kelas" => $kelas, "siswa" => $siswa]);
    }
}
