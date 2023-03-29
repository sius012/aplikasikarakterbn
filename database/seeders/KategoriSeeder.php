<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategori = Kategori::create([
            "kategori"=>"Merokok",
            "aspek_berkaitan"=> "5,6,7,1,3",
            "tindakan"=>"Negatif",
            "nilai"=>1
        ]);

        $kategori = Kategori::create([
            "kategori"=>"Membantu orang tua",
            "aspek_berkaitan"=> "5,6,7,1,3",
            "tindakan"=>"Positif",
            "nilai"=>4
        ]);
    }
}
