<?php

namespace Database\Factories;

use App\Enums\CollaboratorRoleEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Collaborator>
 */
class CollaboratorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'                  => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email'                 => $this->faker->email(),
            'password'              => Hash::make(123456),
            'gender'                => $this->faker->boolean(),
            'photo'                 => null,
            'birthday'              => null,
            'phone_number'          => null,
            'address'               => $this->faker->streetAddress(),
            'description'           => null,
            'role'                  => $this->faker->randomElement(CollaboratorRoleEnum::getValues()),
            'accumulated_points'    => null,
            'f0_id'                 => null,
        ];
    }
}
