<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $start_day = Carbon::instance($this->faker->dateTimeBetween('-1 months', '+1 months'));

        return [
            'name'                  => $this->faker->unique()->randomElement($arr = ['8/3', '20/11', 'new year', 'hallowen', 'christmas']),
            'money_reduced'         => $this->faker->numberBetween(20000, 100000),
            'start_date'            => Carbon::instance($this->faker->dateTimeBetween('-1 months', '+1 months')),
            'end_date'              => (clone $start_day)->addDays(random_int(2, 14)),
        ];
    }
}
