<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = [
            [
                'blog_category_id' => 1,
                'post_title' => 'What is Lorem Ipsum?',
                'post_slug' => 'what-is-lorem-ipsum',
                'post_details' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
                'featured_image' => 'b-1.jpg',
                'meta_title' => 'What is Lorem Ipsum?',
                'meta_keywords' => 'what, is, lorem, ipsum',
                'meta_description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
                'created_by' => 1,
            ],
            [
                'blog_category_id' => 2,
                'post_title' => 'Why do we use it?',
                'post_slug' => 'why-do-we-use-it',
                'post_details' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
                'featured_image' => 'b-2.jpg',
                'meta_title' => 'Why do we use it?',
                'meta_keywords' => 'why, do, use, it',
                'meta_description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
                'created_by' => 1,
            ],
            [
                'blog_category_id' => 1,
                'post_title' => 'How to use it?',
                'post_slug' => 'how-to-use-it',
                'post_details' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
                'featured_image' => 'b-3.jpg',
                'meta_title' => 'How to use it?',
                'meta_keywords' => 'why, do, use, it',
                'meta_description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
                'created_by' => 1,
            ]
        ];

        foreach ($posts as  $post) {
            BlogPost::query()->create($post);
        }
    }
}
