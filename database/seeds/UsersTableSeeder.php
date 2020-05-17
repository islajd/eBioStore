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

        DB::table('users')->insert([
            'first_name' => 'Regi',
            'last_name' => 'Muci',
            'email' => 'regi.muci@shnstudent.info',
            'password' => Hash::make('regi1234'),
            'phone_number' => '0696913777',
            'address' => 'Erseke',
            'role_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'first_name' => 'Tea',
            'last_name' => 'Lico',
            'email' => 'tea.lico@fshnstudent.info',
            'password' => Hash::make('tea1234'),
            'phone_number' => '0675913717',
            'address' => 'Erseke',
            'role_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'first_name' => 'Juliana',
            'last_name' => 'Isallari',
            'email' => 'juliana.isallari@fshnstudent.info',
            'password' => Hash::make('juliana1234'),
            'phone_number' => '0687843911',
            'address' => 'Korce',
            'role_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
