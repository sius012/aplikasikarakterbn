<?php

namespace App\Http\Controllers\ReservasiKonseling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservasiKonselingController extends Controller
{
    public function reservasikonseling(Request $req)
    {
        $reservasikonseling = new BillingKonseling();
        $reservasikonseling = $reservasikonseling->with("pemesan", "detailjk.jadwal.konselor")->with(["detailjk.jadwal.detail_jk" => function ($q) {
            return "tes";
        }]);


        if ($req->filled("dari") and  $req->filled("sampai")) {
            list($tahundari, $bulandari, $minggudari) = explode("-", $req->dari);
            list($tahunsampai, $bulansampai, $minggusampai) = explode("-", $req->sampai);
            $reservasikonseling = $reservasikonseling->whereHas("detailjk.jadwal", function ($q) use ($tahundari, $tahunsampai, $bulandari, $bulansampai) {
                $q->whereBetween("tahun", [$tahundari, $tahunsampai])->whereBetween("bulan", [$bulandari, $bulansampai]);
            });
        }

        if ($req->filled("status")) {
            $reservasikonseling = $reservasikonseling->where("status", $req->status);
        }

        return view("bk.reservasikonseling", ["reservasikonseling" => $reservasikonseling->get()]);
    }
}
