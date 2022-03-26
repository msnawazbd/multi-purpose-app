<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client_id' => $this->faker->biasedNumberBetween(1,25),
            'date' => $this->faker->dateTimeBetween('-5 days', '+5 days'),
            'time' => $this->faker->time(),
            'status' => $this->faker->randomElement(['SCHEDULED', 'CLOSED']),
            'note' => $this->faker->paragraph(),
            'color' => $this->faker->hexColor(),
        ];
    }
}
