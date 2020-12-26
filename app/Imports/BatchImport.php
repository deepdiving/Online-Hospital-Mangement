<?php

namespace App\Imports;

use App\Models\Pharma\Batch;
use App\Models\Pharma\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Pharma;
use Session;
class BatchImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        $batch              = new Batch;

        if(Product::where('id',$row['product_id'])->count() > 0){
            return new Batch([
                'product_id'        => $row['product_id'],//$request->title,
                'batch_number'      => Pharma::getUniqueSlug($batch, $row['batch_number'],'batch_number'),//$slug,
                'in_stock'          => $row['batch_stock'],//$request->generic_name,
                'expiry_date'       => date('Y-m-d',strtotime($row['expiry_date'])),//$request->box_size,
            ]);
        }else{
            $batch = collect($row);
            Session::push('batch', $batch);
        }
    }
}
