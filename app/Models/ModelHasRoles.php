<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class ModelHasRoles extends Model
{
    use HasFactory;
    protected $table = "model_has_roles";
    protected $fillable = [
        "role_id",
        "model_type",
        "model_id"
    ];
    protected $primaryKey = "role_id";

    public function role(){
        return $this->belongsTo(Role::class, "role_id", "id");
    }
}