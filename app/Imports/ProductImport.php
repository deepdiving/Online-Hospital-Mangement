<?php

namespace App\Imports;

use App\Models\Pharma\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Pharma;
use Session;
class ProductImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        $product            = new Product;
        $cat_id             = Pharma::findIdBySlug('pharma_categories',$row['category_slug']);
        $unit_id            = Pharma::findIdBySlug('pharma_units',$row['unit_slug']);
        $manufacturer_id    = Pharma::findIdBySlug('pharma_manufacturers',$row['manufacturer_slug']);
        $type_id            = Pharma::findIdBySlug('pharma_product_types',$row['product_type_slug']);

        if($cat_id > 0 && $unit_id > 0 && $manufacturer_id > 0 && $type_id > 0){
            return new Product([
                'title'             => $row['itemname'],//$request->title,
                'slug'              => Pharma::getUniqueSlug($product, $row['itemname']),//$slug,
                'generic_name'      => $row['generic_name'],//$request->generic_name,
                'note'              => $row['note'],//$request->note,
                'box_size'          => $row['box_size'],//$request->box_size,
                'image'             => '',
                'tax'               => 0,
                'purchase_price'    => $row['purchase_price'],//$request->purchase_price,
                'sale_price'        => $row['sale_price'],//$request->sale_price,
                'stock'             => 0,
                'shelf_no'          => $row['shelf_no'],//$request->shelf_no,
                'category_id'       => $cat_id,//$request->category_id,
                'unit_id'           => $unit_id,//$request->unit_id,
                'manufacturer_id'   => $manufacturer_id,//$request->manufacturer_id,
                'product_type_id'   => $type_id,//$request->type_id,
                'user_id'           => 1,//Sentinel::getUser()->id,
            ]);
        }else{
            $product = collect($row);
            Session::push('csv', $product);
        }
    }
}
