<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //allow maximum 65;
        factory(App\Models\Pharma\Product::class,60)->create();
    }
}
