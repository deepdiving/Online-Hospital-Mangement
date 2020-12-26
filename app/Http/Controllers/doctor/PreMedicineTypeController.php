<?php

namespace App\Http\Controllers\doctor;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\doctor\PreMedicineType;
use Pharma;
use Sentinel;
use Session;
class PreMedicineTypeController extends Controller
{

    public function __construct(){
        $this->middleware(['authorized','doctor']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $type = PreMedicineType::all();
        return view('doctor_module.medicines.types.index',compact('type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = PreMedicineType::all();
        return view('doctor_module.medicines.types.create',compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( PreMedicineType $type ,Request $request)
    {
        $request->validate([
            'name' => 'required|unique:hms_operation_types|',            
           ]);

           $data = [          
            'name'              => $request->name,           
            'user_id'           => Sentinel::getUser()->id,
            'created_at'        => now(),
        ];
        //dd($data);
        PreMedicineType::create($data);
        Session::flash('success', 'Medicine  Type Succeed!');
        Pharma::activities("Added", "Type", "Added a New Medicine Type");
        return redirect('doctor/medicine/type');

   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $type = PreMedicineType::findorfail($id) ;
       
       // dd($type);
        return view('doctor_module.medicines.types.show',compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = PreMedicineType::findorfail($id) ;
        return view('doctor_module.medicines.types.edit',compact('type'));
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
            'name' => 'required|unique:hms_operation_types|',            
           ]);
           $type = PreMedicineType::findorfail($id) ;
           $type->name = $request->name;
           $type->save();
   
           //dd($data);
           Session::flash('success', 'Medicine Type Update Succeed!');
           Pharma::activities("Added", "Medicine", "Added a New Medicine Type");
           return redirect('doctor/medicine/type');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = PreMedicineType::findorfail($id) ;
        $type->delete();
        Session::flash('success', 'Medicine Type Deleted Succeed!');
        Pharma::activities("Deleted", "Medicine", "Deleted Service Category");
        return redirect('doctor/medicine/type');
    }
    
}
    
