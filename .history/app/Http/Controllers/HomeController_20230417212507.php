<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function beranda()
    {
        $kategori = Kategori::all();

        $role = Auth::user()->getRoleNames()[0];

        $cs = CatatanSikap::with(["siswa", "penilai", "lampiran"])->where("visibilitas", "Semua");

        if (in_array($role, ["Pamong Putra", "Pamong Putri"])) {
            $cs = $cs->orWhere("visibilitas", "Asrama");
        } else if (in_array($role, ["Guru"])) {
            $cs = $cs->orWhere("visibilitas", "Sekolah");
        }

        $cs = $cs->get();

        return view("beranda.index", ["kategori" => $kategori, "catatan_sikap" => $cs]);
    }

    public function listsiswa(Request $req)
    {
        $siswa = Siswa::where("nama_siswa", "LIKE", "%" . $req->kw . "%")->get();
        return json_encode($siswa);
    }
}
