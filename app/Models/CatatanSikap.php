<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class CatatanSikap extends Model
{
    use HasFactory;
    
    protected $table = "catatan_sikap";
    protected $primaryKey = "id_cs";
    protected $fillable = [
        	"id_penilai","nis_siswa","id_kategori","keterangan","visibilitas","tanggal"
    ];
    public $timestamps = false;

    public function penilai(){
        return $this->belongsTo(User::class, "id_penilai", "id");
    }

    
    public function siswa(){
        return $this->belongsTo(Siswa::class,"nis_siswa","nis");
    }


    
    public function lampiran(){
        return $this->hasOne(Lampiran::class, "id_cs", "id_cs");
    }

    public function kategori(){
        return $this->hasOne(Kategori::class, "id_kategori","id_kategori");
    }

}
