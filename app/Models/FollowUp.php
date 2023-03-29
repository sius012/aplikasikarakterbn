<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;
    protected $table = "follow_up";
    protected $primaryKey = "id_fu";
    
    protected $fillable = [
        "id_fu","id_cs","id_penulis","catatan","tanggal"
    ];
}
