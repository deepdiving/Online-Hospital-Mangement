<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Patient;
use App\Transation;
use Illuminate\Http\Request; 
use App\Models\diagnostic\Bill;
use App\Models\diagnostic\DiagonReferral;
use App\Models\hospital\HmsAdmission;
use App\Models\hospital\HmsEmergency;
use App\Models\Pharma\Sale;
use App\Models\hospital\HmsOperation;
use App\Models\hospital\BedChargeCollection;
use Pharma;
use Sentinel;
use Session;

class PatientController extends Controller
{

    public function __construct()
    {
        $this->middleware('authorized');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Patient $patient)
    {
        $patients = Patient::where('status','Active')->get();//Pharma::ownResults($patient);
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request, Patient $patient)
    {
        // dd($request->all());
        $this->validateForm($request);
        $patient_number = Pharma::GenaratePatientSlug();
        $data = [
                'patient_name'  => $request->patient_name,
                'slug'          => $patient_number,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'age'           => $request->age,
                'address'       => $request->address,
                'picture'       => Pharma::fileUpload($request,'picture','','/uploads/patients', $patient_number),
                'gender'        => $request->gender,
                'description'   => $request->description,
                'marital_status'=> $request->marital_status,
                'blood_group'   => $request->blood_group,
                'guardian'      => $request->guardian,
                'relationship'  => $request->relationship,
                'guardian_phone'=> $request->guardian_phone,
                'occupation'    => $request->occupation,
                'religion'      => $request->religion,
                'user_id'       => Sentinel::getUser()->id,
                'created_at'    => now()
        ];
        // dd($data);

        $patient->create($data);

        Session::flash('success', 'patient Added Succeed!');
        Pharma::activities("Added", "patient", "Added a New patient");
        return redirect('patient');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        // Pharma::ownItems($patient);
        // $sales = Sale::where()
        // $admission          = HmsAdmission::where('patient_id',$patient->id)->first();
        $DueDiagnosticBill  = Bill::where('patient_id',$patient->id)->where('status','Active')->where('due','>',0)->whereRaw('due > due_collection')->get();
        
        $DuePharmacy        = Sale::where('patient_id',$patient->id)->where('status','Active')->where('new_balance','>',0)->whereRaw('new_balance > due_collection')->get();
        $DueOperation       = HmsOperation::where('patient_id',$patient->id)->where('status','Active')->where('due','>',0)->whereRaw('due > due_collection')->get();
        $dueCollections     = Transation::where('transaction_type','Collection')->where('vendor','Patient')->where('vendor_id',$patient->id)->where('status','Active')->get();
        $DueEmergency       = HmsEmergency::where('patient_id',$patient->id)->where('status','Active')->where('due','>',0)->whereRaw('due > due_collection')->get();
        $patient            = $patient->load('bill','admission');
        // $diagonHistory = Patient::with('bill')->get();
        // dd($diagonHistory);  
        $admissionHistory = HmsAdmission::where('patient_id',$patient->id)->where('status','Active')->get();
        $emergencyHistory = HmsEmergency::where('patient_id',$patient->id)->where('status','Active')->get();
        $operationHistory = HmsOperation::where('patient_id',$patient->id)->where('status','Active')->get();
        $bedHistory       = BedChargeCollection::where('patient_id',$patient->id)->where('status','Active')->get();

        return view('patients.show', compact('patient','emergencyHistory','operationHistory','bedHistory','dueCollections','admissionHistory','DueEmergency','DueDiagnosticBill','DuePharmacy','DueOperation','dueCollections'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        $this->validateForm($request);
        $data = [
            'patient_name'  => $request->patient_name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'age'           => $request->age,
            'picture'       => Pharma::fileUpload($request,'picture','old_image','/uploads/patients', $request->patient_number),
            'gender'        => $request->gender,
            'description'   => $request->description,
            'marital_status'=> $request->marital_status,
            'blood_group'   => $request->blood_group,
            'guardian'      => $request->guardian,
            'relationship'  => $request->relationship,
            'guardian_phone'=> $request->guardian_phone,
            'occupation'    => $request->occupation,
            'religion'      => $request->religion,
            'updated_at'    => now()
        ];
         $patient->update($data);

        Session::flash('success', 'Patient Updated Succeed!');
        Pharma::activities("Update", "patient", "Updated patient");
        return redirect('patient/'.$request->patient_number.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        Session::flash('success', 'patient Deleted Succeed!');
        Pharma::activities("Deleted", "patient", "Deleted patient");
        return redirect('patient');
    }

    private function validateForm($request)
    {
        $validatedData = $request->validate([
            'patient_name'  => 'required',
            // 'slug'          => 'required',
            'email'         => 'sometimes|nullable|email',
            'phone'         => 'required|numeric',
            'address'       => 'required',
            'age'           => 'required|numeric',
            // 'picture'       => 'required',
            // 'password'      => 'required',
            // 'gender'        => 'required',
            // 'description'   => 'required',
            // 'marital_status'=> 'required',
            'blood_group'   => 'required',
            // 'guardian'      => 'required',
            // 'relationship'  => 'required',
            // 'guardian_phone'=> 'required',
            // 'user_id'       => 'required',
            // 'status'        => 'required'
        ]);
    }
}
