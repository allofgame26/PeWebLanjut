<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class supplierseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['supplier_id' => 1, 'supplier_kode' => 'supp_1', 'supplier_nama' => 'Supplier Satu', 'supplier_alamat' => 'Malang'],
            ['supplier_id' => 2, 'supplier_kode' => 'supp_2', 'supplier_nama' => 'Supplier Dua', 'supplier_alamat' => 'Blitar'],
            ['supplier_id' => 3, 'supplier_kode' => 'supp_3', 'supplier_nama' => 'Supplier Tiga', 'supplier_alamat' => 'Jakarta'],

        ];
        DB::table('m_supplier')->insert($data);
    }
}
