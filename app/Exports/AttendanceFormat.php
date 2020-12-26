<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class AttendanceFormat implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
       
        $data [] = ['date','employee_id','time','status'];
        $data [] = ['2020-03-01','1','08:00:00','In'];
        $data [] = ['2020-03-01','1','21:00:00','Out'];

        return $data;
    }
    
}
