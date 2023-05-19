<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\Angkatan;
use App\Models\Kategori;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;

class DashboardController extends Controller
{
    public function index(Request $req)
    {
        $kategori = Kategori::all();

        $case = [];

        foreach($kategori as $k =>$ktg){
            $jurusan = Jurusan::whereHas("siswa.angkatan", function ($q) {
                $q->where(DB::raw("tahun_mulai + 2"), ">", date("Y"));
            })->withCount(["siswa" => function ($q) {
                $q->whereHas('catatan_sikap.kategori', function ($j) {
                    $j->where("kategori", "Merokok");
                });
            }])->with(["siswa" => function ($q) use($req,$ktg){
                $q->whereHas('catatan_sikap', function ($j) use($req,$ktg) {
                    $j->where("id_kategori", $ktg->id_kategori);

                    if($req->has('bulan')){
                        $j->whereMonth("tanggal", Carbon::parse($req->bulan)->month)->whereYear("tanggal", Carbon::parse($req->bulan)->year);
                     }else{
                        $j->whereMonth("tanggal", Carbon::now()->month)->whereYear("tanggal", Carbon::now()->year);
                     }
                    
                });

                
            }]);

            //FilterJurusan
            

            $jurusan = $jurusan->get();



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
            )->with(["siswa.catatan_sikap" => function ($j) use ($req,$ktg){
                $j->where("id_kategori", $ktg->id_kategori);
                if($req->has('bulan')){
                    $j->whereMonth("tanggal", Carbon::parse($req->bulan)->month)->whereYear("tanggal", Carbon::parse($req->bulan)->year);
                 }else{
                    $j->whereMonth("tanggal", Carbon::now()->month)->whereYear("tanggal", Carbon::now()->year);
                 }
            }])->get();

            $labeljurusan = Jurusan::whereHas("siswa.angkatan", function($q){
                $q->aktif();
            })->get();

            $labeljurusan = $labeljurusan->map(function($q){
                return $q->jurusan;
            });
    
            $angkatan = $angkatan->map(function ($akt,$j) use($ktg, $angkatan,$case) {
                $jurusan = [];
                $jumlahpelaku = [];
                //dd($akt->siswa->groupBy("id_jurusan"));
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
                return ["kelas"=>$akt->kelas(),"index"=>$j,"jeniskasus"=>$ktg->kategori,"id_kasus"=>$ktg->id_kategori,"data"=>["jurusan"=>$jurusan,"jumlah"=>$jumlahpelaku]];
            });
            
            foreach ($angkatan as $i => $akt) {
                array_push($case, $akt);
            }

        }


       //dd($case);

       $data = $this->jumlahSiswaKelas();
       dd($data);

        if ($req->has("requestJson")) {
    
            return json_encode($case);
        } else {
            return view("dashboard.index");
        }
        
    }

    public function jumlahSiswaKelas($kelas=null){
        $kelas = Angkatan::aktif()->get();
        if($kelas!=null){
        
        }

        $kelas = $kelas->map(function($e){
            $siswa = Siswa::where("id_angkatan",$e->id_angkatan)->get()->count();
            $jurusan = Jurusan::whereHas("siswa", function($q)use($e){
                $q->where("id_angkatan",$e->id_angkatan);
            })->get()->pluck("jurusan")->toArray();
            $count = Jurusan::withCount("siswa")->whereHas("siswa", function($q)use($e){
                $q->where("id_angkatan",$e->id_angkatan);
            })->get();
            $count = $count->map(function($q))
           
            return [
                'kelas'=> $e->kelas(),
                'label'=>$jurusan,
                'jumlah'=>$count
            ];
        });

        return $kelas->toArray();

    }
}
