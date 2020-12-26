<?php

use Illuminate\Database\Seeder;
use App\Models\hospital\HmsBedType;

class HmsBedTypesSeeder extends Seeder
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
                'name'       => 'Ward',
                'slug'       => 'Ward',
                'status'     => 'Active',
                'user_id'    => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Cabin',
                'slug'       => 'Cabin',
                'status'     => 'Active',
                'user_id'    => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'General',
                'slug'       => 'General',
                'status'     => 'Active',
                'user_id'    => '5',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('hms_bed_types')->insert($data);
    }
}
