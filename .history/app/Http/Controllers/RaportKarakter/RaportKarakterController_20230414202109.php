<?php

namespace App\Http\Controllers\RaportKarakter;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Http\Request;

class RaportKarakterController extends Controller
{
    //PROCEDURE
    public function index(Request $req){
        //Get angkatan/kelas,jurusan
        $kelas = Angkatan::aktif()->get();
        $jurusan = Jurusan::get();

        return view('raportkarakter.index', ['kelas'=>$kelas,'jurusan'=>$jurusan]);
    }


    //FUNCTION
    public function getpenilailist(Request $req){
        $penilai = User::role(['Guru BK','Guru','Pamong Putra']);

        if($req->filled('nama')){
            $penilai = $penilai->where('name','LIKE','%'.$req->nama."%");
        }
        return json_encode($penilai->get());
    }

    public function rekaperaportdetail(array $params)
    {
        list($tahun, $bulan, $angkatan, $jurusan) = explode(":", $params);
        $angkatan = $params["angkatan"];
        $jurusan = $params['jurusan'];
        $dari = $params['dari'];
        $sampai = $params['sampai'];
        $semua = $req=
        $listguru = [];

        $siswa = Siswa::where("id_angkatan", $angkatan)->where("id_jurusan", $jurusan)->orderBy("no_absen", "asc")->get();
        $aspek4b = Aspek4B::all();

        $kelas = Angkatan::find($angkatan)->kelas();
        $jurusan = Jurusan::find($jurusan);

        //  dd($aspek4b);

        $rekaplist = [];

        foreach ($aspek4b as $j => $asp4b) {

            foreach ($siswa as $s => $sws) {
                $qpasrama = AspekDPG::where("id_aspek", $asp4b->id_aspek)->whereHas("detailPG.siswa", function ($q) use ($sws) {
                    $q->where("nis_siswa", $sws->nis);
                })->whereHas("detailPG.parent", function ($q) use ($bulan, $tahun) {
                    $q->whereMonth("tanggal_penilaian", $bulan)->whereYear("tanggal_penilaian", $tahun);
                })->whereHas("detailPG.parent.penilai.roles.role", function ($q) {
                    $q->whereIn("name", ["Pamong Putra", "Pamong Putri"]);
                });

                $nis = $sws->nis;

                $countasrama = PenilaianGuru::whereYear("tanggal_penilaian", $tahun)->whereMonth("tanggal_penilaian", $bulan)->whereHas("penilai.roles.role", function ($q) {
                    $q->whereIn("name", ["Pamong Putra", "Pamong Putri"]);
                })->whereHas("detail_pg", function ($q) use ($nis) {
                    $q->where("nis_siswa", $nis);
                })->groupBy("id_penilai")->count();

                $qpsekolah = AspekDPG::where("id_aspek", $asp4b->id_aspek)->whereHas("detailPG.siswa", function ($q) use ($sws) {
                    $q->where("nis_siswa", $sws->nis);
                })->whereHas("detailPG.parent", function ($q) use ($bulan, $tahun) {
                    $q->whereMonth("tanggal_penilaian", $bulan)->whereYear("tanggal_penilaian", $tahun);
                })->whereHas("detailPG.parent.penilai.roles.role", function ($q) {
                    $q->whereNotIn("name", ["Pamong Putra", "Pamong Putri"]);
                });

                $countsekolah = PenilaianGuru::whereYear("tanggal_penilaian", $tahun)->whereMonth("tanggal_penilaian", $bulan)->whereHas("penilai.roles.role", function ($q) {
                    $q->whereNotIn("name", ["Pamong Putra", "Pamong Putri"]);
                })->whereHas("detail_pg", function ($q) use ($nis) {
                    $q->where("nis_siswa", $nis);
                })->groupBy("id_penilai")->count();

                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["point"] = $asp4b->point;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["subpoint"] = $asp4b->subpoint;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["aspek"] = $asp4b->keterangan;

                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["data"] = $sws;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["nilai_asrama"]['count'] = $countasrama;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["nilai_asrama"]['jumlah'] = $qpasrama->sum("nilai");
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["nilai_asrama"]['jumlah_akumulatif'] = $countasrama != 0 ? $qpasrama->sum("nilai") / $countasrama : 0;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["nilai_sekolah"]['count'] = $countsekolah;
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["nilai_sekolah"]['jumlah'] = $qpsekolah->sum("nilai");
                $rekaplist[$asp4b->no_aspek . ":" . $asp4b->no_subpoint . ":" . $asp4b->no_point]["siswa"][$sws->nis]["nilai_sekolah"]['jumlah_akumulatif'] = $countsekolah != 0 ? $qpsekolah->sum("nilai") / $countsekolah : 0;
            }
        }


        return view("eraport.rekaperaportdetail", ["siswa" => $siswa, "rekaplist" => $rekaplist, "kelas" => $kelas, "jurusan" => $jurusan->jurusan]);
    }








    //
}
