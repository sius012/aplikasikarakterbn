<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Angkatan;
use App\Models\Jurusan;
use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Image;

class GeneralController extends Controller
{
    public function getnotif()
    {
        $notif = Notification::where('id_user', Auth::user()->id)->get();
        return json_encode($notif->toArray());
    }

   


    function roman_to_decimal($roman_numeral)
    {
        $romans = array("M" => 1000, "CM" => 900, "D" => 500, "CD" => 400, "C" => 100, "XC" => 90, "L" => 50, "XL" => 40, "X" => 10, "IX" => 9, "V" => 5, "IV" => 4, "I" => 1);
        $decimal = 0;
        foreach ($romans as $key => $value) {
            while (strpos($roman_numeral, $key) === 0) {
                $decimal += $value;
                $roman_numeral = substr($roman_numeral, strlen($key));
            }
        }
        return $decimal;
    }


    public function injectphotoprofile()
    {
        $files = File::directories(public_path("pasfoto/"));

        foreach ($files as $fm) {
            $arrangkatan = explode(DIRECTORY_SEPARATOR, $fm);
            $key = key(array_slice($arrangkatan, -1, 1, true));
            $angkatan = ltrim($arrangkatan[$key], "A");
            foreach (File::directories($fm) as $file) {
                $arrjurusan = explode(DIRECTORY_SEPARATOR, $file);
                $keyj = key(array_slice($arrjurusan, -1, 1, true));
                $jurusana = explode(" ", $arrjurusan[$keyj]);
                $jurusan = isset($jurusana[2]) ? $jurusana[2] : $jurusana[0];
                foreach (File::files($file) as $i => $j) {
                    $jurusandata = Jurusan::where("jurusan", $jurusan)->orWhere("keterangan", $jurusan)->first();
                    echo $jurusandata->jurusan;
                    $filename = explode(".", $j->getFilename());
                    $siswa = Siswa::where("id_jurusan", $jurusandata->id_jurusan)->where("id_angkatan", $angkatan)->where("nama_siswa", "LIKE", "%" . $filename[0] . "%")->first();
                    if ($siswa) {
                        $name = $siswa->id_jurusan . "_" . $siswa->id_angkatan . "_" . $siswa->nis . "_" . "." . "jpg";
                        $siswa->foto_profil = $name;
                        $siswa->save();

                        $imageCompressed = Image::make($img->getRealPath());
                         $imageCompressed->resize(200,200)->save(public_path("siswa/" . $angkatan . "/" . $jurusandata->jurusan . "/" . $name));
                        Storage::disk("public_disk")->put(, file_get_contents($j));
                    }
                    // echo ($i+1).".".$j->getFilename()."<br>";
            }
        }
        // dd("tes");

        return redirect()->back();
    }
}
}
