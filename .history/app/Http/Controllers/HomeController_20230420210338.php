<?php

namespace App\Http\Controllers;

use App\Models\CatatanSikap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Lampiran;

use App\Models\Siswa;
use Illuminate\Support\Carbon;
use App\Models\Kategori;
use App\Models\UserDis;
use Auth;

class HomeController extends Controller
{
    public function beranda(Request $req)
    {
        $kategori = Kategori::all();

        $cs = CatatanSikap::with(["siswa", "penilai", "lampiran"]);
       
        if($req->has("nama")){
           
            $cs = $cs->whereHas("siswa", function($q) use ($req){
                $q->where("nama_siswa","LIKE","%".$req->nama."%");
            });
        }

        if($req->has("dari") and $req->has("sampai")){
            $cs = $cs->whereBetween("tanggal", [Carbon::parse($req->dari)->format("Y-m-d")." 23:59:00",Carbon::parse($req->sampai)->format("Y-m-d")." 23:59:00"]);
        }

        if($req->has("kategori")){
            $cs = $cs->where("id_kategori", $req->kategori);
        }

        $cs = $cs->get();

       // dd($cs);

        $user = UserDis::find(Auth::user()->id);

        return view("beranda.index", ["kategori"=> $kategori, "catatan_sikap" => $cs,"user"=>$user]);
    }

    public function listsiswa(Request $req)
    {
        $siswa = Siswa::where("nama_siswa", "LIKE", "%" . $req->kw . "%")->get();
        return json_encode($siswa);
    }

    public function tambahcatatan(Request $req)
    {
        DB::beginTransaction();

        try {
            $catatansikap = new CatatanSikap();

            $catatansikap->id_penilai = Auth::user()->id;
            $catatansikap->nis_siswa = $req->nis;
            $catatansikap->id_kategori = $req->kategori;
            $catatansikap->visibilitas = "Semua";
            $catatansikap->keterangan = $req->keterangan;
            $catatansikap->tanggal = Carbon::now()->toDateTimeString();

            $catatansikap->save();

            $lampiran = new Lampiran();

            if($req->has("file")){
                $image = $req->file('lampiran');
            $imageName = $catatansikap->id_cs . "_" . date("Y-m-d") . '.' . $image->extension();
            $image->move(public_path('lampiran'), $imageName);

            $lampiran->id_cs = $catatansikap->id_cs;
            $lampiran->nama_file = $imageName;
            $lampiran->save();
            }
            

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th);
        }
        return redirect()->back();
    }
}
