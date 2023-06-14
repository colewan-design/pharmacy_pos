<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        DB::table('roles')->insert([
            'fullname' => "Admin",
            'email' => "admin@admin.com",
            'password' =>'123456',
            'role_id' => 1,
            'position' => 'Admin',
            'created_at' => now(),
            'updated_at' => NULL,
            'deleted_at' => NULL,
        ]);

       
    }
}
