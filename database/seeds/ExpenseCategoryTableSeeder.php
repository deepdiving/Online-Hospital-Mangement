<?php

use Illuminate\Database\Seeder;

class ExpenseCategoryTableSeeder extends Seeder
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
                'category_name' =>'Tax Payment',
                'slug' => 'tax-payment',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],[
                'category_name' =>'Salary Payment',
                'slug' => 'salary-payment',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],[
                'category_name' =>'Utilites Bill',
                'slug' => 'utilites-bill',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],[
                'category_name' =>'Other Payment',
                'slug' => 'other-payment',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
        ];

        DB::table('expense_categories')->insert($data);
    }
}
