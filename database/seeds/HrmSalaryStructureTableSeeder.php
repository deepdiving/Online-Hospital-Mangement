<?php

use Illuminate\Database\Seeder;
use App\Models\hrm\HrmSalaryStructure;
class HrmSalaryStructureTableSeeder extends Seeder
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
                'title'           => 'Home Rent',  
                'type'            => 'Add', 
                'amount'          => 40,                                                        
                'status'          => 'Active',
                'created_at'      => now(),
                'updated_at'      => now()
            ],
            [
                'title'           => 'Medical',  
                'type'            => 'Add',
                'amount'          => 10,                                                         
                'status'          => 'Active',
                'created_at'      => now(),
                'updated_at'      => now()
            ],
            [
                'title'           => 'Convenience',  
                'type'            => 'Add',
                'amount'          => 5,                                                         
                'status'          => 'Active',
                'created_at'      => now(),
                'updated_at'      => now()
            ],
            [
                'title'           => 'Provident Fund',  
                'type'            => 'Deduct',
                'amount'          => 10,                                                         
                'status'          => 'Active',
                'created_at'      => now(),
                'updated_at'      => now()
            ],
            [
                'title'           => 'Insurence',  
                'type'            => 'Deduct',
                'amount'          => 5,                                                         
                'status'          => 'Active',
                'created_at'      => now(),
                'updated_at'      => now()
            ],

            
           
           
    ];
    
    DB::table('hrm_salary_structures')->insert($data);
    }

}

