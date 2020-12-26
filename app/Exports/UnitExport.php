<?php

namespace App\Exports;

use App\Unit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class UnitExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $units = Unit::all();
        $data [] = ['id','unit_name','slug','description'];

        foreach($units as $unit){
            $data [] = [
                $unit->id,
                $unit->unit_name,
                $unit->slug,
                $unit->description,
            ];
        }
        return $data;
    }
}
