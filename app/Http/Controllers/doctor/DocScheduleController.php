<?php

namespace App\Http\Controllers\doctor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Pharma;
use Sentinel;
use Session;
use App\Doctor;
use App\Models\doctor\DocSchedule;

class DocScheduleController extends Controller{


    public function __construct(){

        $this->middleware(['authorized','diagnostic']);
        // $this->middleware(['authorized','doctor','diagnostic']);
    }

    public function index(){
        $schedule_name = Pharma::GenarateInvoiceNumber('doc_schedules','SCH');
        $schedules = DocSchedule::orderBy('id','DESC')->get();
        $doctors = Doctor::all();
        return view('schedule.index',compact('schedules','doctors','schedule_name'));
    }

    public function create(){
        return view('schedule.create');
    }

    public function store(Request $request,DocSchedule $schedule){
        // dd($request->all());
        $data = [
            'name'          => $request->name,
            'doctor_fees'   => $request->consultant_fees,
            'week_day'      => $request->week_day,
            'start_time'    => $request->start_time,
            'end_time'      => $request->end_time,
            'visit_qty'     => $request->visit_qty,
            'doctor_id'     => $request->doctor_id,
            'user_id'       => Sentinel::getUser()->id,
            'created_at'    => now(),
        ];
        $schedule->create($data);

        Session::flash('success','Schedule Added Succeed!');
        Pharma::activities("Added", "Schedule", $request->name." schedule Added.");
        return redirect('schedule');
    }

    public function edit(DocSchedule $schedule){
        $doctors = Doctor::all();
        return view('schedule.edit',compact('schedule','doctors'));
    }

    public function update(Request $request,DocSchedule $schedule){
        $data = [
            'name'          => $request->name,
            'doctor_fees'   => $request->consultant_fees,
            'week_day'      => $request->week_day,
            'start_time'    => $request->start_time,
            'end_time'      => $request->end_time,
            'visit_qty'     => $request->visit_qty,
            'doctor_id'     => $request->doctor_id,
            'updated_at'    => now(),
        ];
        $schedule->update($data);

        Session::flash('success','Schedule Update Succeed!');
        Pharma::activities("Updated", "Schedule", $request->name." schedule Updated.");
        return redirect('schedule');
    }

    public function destroy(DocSchedule $schedule){
        $schedule->delete();

        Session::flash('success','Schedule Deleted Succeed!');
        Pharma::activities("Deleted", "Schedule", "Deleted Schedule");
        return redirect('schedule');
    }

    public function chart(){

        $doctors = Doctor::all();
        return view('schedule.chart',compact('doctors'));
    }
}
