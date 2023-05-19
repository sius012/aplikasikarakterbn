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
use Image;

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
        ini_set('max_execution_time',500);
        $files = File::directories(public_path("pasfoto/"));
   
        foreach ($files as $fm) {
            $arrangkatan = explode(DIRECTORY_SEPARATOR, $fm);
            echo $fm;
            $key = key(array_slice($arrangkatan, -1, 1, true));
            $angkatan = $arrangkatan[$key];
            $angkatan = substr($angkatan,1);
         
            
        }
        // dd("tes");

        dd("lol");
        return redirect()->back();
    }
}
}
