<?php

namespace Database\Seeders;

use App\Models\Directory\Plan;
use Illuminate\Database\Seeder;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'title' => 'Free',
                'original_price' => 0.00,
                'discounted_price' => 0.00,
                'validity' => -1,
                'listings' => 1,
                'categories' => 2,
                'photos' => 5,
                'videos' => 5,
                'tags' => 5,
                'amenities' => 10,
                'products' => 5,
                'services' => 5,
                'articles' => 5,
                'featured_listings' => 0,
                'contact_form' => 0,
                'social_items' => 0,
                'status' => 1,
                'created_by' => 1,
            ],
            [
                'title' => 'Standard',
                'original_price' => 149.99,
                'discounted_price' => 99.99,
                'validity' => 90,
                'listings' => 5,
                'categories' => 5,
                'photos' => 10,
                'videos' => 10,
                'tags' => 10,
                'amenities' => 20,
                'products' => 10,
                'services' => 10,
                'articles' => 10,
                'featured_listings' => 1,
                'contact_form' => 1,
                'social_items' => 1,
                'status' => 1,
                'created_by' => 1,
            ],
            [
                'title' => 'Advance',
                'original_price' => 299.99,
                'discounted_price' => 199.99,
                'validity' => 365,
                'listings' => 15,
                'categories' => 5,
                'photos' => -1,
                'videos' => -1,
                'tags' => -1,
                'amenities' => -1,
                'products' => -1,
                'services' => -1,
                'articles' => -1,
                'featured_listings' => 1,
                'contact_form' => 1,
                'social_items' => 1,
                'status' => 1,
                'created_by' => 1,
            ]
        ];

        foreach ($plans as $plan) {
            Plan::query()->create($plan);
        }
    }
}
