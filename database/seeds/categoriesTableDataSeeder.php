<?php

use Illuminate\Database\Seeder;
use App\Models\Pharma\Category;

class categoriesTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Category::create([
            'name' => 'Antibiotics',
            'slug' => 'antibiotics',
            'description' => 'Antibiotics',
            'status' => 'Active',
            'user_id' => '1',
            'created_at'    => now(),
            'updated_at'    => now()
        ]);
        Category::create([
            'name' => 'Paracetamol',
            'slug' => 'paracetamol',
            'description' => 'Paracetamol',
            'status' => 'Active',
            'user_id' => '1',
            'created_at'    => now(),
            'updated_at'    => now()
        ]);
    }
}
