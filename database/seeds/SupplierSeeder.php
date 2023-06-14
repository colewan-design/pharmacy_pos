<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suppliers')->delete();

        DB::table('suppliers')->insert([
            'supplierName' => "Supplier1",
            'supplierDescription' => "test",
            'supplierUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
            'deleted_at' => NULL,
        ]);

        DB::table('suppliers')->insert([
            'supplierName' => "Supplier2",
            'supplierDescription' => "test",
            'supplierUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
            'deleted_at' => NULL,
        ]);

        DB::table('suppliers')->insert([
            'supplierName' => "Supplier3",
            'supplierDescription' => "test",
            'supplierUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
            'deleted_at' => NULL,
        ]);

        DB::table('suppliers')->insert([
            'supplierName' => "Supplier4",
            'supplierDescription' => "test",
            'supplierUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
            'deleted_at' => NULL,
        ]);

        DB::table('suppliers')->insert([
            'supplierName' => "Supplier5",
            'supplierDescription' => "test",
            'supplierUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
            'deleted_at' => NULL,
        ]);
    }
}
