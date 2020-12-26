<?php

use Illuminate\Database\Seeder;
// use Sentinel;
use App\BankAccount;

class BankTableSeeder extends Seeder
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
                'bank_name'=>'Pubali Bank',
                'branch_name'=>'Fram Gate, Dhaka',
                'account_number'=>'5656586565',
                'account_name'=>'Shariful Islam',
                'balance'=>20000,
                'created_at'       => now(),
            ],

        ];
        DB::table('bank_accounts')->insert($data);
        // factory(App\BankFactory::class,20)->create();
        
    }
}
