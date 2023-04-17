<?php

namespace App\Http\Controllers\ReservasiKonseling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillingKonseling;

class ReservasiKonselingController extends Controller
{
    public function index(Request $req)
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

    public function tolakreservasi(Request $req)
    {
        $rk = PengajuanKonseling::find($req->id);
        $rk->status = "Ditolak";
        $rk->save();
    }

    public function tanggapireservasi(Request $req)
    {
        $rk = PengajuanKonseling::find($req->id_pk);
        $rk->catatan_konselor = $req->catatan_konselor;
        $rk->tanggal_ck = Carbon::now()->toDateTimeString();
        $rk->status = "Selesai";
        $rk->save();

        Alert::success("Reservasi berhasil ditanggapi");
        return redirect()->back();
    }

    public function ubahjadwalreservasi(Request $req)
    {
        $rk = PengajuanKonseling::find($req->id_pk);
        $rk->tanggal = $req->tanggal;
        $rk->save();
        Alert::success("Jadwal Berhasil diubah");
        return redirect()->back();
    }
}
