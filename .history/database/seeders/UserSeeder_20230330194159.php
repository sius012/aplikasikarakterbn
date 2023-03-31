<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default credentials
        $user = User::create([

            'name' => 'Max',
            'email' => 'max@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'active' => 1,
            'remember_token' => Str::random(10)

        ]);



        $user->assignRole("Admin");

        $user = User::create([

            'name' => 'Asrama Putra',
            'email' => 'pamong@putra.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'active' => 1,
            'remember_token' => Str::random(10)

        ]);



        $user->assignRole("Pamong Putra");

        $user = User::create([

            'name' => 'Asrama Putri',
            'email' => 'pamong@putri.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'active' => 1,
            'remember_token' => Str::random(10)

        ]);



        $user->assignRole("Pamong Putri");

        $user = User::create([

            'name' => 'Martin Herlina',
            'email' => 'martin@herlina.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'active' => 1,
            'remember_token' => Str::random(10)

        ]);



        $user->assignRole("Pamong Putri");
    }
}
