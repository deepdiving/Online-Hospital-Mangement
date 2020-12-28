<?php

use Illuminate\Database\Seeder;
use App\Doctor;

class DoctorsTableSeeder extends Seeder
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
                'full_name'     => 'Gopal Singh Dhanik',
                'department_id' => '1',
                'email'         => 'abc@gmail.com',
                'own_user_id'   => '4',
                'picture'       => '',
                'gender'        => 'Male',
                'blood_group'   => 'A+',
                'designation'   => 'MBBS',
                'phone_no'      => '041351315',
                'mobile_no'     => '',
                'biography'     => '',
                'status'        => 'Active',
                'user_id'       => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'full_name'     => 'Vivek Saxena',
                'department_id' => '2',
                'email'         => 'efg@gmail.com',
                'own_user_id'   => '7',
                'picture'       => '',
                'gender'        => 'Male',
                'blood_group'   => 'A+',
                'designation'   => 'MBBS',
                'phone_no'      => '35135135',
                'mobile_no'     => '',
                'biography'     => '',
                'status'        => 'Active',
                'user_id'       => '3',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'full_name'     => 'Dr. Alok Bajpai',
                'department_id' => '3',
                'email'         => 'hij@gmail.com',
                'own_user_id'   => '8',
                'picture'       => '',
                'gender'        => 'Male',
                'blood_group'   => 'A+',
                'designation'   => 'FRCS',
                'phone_no'      => '1351451351',
                'mobile_no'     => '',
                'biography'     => '',
                'status'        => 'Active',
                'user_id'       => '5',
                'created_at'    => now(),
                'updated_at'    => now()
            ], 
        ];

        DB::table('doctors')->insert($data);
    }
}
