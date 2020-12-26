<?php

use Illuminate\Database\Seeder;
use App\Models\hrm\HrmPosition;

class HrmPositionTableSeeder extends Seeder
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
                'name'        => 'Officer',  
                'description' => 'Liqfvgjnxfuid',              
                'status'      => 'Active',              
                'user_id'     => '1',
                'created_at'  => now(),
                'updated_at'  => now()
            ],

            [
                'name'        => 'Manager',  
                'description' => 'Likgbcjkhquid',              
                'status'      => 'Active',              
                'user_id'     => '1',
                'created_at'  => now(),
                'updated_at'  => now()
            ],

            [
                'name'        => 'Managing Director',  
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
    
        DB::table('hrm_positions')->insert($data);
   

    }
}
