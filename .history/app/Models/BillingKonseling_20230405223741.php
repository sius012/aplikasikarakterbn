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

    public function detailJK(){
        return $this->belongsTo(DetailJK::class, "id_djk","id_djk");
    }

    public function haridantanggal(){
        $rwt = BillingKonseling::with("detailjk.jadwal.konselor")->find($this->id_bk);
        return getDates($rwt->detailjk->hari,$rwt->detailjk->jadwal->minggu,$rwt->detailjk->jadwal->bulan,$rwt->detailjk->jadwal->tahun,"hari")}} , {{getDates($rwt->detailjk->hari,$rwt->detailjk->jadwal->minggu,$rwt->detailjk->jadwal->bulan,$rwt->detailjk->jadwal->tahun)
    }
    
}
