<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPG extends Model
{
    use HasFactory;

    protected $table="detail_pg";
    protected $primaryKey="id_dpg";
    public $timestamps = false;
    protected $fillable=["id_dpg","id_pg","nis_siswa","keterangan","followup"];

    public function siswa(){
        return $this->hasOne(Siswa::class,"nis","nis_siswa");
    }

    public function aspek_dpg(){
        return $this->hasMany(AspekDPG::class,"id_dpg","id_dpg");
    }

    public function parent(){
        return $this->belongsTo(PenilaianGuru::class,"id_pg","id_pg");
    }

}
