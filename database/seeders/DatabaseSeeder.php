<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Collaborator;
use App\Models\Discount;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Size;
use App\Models\Type;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Manufacturer::factory(5)->create();
        Size::factory(5)->create();
        Type::factory(4)->create();
        Product::factory(10)->create();
        Discount::factory(3)->create();
        Collaborator::factory(10)->create();
        $this->call(UserSeeder::class);
        $this->call(ConfigSeeder::class);
    }
}
