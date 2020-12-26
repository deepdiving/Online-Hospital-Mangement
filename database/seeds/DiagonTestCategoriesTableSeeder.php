<?php

use Illuminate\Database\Seeder;

use App\Models\diagonstic\TestCategory;

class DiagonTestCategoriesTableSeeder extends Seeder
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
                'category'   => 'Pathological Test',
                'commission' => 10,
                'created_at' => now(),
            ],
            [
                'category'   => 'Ultrasonography(2D Color)',
                'commission' => 10,
                'created_at' => now(),
            ],
            [
                'category'   => 'Ultrasonography(2D & Black & White)',
                'commission' => 10,
                'created_at' => now(),
            ],
            [
                'category'   => 'Digital X-RAY',
                'commission' => 10,
                'created_at' => now(),
            ],
            [
                'category'   => 'Digital Memography',
                'commission' => 10,
                'created_at' => now(),
            ],
            [
                'category'   => 'Computed Tomography',
                'commission' => 10,
                'created_at' => now(),
            ],
            [
                'category'   => 'Stool Examination',
                'commission' => 10,
                'created_at' => now(),
            ],
            [
                'category'   => 'Others Examination',
                'commission' => 10,
                'created_at' => now(),
            ],
            [
                'category'   => 'Normal X-RAY',
                'commission' => 10,
                'created_at' => now(),
            ],
            [
                'category'   => 'Pecial Examination',
                'commission' => 10,
                'created_at' => now(),
            ],
        ];

        DB::table('diagon_test_categories')->insert($data);
    }
}
