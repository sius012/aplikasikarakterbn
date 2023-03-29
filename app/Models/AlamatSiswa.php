<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlamatSiswa extends Model
{
    use HasFactory;
    protected $table = "alamat_siswas";
    public $timestamps = false;
    protected $fillable = [
        "id","nis_siswa","alamat","rt","rw","dusun","kelurahan","kecamatan","kode_pos"	
    ];
}
