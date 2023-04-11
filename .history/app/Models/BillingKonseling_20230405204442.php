<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingKonseling extends Model
{
    use HasFactory;
    protected $table="billing_konseling";
    protected $primaryKey = "id_bk";
    protected $fillable = ["id_djk","keterangan_siswa","nis_siswa","catatan_konselor","tempat","status","r_dari","r_sampai"];
    public $timestamps = false;

    public function pemesan(){
        return $this->hasOne(Siswa::class,"nis","nis_siswa",);
    }

    public function detailJK(){}
    
}
