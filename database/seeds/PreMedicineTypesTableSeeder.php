<?php

use Illuminate\Database\Seeder;

class PreMedicineTypesTableSeeder extends Seeder
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
                'name'       => 'Liquid',                
                'status'     => 'Active',              
                'user_id'    => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name'       => 'Tablet',                
                'status'     => 'Active',
                'user_id'    => '2',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name'       => 'Capsules',                
                'status'     => 'Active',
                'user_id'    => '1',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name'       => 'Suppositories',                
                'status'     => 'Active',
                'user_id'    => '4',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name'       => 'Drops',                
                'status'     => 'Active',
                'user_id'    => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name'       => 'Inhalers',                
                'status'     => 'Active',
                'user_id'    => '3',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name'       => 'Injections',                
                'status'     => 'Active',
                'user_id'    => '1',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
    
        DB::table('pre_medicine_types')->insert($data);
   

    }
}
