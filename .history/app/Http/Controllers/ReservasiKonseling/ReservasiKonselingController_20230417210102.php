<?php

namespace App\Http\Controllers\ReservasiKonseling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillingKonseling;
use App\Models\PengajuanKonseling;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;
use Jad

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

    public function reservasikonseling(Request $req)
    {
        $day = [
            ["label" => "Senin", "lc" => 1],
            ["label" => "Selasa", "lc" => 2],
            ["label" => "Rabu", "lc" => 3],
            ["label" => "Kamis", "lc" => 4],
            ["label" => "Jumat", "lc" => 5],
        ];

        $jadwalkonseling = JadwalKonseling::where("id_konselor", Auth::user()->id)->orderBy("tahun", "desc")->orderBy("bulan", "desc")->orderBy("minggu", "desc");


        if ($req->filled("dari") and $req->filled("sampai")) {
            list($yeardari, $monthdari, $datedari) = explode("-", $req->dari);
            list($yearsampai, $monthsampai, $datesampai) = explode("-", $req->sampai);
            $weekdari = Carbon::parse($req->dari)->weekOfMonth;
            $weeksampai = Carbon::parse($req->sampai)->weekOfMonth;
            $jadwalkonseling->whereBetween("tahun", [$yeardari, $yearsampai])->whereBetween("bulan", [$monthdari, $monthsampai])->whereBetween("minggu", [$weekdari, $weeksampai]);
        }

        $newjadwal = [];

        foreach ($jadwalkonseling->get() as $jk) {
            $hasBooked = DetailJK::where("id_jk", $jk->id_jk)->whereHas("bookedby")->get()->count();
            array_push($newjadwal, ["data" => $jk, "booked" => $hasBooked > 0 ? true : false]);
        }


        return view("profil.index", ["hari" => $day, "jadwalkonseling" => $newjadwal]);
    }
}
