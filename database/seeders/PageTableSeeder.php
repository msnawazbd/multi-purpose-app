<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'page_name' => 'About Us',
                'page_slug' => 'about-us',
                'page_title' => 'What is Lorem Ipsum?',
                'page_details' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
                'meta_title' => 'What is Lorem Ipsum?',
                'meta_keywords' => 'what, is, lorem, ipsum',
                'meta_description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
                'created_by' => 1,
            ],
            [
                'page_name' => 'Privacy Policy',
                'page_slug' => 'privacy-policy',
                'page_title' => 'What is Lorem Ipsum?',
                'page_details' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
                'meta_title' => 'What is Lorem Ipsum?',
                'meta_keywords' => 'what, is, lorem, ipsum',
                'meta_description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
                'created_by' => 1,
            ],
        ];

        foreach ($pages as  $page) {
            Page::query()->create($page);
        }
    }
}
