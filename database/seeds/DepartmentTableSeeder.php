<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->delete();

        DB::table('departments')->insert([
            'departmentName' => "Mini-Grocery",
            'departmentDescription' => "minigrocery",
            'departmentUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
        ]);

        DB::table('departments')->insert([
            'departmentName' => "Pharmacy",
            'departmentDescription' => "pharmacy",
            'departmentUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
        ]);

        DB::table('departments')->insert([
            'departmentName' => "Clinic",
            'departmentDescription' => "clinic",
            'departmentUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
        ]);

        DB::table('departments')->insert([
            'departmentName' => "Remittance",
            'departmentDescription' => "remittance",
            'departmentUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
        ]);

        DB::table('departments')->insert([
            'departmentName' => "Imported Goods",
            'departmentDescription' => "imported goods",
            'departmentUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
        ]);
    }
}
