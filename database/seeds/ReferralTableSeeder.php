<?php

use Illuminate\Database\Seeder;

use App\Refferral;

class ReferralTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =[
            [
               'name'        => 'Self',
               'designation' => 'self',
               'contact'     => '0000000',
               'email'       => 'self@gmail.com',
            ],
           [
              'name'       => 'Dr.Md.Mosrafuzzaman',
              'designation'=> 'MBBS,MCPS,FCGP,MCGPMPH,CCD',
              'contact'    => '01700791900',
              'email'      => '',
           ],
           [
              'name'        => 'Dr.Rokeya Sultana',
              'designation' => 'MBBS,EOC,DMU',
              'contact'     => '01700791901',
              'email'       => '',
           ],
        ];

        DB::table('referrals')->insert($data);
    }
}
