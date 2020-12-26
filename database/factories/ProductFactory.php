<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Pharma\Product;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    static $number = 1;
    // $name = $faker->name;
    $purchase_price = $faker->numberBetween($min = 10, $max = 999);
    $random = $faker->numberBetween($min = 5, $max = 99);
    $sale_price = $purchase_price + $random;
    $names = ['Tab. Almex (400 mg)','Tab-Calbo','Carva','B 50 Forte','Cap. Moxacil (250 mg)','Drop-Lebac','Drop Moxacil Peadiativ','Tab. Cardipro 50 mg','Cap. Cef-3 (400 mg)','Tab. Cotrim (480 mg)','Susp. Cotrim (60 mg)','Calbo-D','Cap.Doxacil (100 mg)','Nexum (20 mg)','Nexum (40 mg)','Filwel Gold','Tab Zimax (500 mg)','Sup Zimax (15 ml)','Sup Zimax (30 ml)','A Fan Cream','Tab. Amodis (400 mg)','Multivit Plus','Cap.Seclo 20 mg','Tab Anril SR','Phylopen Fotre','Flurigin','Tab. Ace (500mg)','Syp. Ace (60 ml)','Syp. Ace Padiatic','Zifolet','Loratin 10 mg','Neotack','Ceevit','Zif-CI','Zif- Forte','Tab Cerevas 5 mg','Cap-Maxrin 0.4 mg','Tab-Rasuva 5 mg','Syp-Becozine I','Syp- Alarid','Tab-Triptin-10 mg','Tab-Marison 6mg','Tab-Zimax 250mg','Syp-Levoster 50mg','Tab-Famotack 50mg','Tab-Angilock plus','Tab-Rasuva 10 mg','Syp-Fenadin','Maxpro 20 mg','Becosule Gold','Calcin-D 500 mg','Tab-Gestronal','Levoking 500 mg','Zithtim ','Cap. Lucan-R (150mg)','Orcef 400mg','Normens','Tab-Ceclofen','Tab-Domerin','Tab-Zithrin 500 mg','Tab Algin','Tab-Calcin','Tab-Ferix','Tab-Totifen','Cap-Frerix'];
    $data = [
        'title'             => $names[$number],
        'slug'              => Str::slug($names[$number], '-'),
        'generic_name'      => $names[$number++],
        'note'              => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'box_size'          => $faker->numberBetween($min = 1, $max = 999),
        'image'             => '',//$faker->imageUrl($width = 640, $height = 480),
        'tax'               => $faker->numberBetween($min = 0, $max = 15),
        'purchase_price'    => $purchase_price,
        'sale_price'        => $sale_price,
        'stock'             => 0, // 8567,
        'shelf_no'          => 'self-'.$faker->numberBetween($min = 1, $max = 99),
        'category_id'       => $faker->numberBetween($min = 1, $max = 2),
        'user_id'           => 1,
        'manufacturer_id'   => $faker->numberBetween($min = 1, $max = 4),
        'unit_id'           => $faker->numberBetween($min = 1, $max = 4),
        'product_type_id'   => $faker->numberBetween($min = 1, $max = 2),
        'status'            => 'Active',
    ];
    // dd($data);
    return $data;
});
