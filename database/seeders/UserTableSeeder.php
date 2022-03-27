<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'admin@mail.com',
                'mobile' => '01761913331',
                'alternate_no' => '01515697999',
                'address' => '8/2 Shukrabad',
                'gender' => 'male',
                'country_id' => 1,
                'state' => 'Dhanmondi',
                'city' => 'Dhaka',
                'zip_code' => '1207',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'role' => 'admin',
                'activation_status' => 1,
            ],
            [
                'name' => 'John Wick',
                'email' => 'client@mail.com',
                'mobile' => '01515697999',
                'alternate_no' => '01761913331',
                'address' => '23/1 Shatgara Masterpara',
                'gender' => 'male',
                'country_id' => 1,
                'state' => 'Terminal',
                'city' => 'Rangpur',
                'zip_code' => '5401',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'role' => 'client',
                'activation_status' => 1,
            ],
            [
                'name' => 'John Cena',
                'email' => 'user@mail.com',
                'mobile' => '01717888464',
                'alternate_no' => '01761913331',
                'address' => '23/1 Shatgara Masterpara',
                'gender' => 'male',
                'country_id' => 1,
                'state' => 'Terminal',
                'city' => 'Rangpur',
                'zip_code' => '5401',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'role' => 'user',
                'activation_status' => 1,
            ],
        ];

        foreach ($users as $key => $user) {
            User::query()->create($user);
        }
    }
}
