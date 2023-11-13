<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::insert([
            [
                'branch_id' => 1,
                'name' => 'AA-01-01',
            ],
            [
                'branch_id' => 1,
                'name' => 'AA-01-02',
            ],
            [
                'branch_id' => 2,
                'name' => 'AA-01-01',
            ],
        ]);
    }
}
