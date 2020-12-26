<?php

use Illuminate\Database\Seeder;

class TaxesTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'tax_name' =>'income tax',
                'slug' => 'income-tax',
                'tax_amount' =>'5',
                'description' => 'Peices',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],

        ];

        DB::table('pharma_product_taxes')->insert($data);
    }
}
