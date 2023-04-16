<?php

namespace App\Http\Controllers\RaportKarakter;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Http\Request;

class RaportKarakterController extends Controller
{
    //PROCEDURE
    public function index(Request $req){
        //Get angkatan/kelas,jurusan
        $kelas = Angkatan::aktif()->get();
        $jurusan = Jurusan::get();

        return view('raportkarakter.index', ['kelas'=>$kelas,'jurusan'=>$jurusan]);
    }


    //API
    public function getpenilailist(Request $req){
        $penilai = User::role(['Guru BK','Guru','Pamong Putra']);

        if($req->filled('nama')){
            $penilai = $penilai->where('name','LIKE','%'.$req->nama."%");
        }
        return json_encode($penilai->get());
    }


    







    //
}
