<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lokasi = [
            ['nama_desa' => 'Desa Kalimas',
            'image'=>'1669609114_1669069583_kuburaya (6).png',
            'location'=>'-0.1277952 , 109.4090752',
            'keterangan'=>'Desa Kalimas'
            ],
        ];
        DB::table('tb_lokasi')->insert($lokasi);
    }
}
