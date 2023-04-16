<?php

namespace App\Exports\RaporKarakter;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class Rekap implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    
    public function view() : View
    {
        return view('outputeraport.listsiswa', ['siswa'=>$this->daftarsiswa, "kelas"=>$this->kelas, "jurusan"=>$this->jurusan, "semester"=>$this->semester]);
    }
}
