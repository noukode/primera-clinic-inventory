<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StocksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('stocks')->delete();
        
        \DB::table('stocks')->insert(array (
            0 => 
            array (
                'id' => 1,
                'item_id' => 1,
                'quantity' => 100,
                'location_id' => 1,
                'stock_type_id' => 1,
                'condition' => 1,
                'exp_date' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'item_id' => 1,
                'quantity' => 20,
                'location_id' => 1,
                'stock_type_id' => 1,
                'condition' => 1,
                'exp_date' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'item_id' => 1,
                'quantity' => 50,
                'location_id' => 1,
                'stock_type_id' => 2,
                'condition' => 1,
                'exp_date' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'item_id' => 1,
                'quantity' => 30,
                'location_id' => 2,
                'stock_type_id' => 2,
                'condition' => 1,
                'exp_date' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}