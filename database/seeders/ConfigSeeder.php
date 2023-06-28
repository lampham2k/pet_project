<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'min_price' => '100000',
            'max_price' => '1000000'
        ];

        $arr = [];

        foreach ($data as $key => $value) {
            $arr['ke_y']        =  $key;
            $arr['valu_e']      =  $value;
            $arr['is_public']   =  0;

            Config::insert($arr);
        }
    }
}
