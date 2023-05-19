<?php

namespace App\Exports\RaporKarakter;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class Rincian implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $listpenilaian;

    public function __construct($listpenilaian)
    {
        $this->listpenilaian = $listpenilaian;
    }


    public function view(): View
    {
        return view("outputeraport.");
    }


}
