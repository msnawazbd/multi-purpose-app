<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'create posts', 'created_by' => 1]);
        Permission::create(['name' => 'read posts', 'created_by' => 1]);
        Permission::create(['name' => 'update posts', 'created_by' => 1]);
        Permission::create(['name' => 'delete posts', 'created_by' => 1]);
    }
}
