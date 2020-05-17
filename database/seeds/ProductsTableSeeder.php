<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Apples',
            'price' => 2,
            'description' => 'Red Apples',
            'stock' => 100,
            'category_id' => 1,
            'measurement_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'name' => 'Oranges',
            'price' => 1.5,
            'stock' => 90,
            'category_id' => 1,
            'measurement_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'name' => 'Pears',
            'price' => 3.5,
            'stock' => 120,
            'category_id' => 1,
            'measurement_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'name' => 'Carrots',
            'price' => 2.5,
            'stock' => 100,
            'category_id' => 2,
            'measurement_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'name' => 'Tomatoes',
            'price' => 2,
            'stock' => 90,
            'category_id' => 2,
            'measurement_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'name' => 'Barley',
            'price' => 1.5,
            'stock' => 90,
            'category_id' => 3,
            'measurement_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'name' => 'Oats',
            'price' => 2,
            'stock' => 110,
            'category_id' => 3,
            'measurement_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'name' => 'Beans',
            'price' => 4,
            'description' => 'White Beans',
            'stock' => 200,
            'category_id' => 4,
            'measurement_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'name' => 'Peanuts',
            'price' => 1.5,
            'stock' => 100,
            'category_id' => 5,
            'measurement_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'name' => 'Pumpkin Seeds',
            'price' => 1.5,
            'stock' => 100,
            'category_id' => 5,
            'measurement_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'name' => 'Sunflower Seeds',
            'price' => 1.5,
            'stock' => 100,
            'category_id' => 5,
            'measurement_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'name' => 'Oregano',
            'price' => 2.5,
            'stock' => 110,
            'category_id' => 7,
            'measurement_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
