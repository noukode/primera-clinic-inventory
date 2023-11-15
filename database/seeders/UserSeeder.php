<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Hilmi',
                'email' => 'maulanahilmi909@gmail.com',
                'password' => '$2a$12$DXPrFL5knOHiknwh.iLV5.MtCbv16yop1aA1L3CEkwB.qehPl.p3a',
                'role_id' => 1
            ]
        ]);
    }
}
