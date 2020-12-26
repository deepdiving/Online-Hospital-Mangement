<?php

use Illuminate\Database\Seeder;
use App\Models\hospital\HmsService;

class HmsServicesSeeder extends Seeder
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
                'name'                => 'Admission',
                'slug'                => 'Admission',
                'price'               => '200',
                'status'              => 'Active',
                'service_category_id' => '1',
                'user_id'             => '5',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'name'                => 'Pediatric specialty care',
                'slug'                => 'Pediatric specialty care',
                'price'               => '500',
                'status'              => 'active',
                'service_category_id' => '2',
                'user_id'             => '5',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'name'                => 'Greater access to surgical specialists',
                'slug'                => 'greater access to surgical specialists',
                'price'               => '700',
                'status'              => 'Active',
                'service_category_id' => '2',
                'user_id'             => '5',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'name'                => 'Physical therapy and rehabilitation services',
                'slug'                => 'Physical therapy and rehabilitation services',
                'price'               => '1000',
                'status'              => 'Active',
                'service_category_id' => '2',
                'user_id'             => '5',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'name'                => 'Prescription services',
                'slug'                => 'Prescription services',
                'price'               => '1200',
                'status'              => 'Active',
                'service_category_id' => '3',
                'user_id'             => '5',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'name'                => 'Home nursing services',
                'slug'                => 'Home nursing services',
                'price'               => '1500',
                'status'              => 'Active',
                'service_category_id' => '3',
                'user_id'             => '5',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'name'                => 'Nutritional counseling',
                'slug'                => 'Nutritional counseling',
                'price'               => '1700',
                'status'              => 'Active',
                'service_category_id' => '4',
                'user_id'             => '5',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'name'                => 'Mental health care',
                'slug'                => 'Mental health care',
                'price'               => '2000',
                'status'              => 'Active',
                'service_category_id' => '4',
                'user_id'             => '5',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'name'                => 'Family support services',
                'slug'                => 'Family support services',
                'price'               => '2200',
                'status'              => 'Active',
                'service_category_id' => '5',
                'user_id'             => '5',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'name'                => 'Genetic counseling and testing',
                'slug'                => 'Genetic counseling and testing',
                'price'               => '2500',
                'status'              => 'Active',
                'service_category_id' => '5',
                'user_id'             => '5',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'name'                => 'Social work or case management services',
                'slug'                => 'Social work or case management services',
                'price'               => '2700',
                'status'              => 'Active',
                'service_category_id' => '6',
                'user_id'             => '5',
                'created_at'          => now(),
                'updated_at'          => now()
            ], 
        ];

        DB::table('hms_services')->insert($data);
    }
}
