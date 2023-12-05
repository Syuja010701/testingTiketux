<?php

namespace Database\Seeders;

use App\Models\ChartOfAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChartOfAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kode' => '401', 'nama' => 'Gaji Karyawan', 'kategori_coa_id' => 1],
            ['kode' => '402', 'nama' => 'Gaji Ketua MPR', 'kategori_coa_id' => 1],
            ['kode' => '403', 'nama' => 'Profit Trading', 'kategori_coa_id' => 2],
            ['kode' => '601', 'nama' => 'Biaya Sekolah', 'kategori_coa_id' => 3],
            ['kode' => '602', 'nama' => 'Bensin', 'kategori_coa_id' => 4],
            ['kode' => '603', 'nama' => 'Parkir', 'kategori_coa_id' => 4],
            ['kode' => '604', 'nama' => 'Makan Siang', 'kategori_coa_id' => 5],
            ['kode' => '605', 'nama' => 'Makan Pokok Bulanan', 'kategori_coa_id' => 5],
        ];

        ChartOfAccount::insert($data);
    }
}
