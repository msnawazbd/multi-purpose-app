<?php

namespace Database\Seeders;

use App\Models\Country;
use DB;
use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            [
                'country_name' => 'United States',
                'country_abbreviation' => 'USA',
                'country_slug' => 'usa'
            ],
            [
                'country_name' => 'Bangladesh',
                'country_abbreviation' => 'BD',
                'country_slug' => 'bd'
            ],
        ];

        foreach ($countries as  $country) {
            Country::query()->create($country);
        }
    }
}
