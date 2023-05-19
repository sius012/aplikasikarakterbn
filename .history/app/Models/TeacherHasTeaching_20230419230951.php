<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherHasTeaching extends Model
{
    use HasFactory;
    protected $table = "teacher_has_teachings";
    protected $fillable = [
        "id_guru","id_jurusan",'id_angkatan',"sebagai","dari","sampai",
    ];
    public $timestamps = false;

    public function angkatan(){
        return $this->belongsTo(Angkatan::class,"id_angkatan","id_angkatan");
    }

    public function jurusan(){
        return $this->belongsTo(Jurusan::class,"id_jurusan","id_jurusan");
    }

    public function guru(){
        return $this->belongsTo(UserDis::class,"id_guru","id");
    }

    public function scopeWaliKelas($query,$periode){
        return $query->where("sebagai","LIKE","%Wali Kelas%")->where("sampai",">",$periode);
    }

    public function scopeSaya($query){
        return $query->
    }
}
