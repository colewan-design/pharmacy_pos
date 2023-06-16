<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
         // Create a Superadmin user
         DB::table('users')->insert([
            'id' => '1',
             'fullname' => 'Admin',
             'email' => 'admin@admin.com',
             'password' => Hash::make('123456'),
             'role_id' => '1',
             'position' => 'Admin',
             'created_at' => now(),
             'updated_at' => NULL,
             'deleted_at' => NULL,
         ]);

    }
}
