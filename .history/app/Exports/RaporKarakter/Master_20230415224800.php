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
        $this->listpenilaian = $listpenilaian;
    }

    public function sheets() : array
    {
        $siswa = $this->siswa;

        $sheets = [];
        $sheets["Nama Siswa"] = new NamaSiswa($this->siswa,$this->angkatan,$this->jurusan,1);
        $sheets["Rekap"] = new Rekap($this->listpenilaian);

    
        $sheets["Output"] =new Output($this->listpenilaian);
        foreach($siswa as  $sws){
            $siswa = [$sws];
            $rekaplist = $this->listpenilaian['rekaplist'];
            
            
            $penilaian = $this->listpenilaian;

            $penilaian['rekaplist'] = [];
            foreach($rekaplist as $i => $rk){
                $penilaian[$i]["point"]
                foreach($rk['siswa'] as $j => $rks){
                    if($j == $sws->nis){
                        $penilaian[$i]
                    }
                }
             
            }
            $penilaian["siswa"] = $siswa;
            $sheets[$sws->nama_siswa] = new Output($penilaian);
        }


        return $sheets;

    }

}