<?php

namespace App\Http\Controllers\RaportKarakter;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RaportKarakterController extends Controller
{
    public function getpenilailist(Request $req){
        $penilai = User::role(['Guru BK'])->get();
        dd($penilai);
    }
}
