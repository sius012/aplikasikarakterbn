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
use App\Models\BillingKonseling;
use App\Models\CatatanSikap;
use App\Models\DetailPG;
use RealRashid\SweetAlert\Facades\Alert;

class DataSiswaController extends Controller
{
    public function index(Request $req)
    {
        $siswa = Siswa::all();

        $angkatan = Angkatan::aktif()->get();

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

        return view("datasiswa.index", ["jurusan" => $jurusan, "angkatan" => $angkatan, "kelas" => $kelas, "siswa" => $siswa]);
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
        $siswa = $req->input();
        unset($siswa["_token"]);
        DB::beginTransaction();
        try {
            $find = Siswa::find($siswa['nis']);
            if (!$find) {
                $datasiswa = Siswa::create($siswa);
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
        $catatanEraport = DetailPG::where("nis_siswa", $nis)->with(["parent.penilai"])->with( "aspek_dpg.aspek4B", function($q){
            $q->whereHas("apsek4")
        })->whereHas("aspek_dpg", function ($q) {
            $q->where("nilai", 1);
        })->get();

        $catatanPositif = CatatanSikap::whereHas("kategori", function ($q) {
            $q->where("tindakan", "Positif");
        })->where("nis_siswa", $nis)->get();
        $catatanNegatif = CatatanSikap::whereHas("kategori", function ($q) {
            $q->where("tindakan", "Negatif");
        })->where("nis_siswa", $nis)->get();

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
        return view("datasiswa.profilsiswa", ["siswa" => $siswa, "catataneraport" => $catatanEraport, "riwayatkonseling" => $catatankonseling, "catatanNegatif" => $catatanNegatif, "catatanPositif" => $catatanPositif]);
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
}
