<?php

namespace Database\Seeders;

use App\Enums\CustomerRoleEnum;
use App\Enums\UserRoleEnum;
use App\Models\Collaborator;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [];

        $faker = \Faker\Factory::create();

        $collaboratores = Collaborator::query()->pluck('id')->toArray();

        $arr[] = [
            'name'                  => 'customer',
            'email'                 => 'customer@gmail.com',
            'password'              => Hash::make(123456),
            'gender'                => 1,
            'photo'                 => null,
            'phone_number'          => null,
            'address'               => null,
            'description'           => null,
            'customer_role'         => 1,
            'user_role'             => 3,
            'accumulated_points'    => null,
            'collaborator_id'       => null,
            'remember_token'        => null,
            'birthday'              => null,
        ];
        $arr[] = [
            'name'                  => 'super_admin',
            'email'                 => 'super_admin@gmail.com',
            'password'              => Hash::make(123456),
            'gender'                => 1,
            'photo'                 => null,
            'phone_number'          => null,
            'address'               => null,
            'description'           => null,
            'customer_role'         => 1,
            'user_role'             => 1,
            'accumulated_points'    => null,
            'collaborator_id'       => null,
            'remember_token'        => null,
            'birthday'              => null,
        ];

        $arr[] = [
            'name'                  => 'owner',
            'email'                 => 'owner@gmail.com',
            'password'              => Hash::make(123456),
            'gender'                => 1,
            'photo'                 => null,
            'phone_number'          => null,
            'address'               => null,
            'description'           => null,
            'customer_role'         => 7,
            'user_role'             => 1,
            'accumulated_points'    => null,
            'collaborator_id'       => null,
            'remember_token'        => null,
            'birthday'              => null,
        ];

        foreach ($arr as $index => $value) {
            User::insert($value);
        }
    }
}
