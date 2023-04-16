<?php

namespace App\Http\Controllers\RaportKarakter;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\Jurusan;
use App\Models\User;
use App\Models\Siswa;
use App\Models\AspekDPG;
use App\Models\Aspek4B;
use App\Models\PenilaianGuru;
use Illuminate\Http\Request;
use App\Models\UserDis;
use RealRashid\SweetAlert\Facades\Alert;

class RaportKarakterController extends Controller
{
    //PROCEDURE
    public function index(Request $req)
    {
        //Get angkatan/kelas,jurusan
        $kelas = Angkatan::aktif()->get();
        $jurusan = Jurusan::get();


     
        return view('raportkarakter.index', ['kelas' => $kelas, 'jurusan' => $jurusan]);
    }

    public function generateeraportkarakter(Request $req){
        $params = [];
        $params["angkatan"] = $req->angkatan;
        $params["jurusan"] = $req->jurusan;
        $params["dari"] = $req->dari;
        $params["sampai"] = $req->sampai;


        if($req->filled('semuaguru')){
            $params["semua"] = true;
        }else{
            $params["semua"] = false;
           
            $params["listguru"] = $req->listguru;
            if($params["listguru"]==null){
                Alert::error("Gagal", "Dimohon untuk menginputkan list penilai");
                return redirect()->back();
            }
        }
        
        $rekaprk = $this->rekaperaportdetail($params);
        resp
        return view('eraport.rekaperaportdetail', $rekaprk);

        dd($rekaprk);
  
    }

    //FUNCTION
    public function getpenilailist(Request $req)
    {
        $penilai = User::role(['Guru BK', 'Guru', 'Pamong Putra']);

        if ($req->filled('nama')) {
            $penilai = $penilai->where('name', 'LIKE', '%' . $req->nama . "%");
        }

        return json_encode($penilai->get());
    }

    public function rekaperaportdetail(array $params)
    {
        $angkatan = $params["angkatan"];
        $jurusan = $params['jurusan'];
        $dari = $params['dari'];
        $sampai = $params['sampai'];
        $semua = $params['semua'];


        $siswa = Siswa::where("id_angkatan", $angkatan)->where("id_jurusan", $jurusan)->orderBy("no_absen", "asc")->get();
        $aspek4b = Aspek4B::all();
        $kelas = Angkatan::find($angkatan)->kelas();
        $jurusan = Jurusan::find($jurusan);

        $gurubersangkutan = UserDis::get();
        if ($semua == false) {
            $gurubersangkutan =  UserDis::whereIn('id', $params['listguru'])->get();
        }


        //  dd($aspek4b);

        $rekaplist = [];

        foreach ($aspek4b as $j => $asp4b) {

            foreach ($siswa as $s => $sws) {
                $nis = $sws->nis;

                $listpenilaian = [];

                //Guru
                foreach ($gurubersangkutan as $gb) {
                    $query = AspekDPG::where("id_aspek", $asp4b->id_aspek)->whereHas("detailPG.siswa", function ($q) use ($sws) {
                        $q->where("nis_siswa", $sws->nis);
                    })->whereHas("detailPG.parent", function ($q) use ($dari, $sampai) {
                        $q->whereBetween("tanggal_penilaian", [$dari, $sampai]);
                    })->whereHas("detailPG.parent.penilai", function ($q) use ($gb) {
                        $q->where('id', $gb->id);
                    });

                    $data = $query->get()->count();
                    if ($data > 0) {
                        array_push($listpenilaian, [
                            "data" => $query,
                            "average" => $query->sum('nilai') / $query->get()->count()
                        ]);
                    }
                }

                $countpenilai = 0;
                $totalpenilaian = 0;

                foreach ($listpenilaian as $lp) {
                    $countpenilai += 1;
                    $totalpenilaian += $lp['average'];
                }

                $rata2penilaian = ($countpenilai < 1 or $totalpenilaian < 1 )? 0 : ($totalpenilaian / $countpenilai);


                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["point"] = $asp4b->point;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["subpoint"] = $asp4b->subpoint;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["aspek"] = $asp4b->keterangan;

                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["data"] = $sws;

                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["nilai_sekolah"]['count'] = $countpenilai;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["nilai_sekolah"]['jumlah'] = $totalpenilaian;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["nilai_sekolah"]['jumlah_akumulatif'] = $rata2penilaian;
            }
        }


        return ["siswa" => $siswa, "rekaplist" => $rekaplist, "kelas" => $kelas, "jurusan" => $jurusan->jurusan];
    }








    //
}
