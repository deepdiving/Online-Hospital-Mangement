<?php

namespace App\Http\Controllers\hrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hrm\HrmAttendance;
use App\Models\hrm\HrmEmployee;
use Sentinel;
use Pharma;
use Session;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $employees  = HrmEmployee::where('status','Active')->get(); 
        $attendence = HrmAttendance::all();
        return view('hrm.attendences.attendence.index',compact('employees','attendence'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =[
            'emp_id'         => $request->emp_id,
            'date'           => $request->date,
            'status'         => $request->status,
            'time'           => $request->time,  
            'user_id'        => Sentinel::getUser()->id,
            'created_at'     => now()
        ];
        //dd($data);
        HrmAttendance::create($data);

        Session::flash('success', 'Attendence Added Succeed!');
        Pharma::activities("Added", "Attendence", "Added a New Attendence");
        return redirect('attendence');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HrmAttendance $attendence)
    {
        return view('hrm.attendences.attendence.show',compact('attendence'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(HrmAttendance $attendence)
    {
        $employees  = HrmEmployee::where('status','Active')->get(); 
        return view('hrm.attendences.attendence.edit',compact('attendence','employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , HrmAttendance $attendence)
    {
        $data =[
            'emp_id'         => $request->emp_id,
            'date'           => $request->date,
            'time'           => $request->time,  
            'status'         => $request->status,       
            'user_id'        => Sentinel::getUser()->id,
            'updated_at'     => now()
        ];
        //dd($data);
        $attendence->update($data);

        Session::flash('success', 'Attendence Updated Succeed!');
        Pharma::activities("Updated", "Attendence", "Update Position");
        return redirect('attendence');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HrmAttendance $attendence)
    {
        $attendence->delete();
        Session::flash('success', 'Attendence Deleted Succeed!');
        Pharma::activities("Deleted", "Attendence", "Deleted Attendence");
        return redirect('attendence');
    }

    public function list(Request $request){
        $search = [
            'month' => $request->month,
            'year'   => $request->year,
        ];
        $employees  = HrmEmployee::where('status','Active')->withCount(['attendance'])->get();
        return view ("hrm.attendences.attendence_list.index",compact('employees','search'));
    }
}
