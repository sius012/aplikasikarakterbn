<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Angkatan extends Model
{
    use HasFactory;

    protected $table = "angkatan";
    protected $primaryKey = "id_angkatan";
    public $timestamps = false;
    protected $fillable = [
        "id_angkatan",
        "tahun_mulai",
        "bulan_mulai"
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

    public function siswa(){
        return $this->hasMany(Siswa::class,"id_angkatan", "id_angkatan");
    }


    public function hakakses(){
        return $this->hasMany(TeacherHasTeaching::class,"id_angkatan","id_angkatan");
    }

    public function scopeAktif($query){
        return $query->where(DB::raw("tahun_mulai + 3
        "), "<", date("Y") + 3)->where(DB::raw("tahun_mulai + 3
        "), ">", date("Y"))->orWhere(
             function ($q) {
                 $q->where("tahun_mulai", date("Y") - 3)->where("bulan_mulai", ">", Carbon::now()->month);
             }
         )->orWhere(
             function ($q) {
                 $q->where("tahun_mulai", date("Y"))->where("bulan_mulai", "<=", Carbon::now()->month);
             }
            )->orWhere('id_angkatan',)
    }
}
