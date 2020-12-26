<?php

use Illuminate\Database\Seeder;
use App\Models\hrm\HrmAttendance;
class HrmAttendanceTableSeeder extends Seeder
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
                'emp_id'          => '1',  
                'user_id'         => '1', 
                'date'            => '2020-03-10',              
                'time'            => '08:00:00',                              
                'status'          => 'In',
                'created_at'      => now(),
                'updated_at'      => now()
            ],

            [
                'emp_id'          => '1',  
                'user_id'         => '1', 
                'date'            => '2020-03-10',              
                'time'            => '18:00:00',                              
                'status'          => 'Out',
                'created_at'      => now(),
                'updated_at'      => now()
            ],

            [
                'emp_id'          => '2', 
                'user_id'         => '1',  
                'date'            => '2020-03-10',              
                'time'            => '08:00:00', 
                'status'          => 'In',
                'created_at'      => now(),
                'updated_at'      => now()
            ],

            [
                'emp_id'          => '2', 
                'user_id'         => '1',  
                'date'            => '2020-03-10',              
                'time'            => '18:00:00', 
                'status'          => 'Out',
                'created_at'      => now(),
                'updated_at'      => now()
            ],

            [
                'emp_id'          => '3',
                'user_id'         => '1',   
                'date'            => '2020-03-10',              
                'time'            => '10:00:00', 
                'status'          => 'In',
                'created_at'      => now(),
                'updated_at'      => now()
            ],

            [
                'emp_id'          => '3',
                'user_id'         => '1',   
                'date'            => '2020-03-10',              
                'time'            => '20:00:00', 
                'status'          => 'Out',
                'created_at'      => now(),
                'updated_at'      => now()
            ],


            [
                'emp_id'          => '4',  
                'user_id'         => '1', 
                'date'            => '2020-03-10',              
                'time'            => '18:00:00', 
                'status'          => 'In',
                'created_at'      => now(),
                'updated_at'      => now()
            ],

            
            [
                'emp_id'          => '4',  
                'user_id'         => '1', 
                'date'            => '2020-03-10',              
                'time'            => '22:00:00', 
                'status'          => 'Out',
                'created_at'      => now(),
                'updated_at'      => now()
            ],


          
        ];
    
        DB::table('hrm_attendances')->insert($data);
   

    }
}


