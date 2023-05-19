<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class TeacherHasTeaching extends Model
{
    use HasFactory;
    protected $table = "teacher_has_teachings";
    protected $fillable = [
        "id_guru","id_jurusan",'id_angkatan',"sebagai","dari","sampai","status","agama",
    ];
    public $timestamps = false;

    public function angkatan(){
        if($this->id_angkatan != "semua"){
            $listangkatan = explode(",",$this->id_angkatan);
            $angkatan = Angkatan::whereIn($listangkatan)->get();
            return $angkatan;
        }else{
            return "Semua Kelas";
        }

    }

    public function jurusan(){
        if($this->id_jurusan != "semua"){
            $listjurusan = explode(",",$this->id_angkatan);
            $angkatan = Angkatan::whereIn($listangkatan)->get();
            return $angkatan;
        }else{
            return "Semua Kelas";
        }
    }

    public function guru(){
        return $this->belongsTo(UserDis::class,"id_guru","id");
    }

    public function scopeWaliKelas($query,$periode){
        return $query->where("sebagai","LIKE","%Wali Kelas%")->where("sampai",">",$periode);
    }

    public function scopeSaya($query){
        return $query->where("id_guru", Auth::user()->id);
    }
}
