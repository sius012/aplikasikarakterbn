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

    private $listpenilaian;
    private $listsiswa;

    public function __construct($listpenilaian,$listsiswa)
    {
        $this->listpenilaian = $listpenilaian;
        $this->listsiswa = $listsiswa;
    }
    public function view() : View
    {
        return view('outputeraport.rekapraportkarakter', $this->$listpenilaian);
    }
}
