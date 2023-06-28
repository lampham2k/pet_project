<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manufacturer>
 */
class ManufacturerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return  [
            'address'           => $this->faker->streetAddress(),
            'name'              => $this->faker->unique()->randomElement($arrName = ['Nikes', 'Adidass', 'Vanss', 'Guccis', 'Converses']),
            'phone_number'      => null,
            'photo'             => null,
        ];
    }
}
