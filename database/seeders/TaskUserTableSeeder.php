<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasks_users = [
            [
                'task_id' => 1,
                'user_id' => 1,
            ],
            [
                'task_id' => 1,
                'user_id' => 2,
            ],
            [
                'task_id' => 2,
                'user_id' => 1,
            ],
            [
                'task_id' => 2,
                'user_id' => 2,
            ],
            [
                'task_id' => 3,
                'user_id' => 1,
            ],
            [
                'task_id' => 3,
                'user_id' => 2,
            ],
            [
                'task_id' => 4,
                'user_id' => 1,
            ],
            [
                'task_id' => 4,
                'user_id' => 2,
            ],
            [
                'task_id' => 5,
                'user_id' => 1,
            ],
            [
                'task_id' => 5,
                'user_id' => 2,
            ],
            [
                'task_id' => 6,
                'user_id' => 2,
            ],
            [
                'task_id' => 7,
                'user_id' => 1,
            ],
            [
                'task_id' => 8,
                'user_id' => 2,
            ],
            [
                'task_id' => 9,
                'user_id' => 1,
            ],
            [
                'task_id' => 10,
                'user_id' => 2,
            ],
        ];

        foreach ($tasks_users as $key => $task_user) {
            DB::table('task_user')->insert([
                'task_id' => $task_user['task_id'],
                'user_id' => $task_user['user_id'],
            ]);
        }
    }
}
