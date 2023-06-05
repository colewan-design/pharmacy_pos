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
            'departmentName' => "Kitchen",
            'departmentDescription' => "Kitchen",
            'departmentUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
        ]);

        DB::table('departments')->insert([
            'departmentName' => "Bar",
            'departmentDescription' => "Bar",
            'departmentUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
        ]);

        DB::table('departments')->insert([
            'departmentName' => "Cashier",
            'departmentDescription' => "Cashier",
            'departmentUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
        ]);

        DB::table('departments')->insert([
            'departmentName' => "Outsourced",
            'departmentDescription' => "Outsourced",
            'departmentUse' =>'Y',
            'created_at' => now(),
            'updated_at' => NULL,
        ]);
    }
}
