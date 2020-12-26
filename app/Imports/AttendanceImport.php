<?php

namespace App\Imports;

use App\Models\hrm\HrmAttendance;
use App\models\hrm\HrmEmployee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Pharma;
use Session;
use Sentinel;
class AttendanceImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        $attendance       = new HrmAttendance;

        if(HrmEmployee::where('id',$row['employee_id'])->count() > 0){
            $data = [
                'date'              => $row['date'],//date('Y-m-d',strtotime($row['date'])),
                'emp_id'            => $row['employee_id'],
                'time'              => date('H:i:s',strtotime($row['time'])),
                'status'            => $row['status'],
                'user_id'           => Sentinel::getUser()->id,
            ];
            // dd($data);
            return new HrmAttendance($data);
        }else{
            $attendance = collect($row);
            Session::push('attendance', $attendance);
        }
    }
}
