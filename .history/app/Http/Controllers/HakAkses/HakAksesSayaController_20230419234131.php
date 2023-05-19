<?php

namespace App\Http\Controllers\HakAkses;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\Jurusan;
use App\Models\TeacherHasTeaching;
use Illuminate\Http\Request;

class HakAksesSayaController extends Controller
{
    public function index(){
        $hakAkses = TeacherHasTeaching::saya()->get();
        $jurusan = Jurusan::all();
        $angkatan = Angkatan::aktif()->get();
        return view('hakaksessaya.index', ['hakakses'=>$hakAkses,"jurusan"=>$jurusan,"angkatan"=>$angkatan]);
    }

    public function store(Request $req){
    
    }
}
