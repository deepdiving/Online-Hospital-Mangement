<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\doctor\PreMedicineType;
use App\Models\doctor\PreMedicine;
use Pharma;
use Sentinel;
use Session;
class PreMedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // die('asdf');
        $type = PreMedicineType::all();
        $medicine = PreMedicine::with('premedicinetype')->get();       
        return view('doctor_module.medicines.medicine.index',compact('medicine','type'));
   
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
    public function store( PreMedicine $medicines,Request $request )
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
   
           PreMedicine::create($data);
   
           Session::flash('success', 'Medicine   Added Succeed!');
           Pharma::activities("Added", "Medicine", "Added a New Type");
           return redirect('/medicines');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PreMedicine $medicines,$id)

    { 
         $medicine = PreMedicine::findorfail($id) ;
        return view('doctor_module.medicines.medicine.show',compact('medicine'));
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
        $medicine = PreMedicine::findorfail($id) ;
        return view('doctor_module.medicines.medicine.edit',compact('medicine','type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
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
          $medicine = PreMedicine::findorfail($id) ;
          $medicine->update($data);
          Session::flash('success', 'Medicine Update Succeed!');
          Pharma::activities("Update", "Medicine", "Updated Medicine");
          return redirect('medicines/');
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $medicine = PreMedicine::findorfail($id) ;
        $medicine->delete();

        Session::flash('success','Medicine Deleted Succeed!');
        Pharma::activities("Deleted", "Medicine", "Deleted Bed");
        return redirect('medicines/');
    }
}
