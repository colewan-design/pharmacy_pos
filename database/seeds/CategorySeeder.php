<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->delete();

        DB::table('categories')->insert([
            'departmentId' => "1",
            'categoryName' => "SoftDrinks",
            'categoryDescription' =>'test',
            'categoryStyle' => "#FFB6C1",
            'categoryUse' => now(),
            'updated_at' => NULL,
            'deleted_at' => NULL,
        ]);

        DB::table('categories')->insert([
            'departmentId' => "2",
            'categoryName' => "Medicine",
            'categoryDescription' =>'test',
            'categoryStyle' => "#FFB6C1",
            'categoryUse' => now(),
            'updated_at' => NULL,
            'deleted_at' => NULL,
        ]);

        DB::table('categories')->insert([
            'departmentId' => "3",
            'categoryName' => "Pills",
            'categoryDescription' =>'test',
            'categoryStyle' => "#FFB6C1",
            'categoryUse' => now(),
            'updated_at' => NULL,
            'deleted_at' => NULL,
        ]);

        DB::table('categories')->insert([
            'departmentId' => "4",
            'categoryName' => "Loans",
            'categoryDescription' =>'test',
            'categoryStyle' => "#FFB6C1",
            'categoryUse' => now(),
            'updated_at' => NULL,
            'deleted_at' => NULL,
        ]);

        DB::table('categories')->insert([
            'departmentId' => "5",
            'categoryName' => "Shoes",
            'categoryDescription' =>'test',
            'categoryStyle' => "#FFB6C1",
            'categoryUse' => now(),
            'updated_at' => NULL,
            'deleted_at' => NULL,
        ]);
    }
}
