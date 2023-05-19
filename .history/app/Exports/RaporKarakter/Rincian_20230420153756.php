<?php

namespace App\Exports\RaporKarakter;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class Rincian implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view();
    }


}
