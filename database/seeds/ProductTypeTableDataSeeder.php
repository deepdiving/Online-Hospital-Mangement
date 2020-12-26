<?php

use Illuminate\Database\Seeder;
use App\Models\Pharma\ProductType;
class ProductTypeTableDataSeeder extends Seeder
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
                'type_name' =>'Tablet',
                'slug' => 'tablet',
                'description' => 'Tablet',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'type_name' =>'Liquid',
                'slug' => 'liquid',
                'description' => 'Liquid',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],

        ];

        DB::table('pharma_product_types')->insert($data);
    }
}
