<?php

use Illuminate\Database\Seeder;

class ManufacturerTableDataSeeder extends Seeder
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
                'manufacturer_name' =>'Beximcom',
                'slug' => 'beximcom',
                'phone' => '2345365457',
                'address' => '270/c,Mirpur,Dhaka',
                'manufacturer_balance' => 0,
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'manufacturer_name' =>'Ibsina',
                'slug' => 'ibsina',
                'phone' => '45665756',
                'address' => '331/C,malibag,dhaka',
                'manufacturer_balance' => 10000,
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'manufacturer_name' =>'ACME',
                'slug' => 'acme',
                'phone' => '45665756',
                'address' => '331/C,malibag,dhaka',
                'manufacturer_balance' => 10000,
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'manufacturer_name' =>'Bristol Pharma ltd',
                'slug' => 'bristol-pharma-ltd',
                'phone' => '456655756',
                'address' => '330/c,Rampura,dhaka',
                'manufacturer_balance' => 0,
                'status' => 'Active',
                'user_id' => '1',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
        ];

        DB::table('pharma_manufacturers')->insert($data);
    }
}
