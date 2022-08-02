<?php

namespace Database\Seeders;

use App\Models\Subscribe;
use Illuminate\Database\Seeder;

class SubscribeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subscribes = [
            [
                'email' => 'info@mail.com',
            ],
            [
                'email' => 'contact@mail.com',
            ],
        ];

        foreach ($subscribes as  $subscribe) {
            Subscribe::query()->create($subscribe);
        }
    }
}
