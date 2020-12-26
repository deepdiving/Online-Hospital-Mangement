<?php

use Illuminate\Database\Seeder;

class PatientsTableDataSeeder extends Seeder
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
                'patient_name' =>'Walking Customer',
                'slug' => '0001',
                'email' => 'walking@customer.com',
                'phone' => '000000',
                'address' => '000000',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'patient_name' =>'Hasan',
                'slug' => '0002',
                'email' => 'hasan@gmail.com',
                'phone' => '54556552',
                'address' => '331/C,kalabagan,dhaka',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'patient_name' =>'Mehedi',
                'slug' => '0003',
                'email' => 'mehedi@gmail.com',
                'phone' => '5456554566',
                'address' => '331/C,dhanmondi,dhaka',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'patient_name' =>'Abir',
                'slug' => '0004',
                'email' => 'abir@gmail.com',
                'phone' => '5456554567',
                'address' => '331/C,rampura,dhaka',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'patient_name' =>'Sarthok',
                'slug' => '0005',
                'email' => 'sarthok@gmail.com',
                'phone' => '5456554568',
                'address' => '331/C,Mirjapur,Khulna',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'patient_name' =>'Ankur',
                'slug' => '0006',
                'email' => 'Ankur@gmail.com',
                'phone' => '5456554569',
                'address' => '331/C,dhanmondi,dhaka',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'patient_name' =>'Kajol',
                'slug' => '0007',
                'email' => 'kajol@gmail.com',
                'phone' => '5456554560',
                'address' => '331/C,Tutpara,Khulna',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'patient_name' =>'Akhi',
                'slug' => '0003',
                'email' => 'akhi@gmail.com',
                'phone' => '5456554562',
                'address' => '331/C,Dakbangla,Khulna',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],


        ];

        DB::table('patients')->insert($data);
    }
}

