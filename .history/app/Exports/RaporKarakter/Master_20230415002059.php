<?php

namespace App\Exports\RaporKarakter;


use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\Angkatan;
use App\Models\Jurusan;

class Master implements WithMultipleSheets
{
    use Exportable;

    private $siswa;
    private $angkatan;
    private $jurusan;
    private $listpenilaian;
    private $semester;

    public function __construct($listpenilaian)
    {
        $this->angkatan = $listpenilaian["kelas"];
        $this->jurusan = $listpenilaian["jurusan"];
        $this->siswa = $listpenilaian["siswa"];
    }

    public function sheets() : array
    {
   

        $sheets = [];
        $sheets["Nama Siswa"] = new NamaSiswa($this->siswa,$this->angkatan->kelas(),$this->jurusan,1);
        return $sheets;

    }

}