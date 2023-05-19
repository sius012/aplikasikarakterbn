<?php

namespace App\Http\Controllers\HakAkses;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\Jurusan;
use App\Models\TeacherHasTeaching;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;

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
                "id_guru"=>Auth::user()->id,
                "sebagai"=>$req->sebagai,
                "id_angkatan"=>$req->angkatan,
                "id_jurusan"=>$req->jurusan,
                "dari"=>$req->dari,
                "sampai"=>$req->sampai,
            ]);

            DB::commit();
            Alert::success("Pengajuan Berhasil","admin akan memproses permintaan anda");
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            Alert::error("Pengajuan gagal",'Permintaan hak Akses gagal dikirim');
        }
        return redirect()->back();
    }

    public function destroy($id){
        $ha = TeacherHasTeaching::findOrFail($id);
        $ha->delete();
        return redirect()->back()
    }
}
