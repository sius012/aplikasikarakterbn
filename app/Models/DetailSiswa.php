<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DetailSiswa extends Model
{
    use HasFactory;

    protected $table = "detail_siswa";
    protected $primaryKey = "id_ds";
    public $timestamps = false;
    protected $fillable = ["nis","nik","hobi","nama_ayah","tanggal_lahir_ayah","tempat_lahir_ayah","nama_ibu","tanggal_lahir_ibu","tempat_lahir_ibu","nama_wali","tanggal_lahir_wali","tempat_lahir_wali","pekerjaan_ayah","pekerjaan_ibu","pekerjaan_wali","agama_ayah","agama_ibu","agama_wali","alamat_ayah","alamat_ibu","alamat_wali"];
}
