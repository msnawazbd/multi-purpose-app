<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Seeder;

class TaxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taxes = [
            [
                'name' => 'Tax(5%)',
                'rate' => 5,
                'description' => 'details...',
                'created_by' => 1
            ],
            [
                'name' => 'Tax(10%)',
                'rate' => 10,
                'description' => 'details...',
                'created_by' => 1
            ],
            [
                'name' => 'Tax(15%)',
                'rate' => 15,
                'description' => 'details...',
                'created_by' => 1
            ],
        ];

        foreach ($taxes as $key => $tax) {
            Tax::query()->create($tax);
        }
    }
}
