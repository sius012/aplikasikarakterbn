<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PenilaianGuru;

class UserDis extends Model
{
    use HasFactory;
    protected $table ="users";

    protected $fillable = [
"name",
"email",	
"email_verified_at",
"password",
"photo",
"active",
"deleted_at",	
"remember_token",
"created_at",
"updated_at","photo"
    ];

    public function roles(){
        return $this->hasMany(ModelHasRoles::class,"model_id", "id");
    }

    public function penilaianGuru(){
        return $this->hasMany(PenilaianGuru::class, 'id_penilai','id');
    }

    public function getPhotoProfile(){
      //  dd($user->toArray());
        $path = asset('photoprofile',$imgname);
        return $path;
    }
}
