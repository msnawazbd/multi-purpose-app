<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Business',
                'created_by' => 1
            ],
            [
                'name' => 'Marketing',
                'created_by' => 1
            ]
        ];

        foreach ($categories as $category) {
            BlogCategory::query()->create($category);
        }
    }
}
