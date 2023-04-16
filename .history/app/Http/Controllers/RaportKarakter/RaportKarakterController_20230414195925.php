<?php

namespace App\Http\Controllers\RaportKarakter;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RaportKarakterController extends Controller
{
    public function index(Request $req){}
    public function getpenilailist(Request $req){
        $penilai = User::role(['Guru BK','Guru','Pamong Putra']);

        if($req->filled('nama')){
            $penilai = $penilai->where('name','LIKE','%'.$req->nama."%");
        }
        return json_encode($penilai->get());
    }
}
