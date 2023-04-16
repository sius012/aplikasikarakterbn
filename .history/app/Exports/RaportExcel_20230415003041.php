<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RaportExcel implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection() : View
    {
        return view('excel.raportsiswa');
    }
}
