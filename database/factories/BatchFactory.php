<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Pharma\Batch;
use Faker\Generator as Faker;

$factory->define(Batch::class, function (Faker $faker) {
    static $number = 1;
    $product_id = $faker->numberBetween($min = 1, $max = 60);
    $stock = $faker->numberBetween($min = 1, $max = 100);
    $data =  [
        'product_id' => $product_id,
        'batch_number' => sprintf('batch-%05d',$number++),
        'in_stock' => $stock,
        'expiry_date' => $faker->numberBetween($min = 2019, $max = 2025).'-'.$faker->numberBetween($min = 1, $max = 12).'-'.$faker->numberBetween($min = 1, $max = 28)
    ];
    DB::table('pharma_products')->where('id',$product_id)->increment('stock',$stock);
    return $data;
});
