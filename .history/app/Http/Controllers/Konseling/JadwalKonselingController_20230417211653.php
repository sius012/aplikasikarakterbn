<?php

namespace App\Http\Controllers\Konseling;

use App\Http\Controllers\Controller;
use App\Models\DetailJK;
use Illuminate\Http\Request;
use App\Models\JadwalKonseling;
use App\Models\BillingKonseling;
use 

class JadwalKonselingController extends Controller
{
    public function storejadwal(Request $req)
    {
        // dd($req);


        //Check Existed Schedule
        $jml = JadwalKonseling::where('bulan', $req->bulan)->where('minggu', $req->minggu)->get()->count();
        if ($jml < 1) {
            DB::beginTransaction();
            try {
                //Check Jadwal

                $jadwal = new JadwalKonseling();
                $jadwal->id_konselor = Auth::user()->id;
                $jadwal->keterangan = $req->keterangan;
                $jadwal->minggu = $req->minggu;
                $jadwal->bulan = $req->bulan;
                $jadwal->tahun = date("Y");
                $jadwal->status = "Berjalan";

                $jadwal->save();

                foreach ($req->jadwal as $i => $jwl) {
                    foreach ($jwl as $j => $djk) {
                        $date = getDates($i, $req->minggu, $req->bulan, date("Y"));
                        $djk = DetailJK::create([
                            "id_jk" => $jadwal->id_jk,
                            "hari" => ucwords($i),
                            "pertemuan_ke" => $j + 1,
                            "dari" => $djk["dari"],
                            "sampai" => $djk["sampai"],
                            "tanggal" => $date . " " . $djk["dari"]
                        ]);
                    }
                }

                DB::commit();
                return redirect()->back();
            } catch (\Throwable $th) {
                DB::rollBack();
                dd($th);
            }
        } else {
            Alert::error('Jadwal Telah ada sebelumnya', 'anda hanya bisa membuat satu jadwal dalam satu minggu');
            return redirect()->back();
        }
    }

    public function updatejadwal(Request $req)
    {
        $jk = JadwalKonseling::find($req->id_jk);
        $jk->bulan =  $req->bulan;
        $jk->minggu = $req->minggu;
        $jk->keterangan = $req->keterangan;
        $jk->save();
        foreach ($req->djk as $i => $j) {
            $djk = DetailJK::find($i);
            $djk->hari = $j['hari'];
            $djk->dari = $j['dari'];
            $djk->sampai = $j['sampai'];
            $djk->save();
        }

        Alert::success("Berhasil diperbarui");
        return redirect()->back();
    }

    public function selesaireservasi(Request $req)
    {
        $bk = BillingKonseling::find($req->id_bk);
        $bk->catatan_konselor = $req->keterangan;
        $bk->tempat = $req->tempat;
        $bk->pdg = $req->pdg;
        $bk->status = "Selesai";
        $bk->save();
        return redirect()->back();
        dd($bk);
    }

    public function lihatjadwal($id)
    {
        $jk = [];
        $jk["jadwal_konseling"] = JadwalKonseling::find($id);
        $jk["detail"] = DetailJK::with("bookedby.pemesan")->withCount("bookedby")->where("id_jk", $id)->orderBy("hari", "asc")->orderBy("dari", "asc")->get()->groupby("hari");

        $siswa = Siswa::whereHas("billing.detailjk", function ($q) use ($id) {
            $q->where("id_jk", $id);
        })->get();

        //list sesi 
        $selesai = BillingKonseling::whereHas("detailJK", function ($q) use ($id) {
            $q->where("id_jk", $id);
        })->where("status", "Selesai");

        $reschedule = BillingKonseling::whereHas("detailJK", function ($q) use ($id) {
            $q->where("id_jk", $id);
        })->where("status", "Reschedule");

        $menunggu = BillingKonseling::whereHas("detailJK", function ($q) use ($id) {
            $q->where("id_jk", $id);
        })->where("status", "Dipesan");

        //dd($menunggu->get());
        return view("bk.lihatjadwal", ["jadwalkonseling" => $jk, "siswa" => $siswa, "status" => ['selesai' => $selesai->count(), "reschedule" => $reschedule->count(), "dipesan" => $menunggu->count()]]);
    }

    public function lihatdetailjadwal(Request $req)
    {
        $detailjadwal = DetailJK::find($req->id);
        return json_encode($detailjadwal);
    }

    public function editdetailjadwal(Request $req)
    {
        $detailjadwal = DetailJK::find($req->id_djk);
        $detailjadwal->hari = $req->hari;
        $detailjadwal->dari = $req->dari;
        $detailjadwal->sampai = $req->sampai;
        $detailjadwal->keterangan_reschedule = $req->keterangan_reschedule;
        $detailjadwal->save();
        $bk = BillingKonseling::where("id_djk", $req->id_djk)->first();
        $bk->status = "Reschedule";
        $bk->save();

        return redirect()->back();
    }
}
