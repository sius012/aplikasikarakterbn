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
                "bulan_mulai" => $req->bulan_mulai,
            ]);

            return redirect()->back();
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
                $hakakses = TeacherHasTeaching::where("id_guru", $id)->with("angkatan")->get();
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

        return view("konfigurasiumum.konfigurasipengguna.hakakses", ["id" => $id, "hakakses" => $hakases, "angkatan" => $angkatan, "jurusan" => $jurusan, "user" => $user]);
    }

    public function tambahhakakseskelas(Request $req)
    {
        $angkatan = $req->angkatan;
        $jurusan = $req->jurusan;

        DB::beginTransaction();
        try {
            $hakakses = TeacherHasTeaching::create([
                "id_guru" => $req->id_user,
                "id_angkatan" => $angkatan,
                "id_jurusan" => $jurusan,
                "dari" => $req->dari,
                "sampai" => $req->sampai,
                "sebagai" => $req->sebagai
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }

        return redirect()->back();
    }


}
