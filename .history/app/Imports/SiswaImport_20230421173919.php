<?php

namespace App\Imports;

use App\Models\Jurusan;
use App\Models\Siswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Calculation\DateTime;

class SiswaImport implements ToModel{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        if(!isset($row[0])){
            return null;
        }

        if($row[0]=="Nama"){
            return null;
        }

    
        $tanggal_lahir = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6]))->toDateString();

        $jurusan = Jurusan::where("jurusan", $row[17])->pluck("id_jurusan")->first();
        $jk = "";
        $alamat = null;
        $no_absen = null;

        if(isset($row[8])){
            $alamat = $row[8];
        }

        if(isset($row[9])){
            $no_absen = $row[9];
        }


        switch ($row[2]) {
            case 'L':
                $jk = "Laki-laki";
                break;
             case 'P':
                $jk="Perempuan";
                 break;
            default:
                $jk = "Laki-laki";
                break;
        }

        $check = Siswa::find($row[1]);
        if(!$check){
            return new Siswa([
                "nis"=>$row[4],
                "nama_siswa"=>$row[1],
                "tempat_lahir"=>$row[5],
                "tanggal_lahir"=>$tanggal_lahir,
                "id_jurusan"=>$jurusan,
                "id_angkatan"=>$row[16],
                "agama"=>$row[8],
                "jenis_kelamin"=>$jk
            ]);
        }
    }
}
