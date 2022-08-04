<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
            [
                'country_id' => 1,
                'state_name' => 'California',
                'state_abbreviation' => 'California',
                'state_slug' => 'california',
                'created_by' => 1,
            ],
            [
                'country_id' => 1,
                'state_name' => 'Texas',
                'state_abbreviation' => 'Texas',
                'state_slug' => 'texas',
                'created_by' => 1,
            ],
            [
                'country_id' => 2,
                'state_name' => 'Dhaka',
                'state_abbreviation' => 'Dhaka',
                'state_slug' => 'dhaka',
                'created_by' => 1,
            ],
            [
                'country_id' => 2,
                'state_name' => 'Rangpur',
                'state_abbreviation' => 'Rangpur',
                'state_slug' => 'rangpur',
                'created_by' => 1,
            ],
        ];

        foreach ($states as  $state) {
            State::query()->create($state);
        }
    }
}
