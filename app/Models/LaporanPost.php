<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPost extends Model
{
    use HasFactory;
    protected $table = 'laporan_post';
    public $timestamps = false;
    public $primaryKey = 'id_laporan';

    public function pengguna(){
       return $this->belongsTo(User::class,"id_pengguna");
    }

    public function role(){
        return $this->belongsTo(Roles::class,"id_roles");
    }

}