<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Fruits',
        ]);
        DB::table('categories')->insert([
            'name' => 'Vegetables',
        ]);
        DB::table('categories')->insert([
            'name' => 'Grains',
        ]);
        DB::table('categories')->insert([
            'name' => 'Legumes',
        ]);
        DB::table('categories')->insert([
            'name' => 'Nuts and Seeds',
        ]);
        DB::table('categories')->insert([
            'name' => 'Meats and Poultry',
        ]);
        DB::table('categories')->insert([
            'name' => 'Spices',
        ]);
        DB::table('categories')->insert([
            'name' => 'Others',
        ]);
    }
}
