<?php

namespace App\Exports;

use App\Batch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class BatchExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $batches = Batch::with('product')->get();
        $data [] = ['id','product_name','batch_number','stock','expiry_date'];

        foreach($batches as $row){
            $data [] = [
                $row->id,
                $row->product->title,
                $row->batch_number,
                $row->in_stock,
                $row->expiry_date,
            ];
        }
        return $data;
    }
}
