<?php

namespace App\Exports;

use App\Models\Pharma\ProductType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class ProdctTypeExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $types = ProductType::all();
        $data [] = ['id','type_name','slug','description'];

        foreach($types as $type){
            $data [] = [
                $type->id,
                $type->type_name,
                $type->slug,
                $type->description,
            ];
        }
        return $data;
    }
}
