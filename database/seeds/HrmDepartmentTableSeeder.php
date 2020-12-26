<?php

use Illuminate\Database\Seeder;
use App\Models\hrm\HrmDepartment;
class HrmDepartmentTableSeeder extends Seeder
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
                'name'        => 'Doctor',  
                'description' => 'Liqfvgjnxfuid',              
                'status'      => 'Active',              
                'user_id'     => '1',
                'created_at'  => now(),
                'updated_at'  => now()
            ],

            [
                'name'        => 'Nurse',  
                'description' => 'Likgbcjkhquid',              
                'status'      => 'Active',              
                'user_id'     => '1',
                'created_at'  => now(),
                'updated_at'  => now()
            ],

            [
                'name'        => 'Word Boy',  
                'description' => 'Liquxghkhgfhid',              
                'status'      => 'Active',              
                'user_id'     => '1',
                'created_at'  => now(),
                'updated_at'  => now()
            ],
            [
                'name'        => 'Servant',  
                'description' => 'xfgjnfjf',              
                'status'      => 'Active',              
                'user_id'     => '1',
                'created_at'  => now(),
                'updated_at'  => now()
            ],
        ];
    
        DB::table('hrm_departments')->insert($data);
   

    }
}
