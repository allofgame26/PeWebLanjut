<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class penjualanseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['user_id' => 1, 'pembeli' => 'Pembeli_1', 'penjualan_kode' => 'JL_1', 'penjualan_tanggal' => '2024-01-10'],
            ['user_id' => 1, 'pembeli' => 'Pembeli_2', 'penjualan_kode' => 'JL_2', 'penjualan_tanggal' => '2024-01-10'],
            ['user_id' => 1, 'pembeli' => 'Pembeli_3', 'penjualan_kode' => 'JL_3', 'penjualan_tanggal' => '2024-01-10'],
            ['user_id' => 3, 'pembeli' => 'Pembeli_4', 'penjualan_kode' => 'JL_4', 'penjualan_tanggal' => '2024-01-10'],
            ['user_id' => 3, 'pembeli' => 'Pembeli_5', 'penjualan_kode' => 'JL_5', 'penjualan_tanggal' => '2024-01-11'],
            ['user_id' => 3, 'pembeli' => 'Pembeli_6', 'penjualan_kode' => 'JL_6', 'penjualan_tanggal' => '2024-01-11'],
            ['user_id' => 3, 'pembeli' => 'Pembeli_7', 'penjualan_kode' => 'JL_7', 'penjualan_tanggal' => '2024-01-11'],
            ['user_id' => 3, 'pembeli' => 'Pembeli_8', 'penjualan_kode' => 'JL_8', 'penjualan_tanggal' => '2024-01-11'],
            ['user_id' => 2, 'pembeli' => 'Pembeli_9', 'penjualan_kode' => 'JL_9', 'penjualan_tanggal' => '2024-01-11'],
            ['user_id' => 2, 'pembeli' => 'Pembeli_10', 'penjualan_kode' => 'JL_10', 'penjualan_tanggal' => '2024-01-11'],           

        ];
        DB::table('t_penjualan')->insert($data);
    }
}
