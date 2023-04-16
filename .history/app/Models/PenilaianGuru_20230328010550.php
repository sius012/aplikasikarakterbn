<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianGuru extends Model
{
    use HasFactory;
    protected $table = "penilaian_guru";
    protected $primaryKey = "id_pg";
    public $timestamps = false;
    protected $fillable = [
        "id_pg","id_angkatan","id_jurusan","id_penilai","keterangan","tanggal_penilaian"	
    ];

    public function detail_pg(){
        return $this->hasMany(DetailPG::class,"id_pg","id_pg");
    }

    public function penilai(){
        return $this->hasOne(UserDis::class,"id","id_penilai");
    }


}
