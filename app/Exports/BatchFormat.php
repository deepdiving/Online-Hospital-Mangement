<?php

namespace App\Exports;

use App\Batch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class BatchFormat implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        // $pro = Product::with(['category','type','unit','manufacturer'])->first();
        $data [] = ['product_id','batch_number','batch_stock','expiry_date'];
        $data [] = ['1','BATCH-00001','35','2020-01-01'];
        $data [] = ['1','BATCH-00002','30','2020-02-01'];
        $data [] = ['2','BATCH-00003','65','2021-03-01'];
        $data [] = ['2','BATCH-00004','28','2020-12-31'];
       
        return $data;
    }
    
}
