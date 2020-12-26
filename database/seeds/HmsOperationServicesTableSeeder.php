<?php

use Illuminate\Database\Seeder;
use App\Models\hospital\HmsOperationService;

class HmsOperationServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        { $data = [
            [
                'name'       => 'Single',
                'slug'       => 'Single',
                'status'     => 'Active',
                'user_id'    => '5',
                'operation_type_id' => '1',
                'price'      => '1000',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Micro Surgery',
                'slug'       => 'Micro Surgery',
                'status'     => 'Active',
                'user_id'    => '2',
                'operation_type_id' => '2',
                'price'      => '2000',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Hysterectomy',
                'slug'       => 'Hysterectomy',
                'status'     => 'Active',
                'user_id'    => '4',
                'operation_type_id' => '3',
                'price'      => '1400',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
    
        DB::table('hms_operation_services')->insert($data);
    }

  }

}

