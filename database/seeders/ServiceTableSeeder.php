<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'name' => 'Wed Design',
                'amount' => 5000,
                'description' => 'details...',
                'created_by' => 1
            ],
            [
                'name' => 'eCommerce Development',
                'amount' => 35000,
                'description' => 'details...',
                'created_by' => 1
            ],
            [
                'name' => 'Mobile App Development',
                'amount' => 25000,
                'description' => 'details...',
                'created_by' => 1
            ],
            [
                'name' => 'SEO',
                'amount' => 12500,
                'description' => 'details...',
                'created_by' => 1
            ],
            [
                'name' => 'Database Design',
                'amount' => 15500,
                'description' => 'details...',
                'created_by' => 1
            ],
        ];

        foreach ($services as $key => $service) {
            Service::query()->create($service);
        }
    }
}
