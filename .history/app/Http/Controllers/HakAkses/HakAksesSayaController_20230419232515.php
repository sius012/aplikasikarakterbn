<?php

namespace App\Http\Controllers\HakAkses;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\TeacherHasTeaching;
use Illuminate\Http\Request;

class HakAksesSayaController extends Controller
{
    public function index(){
        $hakAkses = TeacherHasTeaching::saya()->get();
        $jurusan = Jurusan::all();
        $angkatan = Ang
        return view('hakaksessaya.index', ['hakakses'=>$hakAkses]);
    }
}
