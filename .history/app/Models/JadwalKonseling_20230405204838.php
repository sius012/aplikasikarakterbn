<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKonseling extends Model
{
    use HasFactory;

    protected $table = "jadwal_konseling";
    protected $fillable = [
        "id_jk","id_konselor","keterangan","minggu","bulan","tahun","status"
    ];
    protected $primaryKey = "id_jk";
    public $timestamps = false;
    
    public function detail_jk(){
        return $this->hasMany(DetailJK::class, "id_jk","id_jk");
    }

    public function konselor(){
        return $this->belongsTo(User::class, "id_konselor");
    }
}
