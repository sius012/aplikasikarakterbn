<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Jurusan extends Model
{
    use HasFactory;

    protected $table = "jurusan";
    protected $primaryKey = "id_jurusan";
    public $timestamps = false;
    protected $fillable = [
        "jurusan",
        "keterangan"
    ];

    public function siswa(){
        return $this->hasMany(Siswa::class,"id_jurusan","id_jurusan");
    }

    public function hakakses(){
        return $this->hasMany(TeacherHasTeaching::class,"id_jurusan","id_jurusan");
    }
}
