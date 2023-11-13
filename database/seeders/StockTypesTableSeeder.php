<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StockTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('stock_types')->delete();
        
        \DB::table('stock_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'MCU',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Jasa Medis',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}