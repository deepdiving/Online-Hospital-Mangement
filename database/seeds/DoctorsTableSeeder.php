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
                'full_name'     => 'Dr Hasan',
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
                'user_id'       => 5,
                'created_at'    => now(),
                'updated_at'    => now()
            ]
        ];

        DB::table('doctors')->insert($data);
    }
}
