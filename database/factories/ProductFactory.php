<?php

namespace Database\Factories;

use App\Models\Manufacturer;
use App\Models\Size;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $manufactureres = Manufacturer::query()->pluck('id')->toArray();

        $sizes          = Size::query()->pluck('id')->toArray();

        $types          = Type::query()->pluck('id')->toArray();

        return [
            'name'                  => $this->faker->word(),
            'quantity'              => $this->faker->numberBetween(30, 50),
            'photo'                 => $this->faker->imageUrl(),
            'price'                 => $this->faker->numberBetween(200000, 500000),
            'manufacturer_id'       => $this->faker->randomElement($manufactureres),
            'type_id'               => $this->faker->randomElement($types),
            'size_id'               => $this->faker->randomElement($sizes),
        ];
    }
}
