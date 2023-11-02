<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserRole::insert(
            [
                [
                    'id' => 1,
                    'name' => 'Administrator',
                    'code' => 'ADMIN',
                ],
                [
                    'id' => 2,
                    'name' => 'Logistik',
                    'code' => 'LOGISTIK',
                ],
                [
                    'id' => 3,
                    'name' => 'PIC',
                    'code' => 'PIC',
                ],
            ]
        );
    }
}
