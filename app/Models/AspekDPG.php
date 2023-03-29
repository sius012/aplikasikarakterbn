<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AspekDPG extends Model
{
    use HasFactory;

    protected $table="aspek_dpg";
    protected $primaryKey="id_adpg";
    public $timestamps=false;
    protected $fillable=[
        "id_adpg","id_dpg","id_aspek","nilai"
    ];

    public function aspek4B(){
        return $this->hasOne(Aspek4B::class,"id_aspek","id_aspek");
    }

    public function detailPG(){
        return $this->belongsTo(DetailPG::class, "id_dpg", "id_dpg");
    }
}
