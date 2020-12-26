<?php

namespace App\Exports;

use App\Models\Pharma\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class ProductFormat implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        // $pro = Product::with(['category','type','unit','manufacturer'])->first();
        $data [] = ['itemName','generic_name','note','box_size','purchase_price','sale_price','shelf_no','category_slug','unit_slug','manufacturer_slug','product_type_slug'];
       
        return $data;
    }
    
}
