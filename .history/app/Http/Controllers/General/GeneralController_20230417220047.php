<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller
{
    public function getnotif()
    {
        $notif = Notification::where('id_user', Auth::user()->id)->get();
        return json_encode($notif->toArray());
    }

    public function injectraport($row, $akn, $jrs, $tgl)
    {
        // dd($req->session()->get('dataraport'));

        $rows = $row;
        $angkatan = $akn;
        $jurusan = $jrs;
        $tanggal =  $tgl;

        $penilaians = [];
        $ketarangan = [];
        $listSiswa = [];

        $currentpoint = [
            "point" => "ini",
            "no" => "init"
        ];
        $currentsubpoint = [
            "point" => "init",
            "no" => "init"
        ];

        //Make Penilaian
        foreach ($rows as $i => $row) {
            if ($i > 6) {
                if (!$this->hasNumber((string) $row[0])) {
                    if ($i != 7) {
                        if ($this->hasNumber((string) $rows[$i - 1][0])) {

                            $currentsubpoint["no"] = $rows[$i][0];
                            $currentsubpoint["point"] = $rows[$i][1];
                        } else {
                            $currentpoint["point"] = $rows[$i - 1][1];
                            $currentpoint["no"] = $rows[$i - 1][0];
                            $currentsubpoint["point"] = $rows[$i][1];
                            $currentsubpoint["no"] = $rows[$i][0];
                        }
                    } else {
                        $currentsubpoint["point"] = $rows[$i + 1][1];
                        $currentsubpoint["no"] = $rows[$i + 1][0];
                        $currentpoint["point"] = "hello";
                        $currentpoint["no"] = "hello";
                    }

                    //gettheketerangan
                    if (isset($rows[$i - 1])) {

                        if ($this->hasNumber((string) $rows[$i - 1][0]) and $rows[$i][0] == "Keterangan") {

                            foreach ($row as $j => $rk) {

                                if ($j > 1) {

                                    if ($row[$j] != null) {
                                        array_push($ketarangan, [
                                            "no" => $j - 1,
                                            "keterangan" => $rk,
                                            "followup" => $rows[$i + 1][$j],

                                        ]);

                                        array_push($listSiswa, $j - 1);
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $pointArr = explode("=", $currentpoint["point"]);
                    $value =  [
                        "point" => str_replace([":"], "", $pointArr[0]),
                        "no_aspek" => $row[0],
                        "no_point" => str_replace(["."], "", $currentpoint["no"]),
                        "no_subpoint" => str_replace(["."], "", $currentsubpoint["no"])
                    ];
                    //   array_push($nilai4b,$value);
                    foreach ($row as $r => $rowia) {

                        if ($row[$r] != null and $r > 1) {

                            $penilaian = array_merge([
                                "no_absen" => $r - 1,
                                "nilai" => $rowia,

                            ], $value);

                            array_push($penilaians, $penilaian);
                        }
                    }
                }
            }
        }
        //dd($penilaians);

        //    dd($ketarangan);

        //  $rows = Excel::toArray(new Raport, $req->file('file'))[1];
        return [$penilaians, $ketarangan];
    }

    public function hasNumber($str)
    {
        $isThereNumber = false;
        for ($i = 0; $i < strlen($str); $i++) {
            if (ctype_digit($str[$i])) {
                $isThereNumber = true;

                return $isThereNumber;
                break;
            }
        }
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
}
