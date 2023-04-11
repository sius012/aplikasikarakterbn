<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKonseling extends Model
{
    use HasFactory;

    protected $table = "jadwal_konseling";
    protected $fillable = [
        "id_konselor","keterangan","minggu","bulan","tahun	status"
    ]
}
