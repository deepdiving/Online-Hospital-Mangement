<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\diagnostic\DiagonTestList;
use App\Models\diagnostic\DiagonTestCategory;
use App\Models\doctor\PreMedicine;
use App\Models\doctor\PreMedicineType;
use App\Models\doctor\DocAppointment;
use App\Models\doctor\PreMedicineItem;
use App\Models\doctor\PreTestItem;
use App\Doctor;
use App\Patient;
use App\Models\doctor\Prescription;
use Pharma;
use Sentinel;
use Session;
class DraftContinueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $doctor = Pharma::getDoctor();
        $testLists      = DiagonTestList::all();
        $medecineLists  = PreMedicine::all();
        $types  = PreMedicineType::all();
        // $appointPatient = DocAppointment::with('patient')->where('doctor_id',$doctor->id)->where('date',date('Y-m-d'))->where('status','Paid')->get();
        $testCategories = DiagonTestCategory::all();
        return view('doctor_module.prescription.draftlist.show',compact('testLists','medecineLists','types','testCategories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
