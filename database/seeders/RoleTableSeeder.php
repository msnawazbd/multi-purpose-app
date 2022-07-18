<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin', 'created_by' => 1]);
        Role::create(['name' => 'client', 'created_by' => 1]);
        Role::create(['name' => 'user', 'created_by' => 1]);
    }
}
