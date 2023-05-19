<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lampiran extends Model
{
    use HasFactory;

    protected $table = "lampiran";
    protected $primaryKey = "id_lampiran";
    protected $fillable = [
        "id_lampiran","id_cs","nama_file"
    ];
    public $timestamps = false;

    public function getPat
}
