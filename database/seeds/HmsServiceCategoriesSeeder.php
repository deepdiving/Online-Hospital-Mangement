<?php

use Illuminate\Database\Seeder;
use App\Models\hospital\HmsServiceCategory;

class HmsServiceCategoriesSeeder extends Seeder
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
                'name'    => 'Admission',
                'slug'    => 'Admission',
                'status'  => 'Active',
                'user_id' => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'    => 'Short-term hospitalization',
                'slug'    => 'Short-term hospitalization',
                'status'  => 'Active',
                'user_id' => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'    => 'Emergency room services',
                'slug'    => 'Emergency room services',
                'status'  => 'Active',
                'user_id' => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'    => 'General and specialty surgical services',
                'slug'    => 'General and specialty surgical services',
                'status'  => 'Active',
                'user_id' => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'    => 'X ray/radiology services',
                'slug'    => 'X ray/radiology services',
                'status'  => 'Active',
                'user_id' => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'    => 'Laboratory services',
                'slug'    => 'Laboratory services',
                'status'  => 'Active',
                'user_id' => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'    => 'Blood services',
                'slug'    => 'Blood services',
                'status'  => 'Active',
                'user_id' => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'    => 'Primary care services',
                'slug'    => 'Primary care services',
                'status'  => 'Active',
                'user_id' => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'    => 'Mental health and drug treatment',
                'slug'    => 'Mental health and drug treatment',
                'status'  => 'Active',
                'user_id' => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'    => 'Infectious disease clinics',
                'slug'    => 'Infectious disease clinics',
                'status'  => 'Active',
                'user_id' => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'    => 'Hospice care',
                'slug'    => 'Hospice care',
                'status'  => 'Active',
                'user_id' => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'    => 'Dental services',
                'slug'    => 'Dental services',
                'status'  => 'Active',
                'user_id' => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'    => 'Translation and interpreter services',
                'slug'    => 'Translation and interpreter services',
                'status'  => 'Active',
                'user_id' => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],
            
        ];

        DB::table('hms_service_categories')->insert($data);
    }
}
