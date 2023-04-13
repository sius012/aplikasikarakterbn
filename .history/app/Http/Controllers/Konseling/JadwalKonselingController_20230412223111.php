<?php

namespace App\Http\Controllers\Konseling;

use App\Http\Controllers\Controller;
use App\Models\DetailJK;
use Illuminate\Http\Request;
use App\Models\JadwalKonseling;

class JadwalKonselingController extends Controller
{
    public function hapus(Request $req){
        $jadwal = JadwalKonseling::with("detail_jk.bookedby")->find($req->id);
        $djk = DetailJK::where("id_jk",$req->id)->delete();
       // $jadwal->detail_jk->delete();
        $jadwal->delete();
    }
}
