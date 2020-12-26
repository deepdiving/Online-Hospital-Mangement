<?php

namespace App\Exports;

use App\Models\Pharma\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class ProductExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $products = Product::with(['category','type','unit','manufacturer'])->get();
        $data [] = ['id','title','slug','generic_name','note','box_size','image','tax','purchase_price','sale_price','stock','shelf_no','category','unit','manufacturer','product_type','status'];

        foreach($products as $pro){
            $data [] = [
                $pro->id,
                $pro->title,
                $pro->slug,
                $pro->generic_name,
                $pro->note,
                $pro->box_size,
                $pro->image,
                $pro->tax,
                $pro->purchase_price,
                $pro->sale_price,
                $pro->stock,
                $pro->shelf_no,
                $pro->category->slug,
                $pro->unit->slug,
                $pro->manufacturer->slug,
                $pro->type->slug,
                $pro->status,
            ];
        }
        // dd($data);
        return $data;
    }

    //https://www.itsolutionstuff.com/post/import-and-export-csv-file-in-laravel-58example.html
    //https://docs.laravel-excel.com/3.1/exports/multiple-sheets.html
    
}
