<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'mobile' => $this->faker->unique()->phoneNumber(),
            'alternate_no' => $this->faker->unique()->phoneNumber(),
            'address' => $this->faker->address(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'country_id' => $this->faker->biasedNumberBetween(1,239),
            'state' => $this->faker->streetName(),
            'city' => $this->faker->city(),
            'postal_code' => $this->faker->postcode(),
            'reference_name' => $this->faker->name(),
            'reference_mobile' => $this->faker->unique()->phoneNumber(),
            'created_by' => 1,
        ];
    }
}
