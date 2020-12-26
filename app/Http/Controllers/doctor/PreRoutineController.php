<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\doctor\PreRoutine;
use App\Models\doctor\PreMedicineType;
use Pharma;
use Sentinel;
use Session;
class PreRoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $type = PreMedicineType::all();
     $routine = PreRoutine::with('premedicinetype')->get();
      return view ('doctor_module.medicines.routines.index',compact('routine','type'));
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
    public function store(Request $request,PreRoutine $routine)
    {
        $request->validate([
            'name' => 'required',
           ]);

           $data = [
            'name'              => $request->name,
            'pre_medicine_type_id' => $request->pre_medicine_type_id ,
            'user_id'           => Sentinel::getUser()->id,
            'user_id'           => Sentinel::getUser()->id,
            'created_at'        => now(),
        ];
        //dd($data);
        PreRoutine::create($data);
        Session::flash('success', 'Routine  Type Succeed!');
        Pharma::activities("Added", "Routine", "Added a New Medicine Type");
        return redirect('doctor/medicine/routine');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $routine = PreRoutine::findorfail($id) ;
        return view ('doctor_module.medicines.routines.show',compact('routine'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = PreMedicineType::all();
        $routine = PreRoutine::findorfail($id) ;
        return view ('doctor_module.medicines.routines.edit',compact('routine','type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
           ]);

           $data = [
             'name'              => $request->name,
             'pre_medicine_type_id' => $request->pre_medicine_type_id ,
             'user_id'           => Sentinel::getUser()->id,
             'created_at'        => now(),
           ];
           $routine = PreRoutine::findorfail($id) ;
           $routine->update($data);
           Session::flash('success', 'Routine Update Succeed!');
           Pharma::activities("Update", "Routine", "Updated Medicine");
           return redirect('doctor/medicine/routine');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $routine = PreRoutine::findorfail($id) ;
        $routine->delete();

        Session::flash('success','Routine Deleted Succeed!');
        Pharma::activities("Deleted", "Routine", "Deleted Bed");
        return redirect('doctor/medicine/routine');
    }
}
