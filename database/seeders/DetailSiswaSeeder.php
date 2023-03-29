<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\DetailSiswa;
use App\Models\Siswa;

class DetailSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datasiswa = Siswa::all();
        

        //generate detailsiswa
        foreach($datasiswa as $ds){
            
        }
    }
}
