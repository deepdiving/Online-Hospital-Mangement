<?php

use Illuminate\Database\Seeder;
use App\Models\hospital\HmsOperationType;

class HmsOperationTypesTableSeeder extends Seeder
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
                'name'       => 'Bypass',
                'slug'       => 'Bypass',
                'status'     => 'Active',
                'user_id'    => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Surgery',
                'slug'       => 'Surgery',
                'status'     => 'Active',
                'user_id'    => '2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Caesarean',
                'slug'       => 'Caesarean',
                'status'     => 'Active',
                'user_id'    => '4',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
    
        DB::table('hms_operation_types')->insert($data);
    }


}

}
