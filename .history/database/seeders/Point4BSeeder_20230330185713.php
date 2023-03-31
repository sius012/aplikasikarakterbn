<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Excel;
use App\Imports\Raport;
use App\Models\Aspek4B;

class Point4BSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {



        $rows = Excel::toArray(new Raport, storage_path("file/aspek4B"))[1];


        // dd($rows);

        $nilai4b = [];
        $currentpoint = [
            "point" => "ini",
            "no" => "init"
        ];
        $currentsubpoint = [
            "point" => "init",
            "no" => "init"
        ];




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
                        $currentsubpoint["no"] = "hello";
                    }
                } else {
                    $pointArr = explode("=", $currentpoint["point"]);
                    array_push($nilai4b, [
                        "point" => str_replace([":"], "", $pointArr[0]),
                        "subpoint" => str_replace([":"], "", $currentsubpoint["point"]),
                        "no_aspek" => $row[0],
                        "no_point" => str_replace(["."], "", $currentpoint["no"]),
                        "no_subpoint" => str_replace(["."], "", $currentsubpoint["no"]),
                        "keterangan" => $row[1]
                    ]);
                }
            }
        }


        foreach ($nilai4b as $n) {
            Aspek4B::create($n);
        }
        // dd($nilai4b);


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

}
