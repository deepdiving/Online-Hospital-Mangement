<?php

use Illuminate\Database\Seeder;
use App\Models\hospital\HmsBed;

class HmsBedsSeeder extends Seeder
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
              'price'      => '200',
              'slug'       => 'A101',
              'bed_no'     => 'A101',
              'status'     => 'Active',
              'bed_type_id'=> '1',
              'user_id'    => '5',
              'created_at' => now(),
              'updated_at' => now()
            ],
            [
              'price'      => '500',
              'slug'       => 'A102',
              'bed_no'     => 'A102',
              'status'     => 'Active',
              'bed_type_id'=> '2',
              'user_id'    => '5',
              'created_at' => now(),
              'updated_at' => now()
            ],
            [
              'price'      => '700',
              'slug'       => 'A103',
              'bed_no'     => 'A103',
              'status'     => 'Active',
              'bed_type_id'=> '3',
              'user_id'    => '5',
              'created_at' => now(),
              'updated_at' => now()
            ],
            [
              'price'      => '1000',
              'slug'       => 'A104',
              'bed_no'     => 'A104',
              'status'     => 'Active',
              'bed_type_id'=> '1',
              'user_id'    => '5',
              'created_at' => now(),
              'updated_at' => now()
            ],
            [
              'price'      => '1200',
              'slug'       => 'A105',
              'bed_no'     => 'A105',
              'status'     => 'Active',
              'bed_type_id'=> '2',
              'user_id'    => '5',
              'created_at' => now(),
              'updated_at' => now()
            ]
        ];

         DB::table('hms_beds')->insert($data);
    }
}
