<?php

namespace App\Exports;

use App\Manufacturer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Pharma;
class ManufacturerExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $manufacturers = Manufacturer::all();
        $data [] = ['id','manufacturer_name', 'slug', 'email', 'phone', 'address', 'manufacturer_balance'];

        foreach($manufacturers as $row){
            $balance = Pharma::getManufacturerBalance($row->id);
            $data [] = [
                $row->id,
                $row->manufacturer_name,
                $row->slug,
                $row->email,
                $row->phone,
                $row->address,
                $balance,
            ];
        }
        return $data;
    }
}
