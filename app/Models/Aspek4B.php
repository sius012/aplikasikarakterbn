<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspek4B extends Model
{
    use HasFactory;

    protected $table = "aspek_4b";
    protected $primaryKey = "id_aspek";    
    public $timestamps = false;
    protected $fillable = [
        "id_aspek","keterangan","point","subpoint","created_at","updated_at","no_point","no_subpoint","no_aspek"
    ];


    

    
}
