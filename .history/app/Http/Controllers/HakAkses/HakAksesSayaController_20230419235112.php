<?php

namespace App\Http\Controllers\HakAkses;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\Jurusan;
use App\Models\TeacherHasTeaching;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Alert;

class HakAksesSayaController extends Controller
{
    public function index(){
        $hakAkses = TeacherHasTeaching::saya()->get();
        $jurusan = Jurusan::all();
        $angkatan = Angkatan::aktif()->get();
        return view('hakaksessaya.index', ['hakakses'=>$hakAkses,"jurusan"=>$jurusan,"angkatan"=>$angkatan]);
    }

    public function store(Request $req){
        DB::beginTransaction();
        try {
            $hakAkses = TeacherHasTeaching::create([
                "sebagai"=>$req->sebagai,
                "id_angkatan"=>$req->angkatan,
                "id_jurusan"=>$req->jurusan,
                "dari"=>$req->dari,
                "sampai"=>$req->sampai,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error("Pengajuan gagal",'Permintaan hak Akses gagal dikirim')
        }
    }
}
