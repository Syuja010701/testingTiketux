<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaksi::insert([
            [
                'tanggal' => '2022-01-01',
                'coa_id' => 1,
                'desc' => 'Gaji Di Persuhaan A',
                'debit' => 0,
                'credit' => 5000000,
            ],
            [
                'tanggal' => '2022-01-02',
                'coa_id' => 2,
                'desc' => 'Gaji Ketum',
                'debit' => 0,
                'credit' => 7000000,
            ],
            [
                'tanggal' => '2022-01-10',
                'coa_id' => 5,
                'desc' => 'Bensin Anak',
                'debit' => 25000,
                'credit' => 0,
            ],
        ]);
    }
}
