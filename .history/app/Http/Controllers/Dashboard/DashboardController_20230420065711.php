<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\Angkatan;
use App\Models\Kategori;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $req)
    {
        $kategori = Kategori::all();

        foreach($kategori as $k =>$ktg){
            
        }
        $jurusan = Jurusan::whereHas("siswa.angkatan", function ($q) {
            $q->where(DB::raw("tahun_mulai + 2"), ">", date("Y"));
        })->withCount(["siswa" => function ($q) {
            $q->whereHas('catatan_sikap.kategori', function ($j) {
                $j->where("kategori", "Merokok");
            });
        }])->with(["siswa" => function ($q) {
            $q->whereHas('catatan_sikap.kategori', function ($j) {
                $j->where("kategori", "Merokok");
            });
        }])->get();

        $jurusan = $jurusan->map(function ($jurusan) {
            return [
                "jurusan" => $jurusan,
                "angkatan" => $jurusan->siswa->groupBy('id_angkatan')
            ];
        });

        // dd($jurusan);

        //Metode Angkatan;

        $angkatan = Angkatan::where(DB::raw("tahun_mulai + 3
       "), "<", date("Y") + 3)->where(DB::raw("tahun_mulai + 3
       "), ">", date("Y"))->orWhere(
            function ($q) {
                $q->where("tahun_mulai", date("Y") - 3)->where("bulan_mulai", ">", Carbon::now()->month);
            }
        )->orWhere(
            function ($q) {
                $q->where("tahun_mulai", date("Y"))->where("bulan_mulai", "<=", Carbon::now()->month);
            }
        )->with(["siswa.catatan_sikap.kategori" => function ($q) {
            $q->where("kategori", "Merokok");
        }])->get();

        $angkatan = $angkatan->map(function ($akt) {
            $jurusan = [];
            $jumlahpelaku = [];

            foreach ($akt->siswa->groupBy("id_jurusan") as $i => $jrs) {
                $namajurusan = Jurusan::find($i)->jurusan;
                array_push($jurusan, $namajurusan);

                $jml = $jrs->map(function ($q) {
                    if ($q->catatan_sikap != null) {
                        if ($q->catatan_sikap->count() > 0) {
                            return 1;
                        } else {
                            return 0;
                        };
                    } else {
                        return 0;
                    }
                });

                array_push($jumlahpelaku, array_sum($jml->toArray()));
            }
            return [
                "labelJurusan" => $jurusan,
                "jumlahpelaku" => $jumlahpelaku,
            ];
        });

        if ($req->has("requestJson")) {

            return json_encode($angkatan);
        } else {
            return view("dashboard.index");
        }
    }
}
