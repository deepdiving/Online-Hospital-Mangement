<?php

use Illuminate\Database\Seeder;
use App\Models\hrm\HrmEmpSalaryStructure;
class HrmEmpSalaryStructureTableSeeder extends Seeder
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
                'emp_id'              => '1',  
                'salary_structure_id' => '1',              
                'amount'              => '40',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'emp_id'              => '1',  
                'salary_structure_id' => '2',              
                'amount'              => '10',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'emp_id'              => '1',  
                'salary_structure_id' => '3',              
                'amount'              => '3',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'emp_id'              => '1',  
                'salary_structure_id' => '4',              
                'amount'              => '5',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'emp_id'              => '1',  
                'salary_structure_id' => '5',              
                'amount'              => '5',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],

            
            [
                'emp_id'              => '2',  
                'salary_structure_id' => '1',              
                'amount'              => '6',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'emp_id'              => '2',  
                'salary_structure_id' => '2',              
                'amount'              => '6',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'emp_id'              => '2',  
                'salary_structure_id' => '3',              
                'amount'              => '6',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'emp_id'              => '2',  
                'salary_structure_id' => '4',              
                'amount'              => '6',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'emp_id'              => '2',  
                'salary_structure_id' => '5',              
                'amount'              => '6',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            
            [
                'emp_id'              => '3',  
                'salary_structure_id' => '1',              
                'amount'              => '5',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'emp_id'              => '3',  
                'salary_structure_id' => '2',              
                'amount'              => '6',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'emp_id'              => '3',  
                'salary_structure_id' => '3',              
                'amount'              => '5',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'emp_id'              => '3',  
                'salary_structure_id' => '4',              
                'amount'              => '5',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],

            [
                'emp_id'              => '3',  
                'salary_structure_id' => '5',              
                'amount'              => '5',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],

            [
                'emp_id'              => '4',  
                'salary_structure_id' => '1',              
                'amount'              => '10',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'emp_id'              => '4',  
                'salary_structure_id' => '2',              
                'amount'              => '10',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'emp_id'              => '4',  
                'salary_structure_id' => '3',              
                'amount'              => '10',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'emp_id'              => '4',  
                'salary_structure_id' => '4',              
                'amount'              => '10',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'emp_id'              => '4',  
                'salary_structure_id' => '5',              
                'amount'              => '10',                              
                'status'              => 'Active',
                'created_at'          => now(),
                'updated_at'          => now()
            ],
           
    ];
    
    DB::table('hrm_emp_salary_structures')->insert($data);
    }
}
