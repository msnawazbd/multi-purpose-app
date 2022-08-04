<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            [
                'state_id' => 1,
                'city_name' => 'Los Angeles',
                'city_abbreviation' => 'Los Angeles',
                'city_slug' => 'los-angeles',
                'created_by' => 1,
            ],
            [
                'state_id' => 1,
                'city_name' => 'San Diego',
                'city_abbreviation' => 'San Diego',
                'city_slug' => 'san-diego',
                'created_by' => 1,
            ],
            [
                'state_id' => 2,
                'city_name' => 'Houston',
                'city_abbreviation' => 'Houston',
                'city_slug' => 'houston',
                'created_by' => 1,
            ],
            [
                'state_id' => 2,
                'city_name' => 'San Antonio',
                'city_abbreviation' => 'San Antonio',
                'city_slug' => 'san-antonio',
                'created_by' => 1,
            ],
            [
                'state_id' => 3,
                'city_name' => 'Gazipur',
                'city_abbreviation' => 'Gazipur',
                'city_slug' => 'gazipur',
                'created_by' => 1,
            ],
            [
                'state_id' => 3,
                'city_name' => 'Narayanganj',
                'city_abbreviation' => 'Narayanganj',
                'city_slug' => 'narayanganj',
                'created_by' => 1,
            ],
            [
                'state_id' => 4,
                'city_name' => 'Dinajpur',
                'city_abbreviation' => 'Dinajpur',
                'city_slug' => 'dinajpur',
                'created_by' => 1,
            ],
            [
                'state_id' => 4,
                'city_name' => 'Lalmonirhat',
                'city_abbreviation' => 'Lalmonirhat',
                'city_slug' => 'lalmonirhat',
                'created_by' => 1,
            ],
        ];

        foreach ($cities as  $city) {
            City::query()->create($city);
        }
    }
}
