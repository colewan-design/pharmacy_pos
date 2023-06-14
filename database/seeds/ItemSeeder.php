<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->delete();

        DB::table('items')->insert([
            'categoryId' => "1",
            'itemName' => "Coke",
            'itemDescription' =>'acid drink',
            'itemQty' => "1000",
            'itemPrice' =>'18',
            'itemUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
            'deleted_at' => NULL,
        ]);

        DB::table('items')->insert([
            'categoryId' => "2",
            'itemName' => "Alaxan",
            'itemDescription' =>'headache pill',
            'itemQty' => "1000",
            'itemPrice' =>'6',
            'itemUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
            'deleted_at' => NULL,
        ]);

        DB::table('items')->insert([
            'categoryId' => "3",
            'itemName' => "Sleeping Pills",
            'itemDescription' =>'none',
            'itemQty' => "1000",
            'itemPrice' =>'18',
            'itemUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
            'deleted_at' => NULL,
        ]);

        DB::table('items')->insert([
            'categoryId' => "4",
            'itemName' => "House Loan",
            'itemDescription' =>'housing',
            'itemQty' => "1000",
            'itemPrice' =>'18',
            'itemUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
            'deleted_at' => NULL,
        ]);

        DB::table('items')->insert([
            'categoryId' => "5",
            'itemName' => "Jordan 1",
            'itemDescription' =>'nike shoes',
            'itemQty' => "1000",
            'itemPrice' =>'5000',
            'itemUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
            'deleted_at' => NULL,
        ]);
    }
}
