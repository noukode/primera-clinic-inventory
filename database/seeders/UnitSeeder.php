<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::insert([
            [
                'name' => 'pcs',
                'slug' => 'pcs',
            ],
            [
                'name' => 'pack',
                'slug' => 'pack',
            ],
            [
                'name' => 'roll',
                'slug' => 'roll',
            ],
        ]);
    }
}
