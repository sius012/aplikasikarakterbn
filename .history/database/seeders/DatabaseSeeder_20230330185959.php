<?php

namespace Database\Seeders;

use App\Models\Aspek4B;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SiswaSeeder::class);
        $this->call(KategoriSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(Point4BSeeder::class);
    }
}
