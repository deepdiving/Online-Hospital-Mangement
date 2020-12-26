<?php

use Illuminate\Database\Seeder;
use App\Models\Pharma\Unit;

class UnitTableDataSeeder extends Seeder
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
                'unit_name' =>'Pcs',
                'slug' => 'pcs',
                'description' => 'Peices',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'unit_name' =>'Box',
                'slug' => 'box',
                'description' => 'Box',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'unit_name' =>'Pot',
                'slug' => 'pot',
                'description' => 'Pot',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'unit_name' =>'Bottle',
                'slug' => 'bottle',
                'description' => 'Bottle',
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ]
        ];

        DB::table('pharma_units')->insert($data);
    }
}
