<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            'user_id' => 2,
            'first_name' => 'Jhon',
            'last_name' => 'Wick',
            'reference_name' => 'jhon Doe',
            'reference_mobile' => '01761913331',
            'details' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid aut beatae cum explicabo facere illum itaque rem reprehenderit rerum vel.',
            'status' => 1,
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
