<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
"updated_at"
    ];

    public function roles(){
        return $this->hasMany(ModelHasRoles::class,"model_id", "id");
    }

    public function penilaianGuru(){
        return $this->hasMany(PenilaianGuru, 'id_penilai','id');
        
    }
}
