<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PemerintahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pemerintahan = [
            [
                'name' => 'Adam Ibnu',
                'jabatan' => 'Budak',
                'image' => '1.png',
                'created_at' => '2021-10-20 11:11:57',
            ],
            [
                'name' => 'Trio',
                'jabatan' => 'Kapitalis',
                'image' => '4.jpg',
                'created_at' => '2020-01-01 11:11:57'
            ],
            [
                'name' => 'Sigit',
                'jabatan' => 'Koruptor',
                'image' => '5.jpg',
                'created_at' => '2020-6-01 11:11:57'
            ],
        ];

        DB::table('tb_pemerintahan')->insert($pemerintahan);
    }
}
