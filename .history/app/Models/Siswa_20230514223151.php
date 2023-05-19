<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable  as Auth;
use PhpParser\Node\Expr\FuncCall;

class Siswa extends Model implements Authenticatable
{
    use HasFactory;

    use Auth;

    protected $table = "siswa";
    protected $primaryKey = "nis";
    protected $keyType="string";    
    public $timestamps = false;
    protected $fillable = [
        "nis",  "nama_siswa", "nisn","id_jurusan", "tanggal_lahir", "tempat_lahir", "jenis_kelamin","no_absen","id_angkatan","agama","foto_profil","id_ca","status"
    ];


    public function kelas()
    {
         $angkatan = Angkatan::where("id_angkatan", $this->id_angkatan)->first();

         if($this->id_ca!=null){
            $angkatan = Angkatan::find( $this->id_ca);
         }

         return $angkatan->kelas();
    }



    public function jurusan(){
        return $this->hasOne(Jurusan::class,"id_jurusan","id_jurusan");
    }
    public function kelasdanjurusan()
    {
        $jurusan = Jurusan::where("id_jurusan", $this->id_jurusan)->pluck("jurusan")->first();
        return $this->kelas() < 13 ?  $this->kelas() . " " . $jurusan : "Sudah Lulus";
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



    public function getimageurl(){
        $jurusan = Jurusan::find($this->id_jurusan);
        return asset("siswa/".$this->id_angkatan."/".$jurusan->jurusan."/".$this->foto_profil);
    }

    public function billing(){
        return $this->hasMany(BillingKonseling::class,"nis_siswa","nis");
    }

    public function status(){
        $status = $this->status;
        $angkatan = Angkatan::find($this->id_angkatan);

        if($status == "Aktif"){
            if($this->kelas() > 12){
                return "Alumni";
            }else{
                return "Siswa Aktif";
            }
        }else{
            return "Non-aktif";
        }
    }

    public function switch(){
        $siswa = $this;
        if($siswa->status != "Aktif"){
            $siswa->status = "Aktif";
        }else{
            $siswa->status = "Non-aktif";
        }
        
        $siswa->save();
    }

    public function turunkan(){
        $siswa = $this;
        if($siswa->id_ca!=null){
            $siswa->id_ca = $this->id_ca+1;
        }else{
            $siswa->id_ca = $this->id_angkatan+1;
        }
        
        $siswa->save();
    }

    public function ScopeClassFilter($query, $angkatan){
        return $query->where(function($q) use($angkatan){
            $q->where("id_angkatan",$angkatan)->whereNull("id_ca");
        });
    }



}
