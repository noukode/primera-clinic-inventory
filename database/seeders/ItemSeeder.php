<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::insert([
            [
                'kode_item' => 'A-01',
                'name' => 'Alat Rontgen',
                'category_id' => 1,
                'unit_id' => 1,
            ],
            [
                'kode_item' => 'A-02',
                'name' => 'Masker',
                'category_id' => 2,
                'unit_id' => 2,
            ],
        ]);
    }
}
