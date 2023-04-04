<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable  as Auth;

class Siswa extends Model implements Authenticatable
{
    use HasFactory;

    use Auth;

    protected $table = "siswa";
    protected $primaryKey = "nis";
    protected $keyType="string";    
    public $timestamps = false;
    protected $fillable = [
        "nis",  "nama_siswa", "id_jurusan", "tanggal_lahir", "tempat_lahir", "jenis_kelamin","no_absen","id_angkatan","agama"
    ];


    public function kelas()
    {
         $angkatan = Angkatan::where("id_angkatan", $this->id_angkatan)->first();
         $tahunmasuk = $angkatan->tahun_mulai;
         $bulanmasuk = $angkatan->bulan_mulai;

        //     dd($tahunmasuk);
        $tahunberjalan = date("Y");
        $bulanberjalan = date("m");
        $kelas = $tahunberjalan - (int) $tahunmasuk + 9;
        return $kelas;
    }



    public function jurusan(){
        return $this->hasOne(Jurusan::class,"id_jurusan","id_jurusan");
    }
    public function kelasdanjurusan()
    {
        $tahunmasuk = Angkatan::where("id_angkatan", $this->id_angkatan)->pluck("tahun_mulai")->first();
        $jurusan = Jurusan::where("id_jurusan", $this->id_jurusan)->pluck("jurusan")->first();

        //     dd($tahunmasuk);
        $tahunberjalan = date("Y");
        $kelas = $tahunberjalan - (int) $tahunmasuk + 9;
        return $kelas < 13 ?  $kelas . " " . $jurusan : "Sudah Lulus";
    }

    public function badge()
    {
        $jurusan = Jurusan::where("id_jurusan", $this->id_jurusan)->pluck("jurusan")->first();
        $bg = "bg-primary";
        switch ($jurusan) {
            case 'RPL':
                $bg = "bg-warning";
                break;

            case 'MM':
                $bg = "bg-danger";
                break;

            case 'TKRO':
                $bg = "bg-gradient-primary";
                break;
            case 'TB':
                $bg = "bg-gradient-primary";
                break;

            default:
                $bg = "bg-secondary";
                break;
        }
        return $bg;
    }


    public function angkatan(){
     return $this->hasOne(Angkatan::class,"id_angkatan","id_angkatan");
    }

    public function detail(){
        return $this->hasOne(DetailSiswa::class,"nis","nis");

    }

    public function alamat(){
        return $this->hasOne(AlamatSiswa::class,"nis_siswa","nis");
    }

    public static function getColumn(){
       $data =  Schema::getColumnListing("detail_siswa");
        
        return $data;
    }


    public function user(){
        return $this->belongsTo(User::class, "id_user");
    }

    public function catatan_sikap(){
        return $this->belongsTo(CatatanSikap::class, "nis","nis_siswa");
    }



    public function namafile()


}
