<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subject' => $this->faker->paragraph(1),
            'start_date' => $this->faker->dateTimeBetween('-10 days', 'now'),
            'deadline' => $this->faker->dateTimeBetween('now', '+10 days'),
            'priority' => $this->faker->randomElement(['LOW', 'MEDIUM', 'HIGH', 'URGENT']),
            'status' => $this->faker->randomElement(['NOT STARTED', 'IN PROGRESS', 'COMPLETED', 'DEFERRED']),
            'description' => $this->faker->paragraph(),
            'created_by' => $this->faker->biasedNumberBetween(1,2)
        ];
    }
}
