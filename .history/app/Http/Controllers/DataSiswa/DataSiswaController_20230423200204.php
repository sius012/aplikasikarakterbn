<?php

namespace App\Http\Controllers\DataSiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Angkatan;
use App\Models\Jurusan;
use Auth;
use App\Models\TeacherHasTeaching;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;
use App\Imports\SiswaImport;
use App\Models\AlamatSiswa;
use App\Models\BillingKonseling;
use App\Models\CatatanSikap;
use App\Models\DetailPG;
use App\Models\DetailSiswa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Database\Eloquent\Scope;
use Image;

class DataSiswaController extends Controller
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('naikkelas', function (Builder $builder) {
            $builder->where('id_ca', 5);
        });
    }


    public function index(Request $req)
    {
        $siswa = Siswa::all();

        $angkatan = Angkatan::aktif()->get();

        $angkatanAll = Angkatan::all();

        $jurusan = Jurusan::all();

        $angkatanList = [
            date("Y") - 2011, date("Y") - 2011 - 1, date("Y") - 2011 - 2
        ];

        $therole = Auth::user()->getRoleNames()->first();

        $exceptedRole = [
            "Pamong Putra", "Kepala Sekolah", "Kesiswaan", "Pamong Putri", "Admin",
        ];

        $permission =  TeacherHasTeaching::where("id_guru", auth()->user()->id);

        $kelas = [];

        foreach ($angkatan as $i => $akt) {
            $p = $permission->where("id_angkatan", $akt->id_angkatan)->count();

            if ($p > 0 or in_array($therole, $exceptedRole) or in_array($therole, ["Admin", "Guru BK", "Kepala Sekolah"])) {
                $kelas[$akt->kelas()] =
                    [
                        "angkatan" => $akt->id_angkatan,
                        "jumlahsiswa" => Siswa::where("id_angkatan", $akt->id_angkatan)->count()
                    ];
            }
        }

        //d($kelas);

        return view("datasiswa.index", ["jurusan" => $jurusan, "angkatan" => $angkatan, "kelas" => $kelas, "siswa" => $siswa, "angkatanall"=>$angkatanAll]);
    }

    public function datajurusan($angkatan)
    {
        $roles = Auth::user()->getRoleNames();

        $user = Auth::user();
        $jurusan = Siswa::where("id_angkatan", $angkatan)->with("jurusan");
        if (in_array($roles[0], ["Guru", "Wali Kelas", "K3"])) {
            $jurusan = $jurusan->whereHas("jurusan.hakakses", function ($q) use ($user) {
                $q->where("id_guru", $user->id);
            });
        }


        //    dd();
        $jurusan = $jurusan->get()->groupBy("id_jurusan");

        $jurusan = $jurusan->map(function ($e, $i) use ($angkatan) {
            //Mendapatkan Role
            $role = Auth::user()->getRoleNames()->toArray();

            $visibility = checkClassPermission(["angkatan" => $angkatan, "jurusan" => $i, "auth" => auth()]);


            return ["data" => $e, "visibility" => $visibility];
        });

        $jurusanall = Jurusan::all();
        return view("datasiswa.datajurusan", ["jurusan" => $jurusan, "angkatan" => $angkatan, "jurusanall" => $jurusanall]);
    }

    public function tambahsiswa(Request $req)
    {
        $siswa = $req;
  
        DB::beginTransaction();
        try {
            $find = Siswa::find($siswa['nis']);

           
            if (!$find) {
                $datasiswa = Siswa::create([
                    "nama_siswa"=>$req->nama_siswa,
                    "nis"=>$siswa->nis,
                    "nisn"=>$siswa->nisn,
                    "tempat_lahir"=>$siswa->tempat_lahir,
                    "tanggal_lahir"=>$siswa->tanggal_lahir,
                    "agama"=>$siswa->agama,
                    "jenis_kelamin"=>$siswa->jenis_kelamin,
                    "id_jurusan"=>$siswa->id_jurusan,
                    "no_absen"=>$siswa->no_absen,
                    "id_angkatan"=>$siswa->id_angkatan
                ]);

                if($req->hasFile("foto")){
                    $jurusan = Jurusan::find($req->id_jurusan);
                    $datasiswa2 = Siswa::find($req->nis);
                    $datasiswa2->foto_profil = $req->id_jurusan."_".$req->id_angkatan."_".$req->nis.".jpg";
                    $datasiswa2->save();
                    
                    $file = Image::make($req->file('foto')->getRealPath());
                   
                        $file->fit(360,480)->save(public_path("siswa")."/".$req->id_angkatan."/".$jurusan->jurusan."/".$req->id_jurusan."_".$req->id_angkatan."_".$req->nis.".jpg");
                }

                if($datasiswa){
                    $detail = DetailSiswa::create([
                        "nis"=>$req->nis,
                        "nik"=>$req->nik
                    ]);
                }

                if($datasiswa){
                    $alamat = AlamatSiswa::create([
                        "nis_siswa"=>$req->nis,
                        "alamat"=>$req->alamat,
                    ]);

                    if($req->filled("rt")){
                        $alamat->rt = $req->rt;
                    }
                    if($req->filled("rw")){
                        $alamat->rt = $req->rw;
                    }
                    if($req->filled("dusun")){
                        $alamat->rt = $req->dusun;
                    }
                    if($req->filled("kelurahan")){
                        $alamat->rt = $req->kelurahan;
                    }
                    if($req->filled("kecamatan")){
                        $alamat->rt = $req->kecamatan;
                    }
                    if($req->filled("kode_pos")){
                        $alamat->rt = $req->kode_pos;
                    }
                    $alamat->save();
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
        return redirect()->back();
    }

    public function tambahsiswaexcel(Request $req)
    {
        $siswa = Excel::import(new SiswaImport, $req->file('file_excel'));

        return redirect()->back();
    }

    public function siswakelas($angkatan, $jurusan)
    {
        //check permission 

        $siswa = Siswa::where("id_angkatan", $angkatan)->where("id_jurusan", $jurusan)->orderBy("no_absen", "asc");
        if(in_array("Pamong Putra", Auth::user()->getRoleNames()->toArray())){
            $siswa = $siswa->where("jenis_kelamin","L");
        }else if(in_array("Pamong Putri", Auth::user()->getRoleNames()->toArray())){
            $siswa = $siswa->where("jenis_kelamin","P");
        }

        return view("datasiswa.siswakelas", ["siswa" => $siswa->get()]);
    }

    public function profilsiswa($nis)
    {
        // $kategori = Kategori::with("aspek4b")->get();

 
        //Catatan Eraport
        $catatanEraport = DetailPG::where("nis_siswa", $nis)->with(["parent.penilai"])->with( "aspek_dpg", function($q){
            $q->where("nilai", "<", 2)->with("aspek4B");
        })->whereHas("aspek_dpg", function ($q) {
            $q->where("nilai", 1);
        })->get();
        
        
        $catatanasrama = CatatanSikap::with(["penilai","kategori"])->with("lampiran")->where("nis_siswa", $nis)->get();
       

        $catatankonseling = BillingKonseling::where("nis_siswa", $nis)->with("detailjk.jadwal.konselor")->where("status", "Selesai")->get();

        $siswa = Siswa::with(["detail", "alamat"])->find($nis);

        //validate
        $checker = TeacherHasTeaching::where("id_angkatan",$siswa->id_angkatan)->where("id_jurusan",$siswa->id_jurusan)->waliKelas(date("Y-m-d"))->get()->count();
        if(regularPermission(Auth::user()->getRoleNames()->toArray(),["Guru BK","Admin","Kesiswaan","Pamong Putra","Pamong Putri","Kepala Sekolah"])){
            if(regularPermission(Auth::user()->getRoleNames()->toArray(),["Pamong Putri"]) and $siswa->jenis_kelamin == "L"){
                Alert::error("Tidak dapat melihat data siswa","anda tidak memiliki hak akses untuk data aspa");
               return redirect()->route("datasiswa");
            }else if(regularPermission(Auth::user()->getRoleNames()->toArray(),["Pamong Putri"]) and $siswa->jenis_kelamin == "P"){
                Alert::error("Tidak dapat melihat data siswa","anda tidak memiliki hak akses untuk data aspi");
                return redirect()->route("datasiswa");
            }
        }else if($checker > 0){
            
        }else{
            Alert::error("Tidak dapat melihat data siswa","anda tidak memiliki hak akses untuk ".$siswa->angkatan->kelas()." ".$siswa->jurusan->jurusan);
            return redirect()->route("datasiswa");
        }
        return view("datasiswa.profilsiswa", ["siswa" => $siswa, "catataneraport" => $catatanEraport, "riwayatkonseling" => $catatankonseling, "catatanAsrama"=>$catatanasrama]);
    }

    public function carisiswa(Request $req)
    {
        $siswa = new Siswa();

        if ($req->filled("nama")) {
            $siswa = $siswa->where("nama_siswa", "LIKE", "%" . $req->nama . "%");
        }

        if ($req->filled("angkatan")) {
            $siswa = $siswa->where("id_angkatan", $req->angkatan);
        }

        if ($req->filled("jurusan")) {
            $siswa = $siswa->where("id_jurusan", $req->jurusan);
        }

        if(regularPermission(Auth::user()->getRoleNames()->toArray(),["Guru BK","Admin","Kepala Sekolah","Kesiswaan","Pamong Putra","Pamong Putri"])){
       
        }else{
            $siswa = $siswa->whereHas("angkatan.hakakses")->whereHas("jurusan.hakakses", function($q){
                $q->where("sebagai","LIKE","%Wali Kelas%")->where("sampai",">",date("Y-m-d"));
            });
        }

       if(count($siswa->get()) < 1){
        return redirect()->back();
       }
        return view("datasiswa.siswakelas", ["siswa" => $siswa->get()]);
    }


    public function switch(Request $req){
        $siswa = Siswa::find($req->nis);
        $siswa->switch();
        $ket = "diaktifkan";
        if($siswa->status() == "Non-aktif"){
            $ket = "dinonaktifkan";
        }
        Alert::success("Siswa Berhasil ".$ket);
        return redirect()->back();
    }

    public function turunkan(Request $req){
        $siswa = Siswa::find($req->nis);
        $siswa->turunkan();
        Alert::success("Siswa berhasil diturunkan");
        return redirect()->back();
    }

    public function updatepp(Request $req){
        $siswa  = Siswa::with("jurusan")->find($req->nis);
        $siswa->foto_profil = $siswa->jurusan->jurusan."_".$siswa->id_angkatan."_".$siswa->nis.".jpg";
        $siswa->save();

        //storepp
        if($req->hasFile("pp")){
            $img = Image::make($req->file("pp")->getRealPath());
            $img->fit(360,480)->save(public_path("siswa")."/".$siswa->id_angkatan."/".$siswa->jurusan->jurusan."/".$siswa->foto_profil);
        }

        return redirect()->back();
    }

    public function updatesiswa(Request $req){
        $siswa  = Siswa::find($req->nis);
        $detail = DetailSiswa::where("nis_siswa", $req->nis)->first();
        $alamat = AlamatSiswa::where("nis_siswa", $req->nis)->first();


        $siswa->nisn = $req->nisn;
        $siswa->nama_siswa = $req->nama_siswa;
        $siswa->id_jurusan =  $req->id_jurusan;
        $siswa->id_angkatan = $req->id_angkatan;
        $siswa->agama = $req->agama;
        $siswa->no_absen = $req->no_absen;
        $siswa->tanggal_lahir =  $req->tanggal_lahir;
        $siswa->tempat_lahir = $req->tempat_lahir;
        $siswa->jenis_kelamin = $req->jenis_kelamin;

        $siswa->save();


        $detail->nik = $req->nik;
        $detail->hobi = $req->hobi;
        $detail->nama_ayah = $req->nama_ayah;
        $detail->pekerjaan_ayah = $req->pekerjaan_ayah;
        $detail->alamat_ayah = $req->alamat_ayah;
        $detail->telp_ayah = $req->telp_ayah;
        $detail->nama_ibu = $req->nama_ibu;
        $detail->pekerjaan_ibu = $req->pekerjaan_ibu;
        $detail->alamat_ibu = $req->alamat_ibu;
        $detail->telp_ibu = $req->telp_ibu;
        $detail->nama_wali = $req->nama_wali;
        $detail->pekerjaan_wali = $req->pekerjaan_wali;
        $detail->alamat_wali = $req->alamat_wali;
        $detail->telp_wali = $req->telp_wali;
        
    }
}
