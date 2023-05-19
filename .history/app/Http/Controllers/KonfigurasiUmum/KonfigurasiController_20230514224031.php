<?php

namespace App\Http\Controllers\KonfigurasiUmum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\Angkatan;
use App\Models\Aspek4B;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use App\Models\TeacherHasTeaching;
use App\Models\User;
use App\Models\Siswa;

class KonfigurasiController extends Controller
{
    public function index(Request $req)
    {
        return view("konfigurasiumum.index");
    }

    public function konfigurasijurusan(Request $req)
    {
        $jurusan = Jurusan::all();
        return view("konfigurasiumum.konfigurasijurusan", ["jurusan" => $jurusan]);
    }

    public function tambahjurusan(Request $req)
    {
        $check = Jurusan::where("jurusan", $req->jurusan)->get();
        if ($check->count() < 1) {

            $jurusan = Jurusan::create([
                'jurusan' => $req->jurusan,
                "keterangan" => $req->keterangan,
            ]);
        }
        return redirect()->back();
    }

    public function konfigurasiangkatan(Request $req)
    {
        $angkatan = Angkatan::all();
        return view("konfigurasiumum.konfigurasiangkatan", ["angkatan" => $angkatan]);
    }

    public function tambahangkatan(Request $req)
    {
        $angkatan = Angkatan::find($req->angkatan);
        if ($angkatan) {
            return redirect()->back();
        } else {
            $angkatan = Angkatan::create([
                'id_angkatan' => $req->angkatan,
                "tahun_mulai" => $req->tahun_mulai,
                "tahun_selesai" => $req->tahun_selesai,
            ]);

            return redirect()->back();
        }
    }
    
    public function getAngkatan(Request $req){
        $angkatan = Angkatan::find($req->id);
        return json_encode($angkatan);
    }

    public function editAngkatan(Request $req){
        //Mencari ketersediaan angkatan
        $angkatanCount = Angkatan::find($req->angkatan);
        if($angkatanCount != null){
            
        }
    }


    public function konfigurasikategori(Request $req)
    {
        if ($req->has("requestJson")) {
            $dataaspek = Aspek4B::all()->groupBy("point");
            $das = [];

            foreach ($dataaspek as $i => $da) {
                array_push($das, [
                    'point' => $i,
                    'aspek' => $da
                ]);
            }
            return json_encode($das);
        }

        $kategori = Kategori::all();
        $kategori = $kategori->map(function ($ktr) {
            $aspek = explode(',', $ktr->aspek_berkaitan);
            $asp = Aspek4B::whereIn('id_aspek', $aspek)->get()->groupBy('point');
            return ['kategori' => $ktr, 'aspek' => $asp];
        });

        return view('konfigurasiumum.konfigurasikategori.index', ['kategori' => $kategori]);
    }

    public static function kategori(array $params)
    {
        // $point = Aspek4B::get()->groupBy("no_point");

        // $newpoint = [];

        // foreach($point as $i => $ps){
        //     $newpoint[$i]["point"] = $ps[0];
        //     $subpoint = Aspek4B::where("no_point", $ps[0]->no_point)->get()->groupBy("no_subpoint");
        //     foreach($subpoint as $j => $sp){
        //         $aspek = Aspek4B::where("no_point", $ps[0]->no_point)->where("no_subpoint",$sp[0]->no_subpoint)->get();
        //         foreach($aspek as $k =>$ask){
        //             $newpoint[$i]["subpoint"][$j][$k] = $ask;

        //         }

        //     }
        // }

        // return $newpoint;

        $kategori = new Kategori;

        if (isset($params["tindakan"])) {
            $kategori = $kategori->where("tindakan", $params["tindakan"]);
        }

        $newkategori = [];

        foreach ($kategori->get() as $i => $ktg) {
            $aspekterkait = Aspek4B::whereIn("id_aspek", explode(",", $ktg->aspek_berkaitan))->get();
            $newkategori[$i]["ktg"] = $ktg;
            $newkategori[$i]["aspek_terkait"] = $aspekterkait;
        }

        return $newkategori;
    }

    public function tambahkategori(Request $req)
    {
        $kategori = $req->kategori;
        $tindakan = $req->tindakan;
        $aspekterkait = '';

        foreach ($req->id_aspek as $i => $ids) {
            $aspekterkait .= $ids . (isset($req->id_aspek[$i + 1]) ? "," : '');
        }

        DB::beginTransaction();
        try {
            $kategories = Kategori::create([
                'kategori' => $kategori,
                'tindakan' => $tindakan,
                'aspek_berkaitan' => $aspekterkait,
                'nilai' => $req->tindakan == 'Positif' ? 4 : 1
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }

        return redirect()->back();
    }


    public function hakakseskelas($id)
    {
        $user = User::find($id);


        $angkatan = Angkatan::all();
        $jurusan = Jurusan::all();

        switch ($user->getRoleNames()[0]) {
            case 'Pamong Putri':
                dd("AKUN INI AKUN PAMONG PUTRI");
                break;

            case 'Pamong Putra':
                dd("AKUN INI AKUN PAMONG PUTRA");
                break;

            case 'Guru BK':
                dd("AKUN INI AKUN GURU BK");
                break;

            case 'Guru' || 'Wali Kelas' || 'K3':
                $hakakses = TeacherHasTeaching::where("id_guru", $id)->get();
                $hakakses = $hakakses->map(function($e){
                    $e->kelas = $e->angkatan();
                    $e->jurusan = $e->jurusan();
                    $e->agama = $e->agama();
                    return $e;
                });
                return view('konfigurasiumum.konfigurasipengguna.guru', ["hakakses"=>$hakakses,"user"=>$user,"id"=>$user->id,"angkatan"=>$angkatan,"jurusan"=>$jurusan]);
                break;

            case 'Kepala Sekolah':
                dd("AKUN INI AKUN KEPALA SEKOLAH");
                break;

            case 'Admin':
                dd("AKUN INI AKUN ADMIN");
                break;

            default:
                # code...
                break;
        }

      //  return view("konfigurasiumum.konfigurasipengguna.hakakses", ["id" => $id, "hakakses" => $hakases, "angkatan" => $angkatan, "jurusan" => $jurusan, "user" => $user]);
    }

    public function tambahhakakseskelas(Request $req)
    {
        $angkatan = "";
        $jurusan = '';
        $agama = '';
        
        //isi angkatan
        if(!$req->filled('semua_angkatan')){
            if($req->filled('angkatan')){
                foreach($req->angkatan as $a => $akt){
                    $angkatan .= $akt;
                    if(isset($req->angkatan[$a+1])){
                        $angkatan.=",";
                    }
                }
            }else{
                return redirect()->back()->with('error', 'kolom angkatan harap diisi (perhatikan juga kolom yang lainnya)');
            }
        }else{
            $angkatan = 'semua';
        }
        

        //isi jurusan
        if(!$req->filled('semua_jurusan')){
        if($req->filled('jurusan')){
            foreach($req->jurusan as $j => $jrs){
                $jurusan .= $jrs;
                if(isset($req->jurusan[$j+1])){
                    $jurusan.=",";
                }
            }
        }else{
            return redirect()->back()->with('error', 'kolom jurusan harap diisi (perhatikan juga kolom yang lainnya)');
        }
        }else{
            $jurusan = 'semua';
        }

        //isi agama
        if(!$req->filled('semua_agama')){
        if($req->filled('agama')){
            foreach($req->agama as $ag => $agm){
                $agama .= $agm;
                if(isset($req->agama[$ag+1])){
                    $agama.=",";
                }
            }
        }else{
            return redirect()->back()->with('error', 'kolom agama harap diisi (perhatikan juga kolom yang lainnya)');
        }

        }else{
            $agama= 'semua';
        }

        
        

        DB::beginTransaction();
        try {
            $hakakses = TeacherHasTeaching::create([
                "id_guru" => $req->id_user,
                "id_angkatan" => $angkatan,
                "id_jurusan" => $jurusan,
                "dari" => $req->dari,
                "sampai" => $req->sampai,
                "sebagai" => $req->sebagai,
                "agama"=>$agama,
                "jenis_kelamin"=>$req->jk
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }

        return redirect()->back();
    }


    function konfigurasihakakses(Request $req){
         return view("konfigurasiumum.konfigurasihakakses.index");
    }


    function getaj(Request $req){
        switch ($req->params) {
            case 'angkatan':
                $jurusan = Angkatan::where("id_angkatan","LIKE","%".$req->key."%")->get();
                return json_encode($jurusan);
                break;

            case 'jurusan':
                $jurusan =  Jurusan::where("jurusan","LIKE","%".$req->key."%")->orwhere("keterangan","LIKE","%".$req->key."%")->get();
                return json_encode($jurusan);
                break;

            case 'agama':
                $agama = Siswa::where("agama","LIKE","%".$req->key."%")->get()->groupBy("agama");
                $agamaarr = [];
                foreach($agama as $i  => $agm){
                    array_push($agamaarr, $i);
                }

                return json_encode($agamaarr);
            
            default:
                # code...
                break;
        }
    }

}
