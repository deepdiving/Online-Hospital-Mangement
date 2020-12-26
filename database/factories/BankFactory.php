<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Model;
use App\BankAccount;
use Faker\Generator as Faker;

$factory->define(BankFactory::class, function (Faker $faker) {
    return [
         'bank_name'=>$faker->bank,
         'branch_name'=>$faker->state,
         'account_number'=>$faker->bankAccountNumber,
         'account_name'=>$faker->name,
         'balance'=>$faker->$faker->numberBetween(8,2),
         'created_at'=>$faker->DateTime('2008-04-25 08:37:17', 'UTC'),
    ];
});
