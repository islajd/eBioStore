<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Islajd',
            'last_name' => 'Meco',
            'email' => 'islajd.meco@fshnstudent.info',
            'password' => Hash::make('Islajd12345.'),
            'phone_number' => '+355697419919',
            'address' => 'Erseke',
            'role_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
