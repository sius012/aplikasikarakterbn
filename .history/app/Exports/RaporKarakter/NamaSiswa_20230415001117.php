<?php

namespace App\Exports\RaporKarakter;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NamaSiswa implements FromView
{
    private $daftarsiswa;
    private $kelas;
    private $jurusan;
    private $semester;

    public function __construct($daftarsiswa,$kelas,$jurusan,$semester)
    {
        $this->daftarsiswa = $daftarsiswa;
        $this->kelas = $kelas;
        $this->jurusan= $jurusan;
        $this->semester= $semester;
    }

    public function view() : View
    {
        return view('outpur.namasiswa', ['siswa'=>$this->daftarsiswa, "kelas"=>$this->kelas, "jurusan"=>$this->jurusan, "semester"=>$this->semester]);
    }

}
