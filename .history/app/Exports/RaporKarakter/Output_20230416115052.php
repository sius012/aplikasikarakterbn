<?php

namespace App\Exports\RaporKarakter;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class Output implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $listpenilaian;

    public function __construct($listpenilaian)
    {
        $this->listpenilaian = $listpenilaian;
    }
    public function view() : View
    {
        return view('outputeraport.output', $this->listpenilaian);
    }
}
