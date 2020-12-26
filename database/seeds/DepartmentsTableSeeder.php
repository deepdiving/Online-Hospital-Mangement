<?php

use Illuminate\Database\Seeder;
use App\Department;

class DepartmentsTableSeeder extends Seeder
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
                'dep_name'    => 'ENT Surgeon',
                'description' => '',
                'status'      => 'Active',
                'user_id'     => '1',
                'created_at'  => now(),
                'updated_at'  => now()
            ],
            [
                'dep_name'    => 'Gynaecologist',
                'description' => '',
                'status'      => 'Active',
                'user_id'     => '2',
                'created_at'  => now(),
                'updated_at'  => now()
            ],
            [
                'dep_name'    => 'Cardiologist',
                'description' => '',
                'status'      => 'Active',
                'user_id'     => '3',
                'created_at'  => now(),
                'updated_at'  => now()
            ],
            [
                'dep_name'    => 'Opthamology',
                'description' => '',
                'status'      => 'Active',
                'user_id'     => '4',
                'created_at'  => now(),
                'updated_at'  => now()
            ],
            [
                'dep_name'    => 'Dentist',
                'description' => '',
                'status'      => 'Active',
                'user_id'     => '5',
                'created_at'  => now(),
                'updated_at'  => now()
            ],
            [
                'dep_name'    => 'Skin Specialist',
                'description' => '',
                'status'      => 'Active',
                'user_id'     => '1',
                'created_at'  => now(),
                'updated_at'  => now()
            ],
            [
                'dep_name'    => 'Pediatric',
                'description' => '',
                'status'      => 'Active',
                'user_id'     => '2',
                'created_at'  => now(),
                'updated_at'  => now()
            ],
            [
                'dep_name'    => 'Orthopedic',
                'description' => '',
                'status'      => 'Active',
                'user_id'     => '3',
                'created_at'  => now(),
                'updated_at'  => now()
            ],
            [
                'dep_name'    => 'Psychiatry',
                'description' => '',
                'status'      => 'Active',
                'user_id'     => '4',
                'created_at'  => now(),
                'updated_at'  => now()
            ],
            [
                'dep_name'    => 'Genral Medicine',
                'description' => '',
                'status'      => 'Active',
                'user_id'     => '5',
                'created_at'  => now(),
                'updated_at'  => now()
            ],
        ];

        DB::table('departments')->insert($data);
    }
}
