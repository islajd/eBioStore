<?php

use Illuminate\Database\Seeder;

class MeasurementTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('measurement_types')->insert([
            'name' => 'Kg'
        ]);

        DB::table('measurement_types')->insert([
            'name' => 'Cope'
        ]);
    }
}
