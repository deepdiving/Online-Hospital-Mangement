<?php

use Illuminate\Database\Seeder;

class HrmEmployeesTableSeeder extends Seeder
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
                'name'              => 'Rashed Khan',               
                'email'             => 'rashed@gmail.com',
                'phone_no'          => '01719100067',
                'basic_salary'      => '35000',
                'gross_salary'      => '50050',
                'date_of_birth'     => '1998-05-01', 
                'joining_date'      => '2012-02-15', 
                'address'           => 'Nirala,Khulna',  
                'gender'            => 'Male', 
                'marital_status'    => 'Married', 
                'picture'           => '', 
                'emergency_contact' => '', 
                'emergency_address' => '', 
                'status'            => 'Active', 
                'department_id'     => '1', 
                'position_id'       => '1',          
                'user_id'           => '1',
                'created_at'        => now(),
                'updated_at'       => now()
            ],
            [
                'name'              => 'Anik Mollick',              
                'email'             => 'anik@andit.com',
                'phone_no'          => '01719100060',
                'basic_salary'      => '25000',
                'gross_salary'      => '26500',
                'date_of_birth'     => '2000-01-01', 
                'joining_date'      => '2017-05-06', 
                'address'           => 'Boira,Khulna',  
                'gender'            => 'Male', 
                'marital_status'    => 'Single', 
                'picture'           => '', 
                'emergency_contact' => '', 
                'emergency_address' => '', 
                'status'            => 'Active', 
                'department_id'     => '2', 
                'position_id'       => '2',          
                'user_id'           => '1',
                'created_at'        => now(),
                'updated_at'       => now()
            ],
            [
                'name'              => 'Arifa Akter',               
                'email'             => 'arifa@andit.com',
                'phone_no'          => '01919100052',
                'basic_salary'      => '30000',
                'gross_salary'      => '31800',
                'date_of_birth'     => '1995-05-01', 
                'joining_date'      => '2016-05-10', 
                'address'           => 'Shonadanga,Khulna',  
                'gender'            => 'Female', 
                'marital_status'    => 'Single', 
                'picture'           => '', 
                'emergency_contact' => '', 
                'emergency_address' => '', 
                'status'            => 'Active', 
                'department_id'     => '3', 
                'position_id'       => '3',          
                'user_id'           => '1',
                'created_at'        => now(),
                'updated_at'        => now()
            ],
            [
                'name'              => 'Shova Dhor',              
                'email'             => 'shova@andit.com',
                'phone_no'          => '01919100045',
                'basic_salary'      => '15000',
                'gross_salary'      => '16500',
                'date_of_birth'     => '1999-06-25', 
                'joining_date'      => '2018-01-20', 
                'address'           => 'Shatkhira,Khulna',  
                'gender'            => 'Female', 
                'marital_status'    => 'Married', 
                'picture'           => '', 
                'emergency_contact' => '', 
                'emergency_address' => '', 
                'status'            => 'Active', 
                'department_id'     => '4', 
                'position_id'       => '4',          
                'user_id'           => '1',
                'created_at'        => now(),
                'updated_at'        => now()
            ],
        ];
        DB::table('hrm_employees')->insert($data);    
    }
}
