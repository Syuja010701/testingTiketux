<?php

namespace Database\Seeders;

use App\Models\KategoriCoa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriCoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayKategory = ['Salary', 'Other Income', 'Family Expense', 'Transport Expense', 'Meal Expense'];
        
        foreach ($arrayKategory as $value) {
            KategoriCoa::create([
                'nama' => $value
            ]);
        }

    }
}
