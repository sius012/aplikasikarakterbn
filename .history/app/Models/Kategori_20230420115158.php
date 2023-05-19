<?php

namespace App\Models;

use Catatan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = "kategori";
    protected $primaryKey = "id_kategori";
    protected $fillable = [
        "id_kategori", "kategori", "aspek_berkaitan", "tindakan","nilai"
    ];
    public $timestamps = false;

    public function catatan_sikap(){
        return $this->hasMany(CatatanSikap::class, "id_kategori","id_kategori");
    }

    public function aspek4b(){
        return $this->hasMany(Aspek4B::class)->whereRaw('FIND_IN_SET(aspek_4b.id_aspek, kategori.id_kategori)');
    }

    public function aspekTerkait(){
        $aspek = explode(",",$this->aspek_berkaitan);
        $list = [];
    }
}
