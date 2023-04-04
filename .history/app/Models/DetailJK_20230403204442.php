<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailJK extends Model
{
    use HasFactory;
    protected $table = "detail_jk";
    protected $primaryKey = "id_djk";
    protected $fillable = [
        "id_jk", "hari", "dari", "sampai","tanggal"
    ];
    public $timestamps = false;

    public function bookedby(){
        return $this->hasMany(BillingKonseling::class, "id_djk", "id_djk");
    }

    public function jadwal(){
        return $this->belongsTo(JadwalKonseling::class,"id_jk","id_jk");
    }
}
