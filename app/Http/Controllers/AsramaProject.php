<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanPost;
use App\Models\ModelRole;
use App\Models\Roles;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Model;

class AsramaProject extends Controller
{
    
    public function tambah_laporan(Request $req)
    {
        $foto = array();
        foreach($req->file('gambar') as $file){
            $nama = $file->getClientOriginalName();

            $file->move('postingan/', $file->getClientOriginalName());
            $foto[] = $nama;
        }

        $tabel = new LaporanPost();
        $tabel->gambar = implode('|', $foto);
        $tabel->id_roles = $req->id_roles;
        $tabel->id_pengguna = $req->id_pengguna;
        $tabel->deskripsi = NULL;
        $tabel->nama_siswass = NULL;
        $tabel->save();
        
      
       return redirect()->route("asrama.laporanharian", ["id_saja" => $tabel->id_laporan]);
       
    }
    

    public function lihat_post($id){
        $tabel = LaporanPost::find($id);
        $murid = Siswa::all();
        return view('laporan_asrama.postingan',["data" => $tabel,"murid" => $murid]);
    }

    public function kembali_home($id){
        $tabel = LaporanPost::find($id);

        $gambar = $tabel->gambar;

        $gambarArray = explode("|",$gambar);

        $folder = public_path('/postingan/');

        foreach($gambarArray as $files){
              if(file_exists($folder . $files)){
                unlink($folder . $files);
              };
        };
        
        $tabel->delete();
        
        return redirect()->route('laporan_harian');
    }

    public function tambah_siswa(Request $req){
       $ids = $req->idnya;
       $tabel = LaporanPost::find($ids);
       $tabel->deskripsi = $req->deskripsi;
       $tabel->nama_siswass = $req->tags;
       $tabel->update();
       return redirect('laporan_harian');
}

    public function tampil_laporan_harian(){
        $tabel = LaporanPost::all();
        $tabel2 = ModelRole::where('model_id', auth()->user()->id)->get();
        return view('laporan_asrama.laporan_harian',["datas" => $tabel,"datas2" => $tabel2]);
    }

    public function detail_foto($id){
        $tabel = LaporanPost::find($id);
        return response()->json([
            'status' => 200,
            'tampil' => $tabel,
        ]);
    }

}