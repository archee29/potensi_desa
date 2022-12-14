<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Desa Kalimas',
            'email' => 'desakalimas@gmail.com',
            'password' => Hash::make('desakalimas'),
        ]);
        DB::table('users')->insert([
            'name' => 'Desa Kalimas',
            'email' => 'aa@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
