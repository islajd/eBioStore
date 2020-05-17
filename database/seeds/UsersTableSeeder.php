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
            'first_name' => 'Regi',
            'last_name' => 'Muci',
            'email' => 'regi_muci@hotmail.com',
            'password' => Hash::make('regi1234'),
            'phone_number' => '0696913777',
            'address' => 'Erseke',
            'role_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
