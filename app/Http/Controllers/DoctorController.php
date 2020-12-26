<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\Doctor;
use App\User;
use App\DoctorPayment;
use App\Models\doctor\DocAppointment;
use Sentinel;
use Session;
use Pharma;
use DB;

class DoctorController extends Controller
{
    public function index(){
        $doctors = Doctor::all();
        return view('doctors.index',compact('doctors'));
    }

    public function create(){
        $departmets = Department::all();
        return view('doctors.create',compact('departmets'));
    }

    public function store(Request $request){  
        $data = [
            'full_name'      => $request->full_name,
            'email'          => $request->email,    
            'department_id'  => $request->department_id,
            'picture'        => Pharma::fileUpload($request,'picture','','/uploads/doctors'),
            'gender'         => $request->gender,
            'blood_group'    => $request->blood_group,
            'designation'    => $request->designation,
            'phone_no'       => $request->phone_no,
            'mobile_no'      => $request->mobile_no,
            'address'        => $request->address,
            'biography'      => $request->biography,
            'age'            => $request->age,
            'marital_status' => $request->marital_status,
            'religion'       => $request->religion, 
            'user_id'        => Sentinel::getUser()->id,
            'created_at'     => now() ,
        ];  
        $doctor = Doctor::create($data);

        $userData = [
            'name'              => $request->full_name,
            'email'             => $request->email,
            'password'          => '123456',
            'last_login'        => '',
            'first_name'        => $request->full_name,
            'last_name'         => '',
            'profile_image'     => $data['picture'],
            'profile_banar'     => $data['picture'],
        ];


        // $user = User::create($userData);

        $user = Sentinel::registerAndActivate($userData);
        $role = Sentinel::findRoleBySlug('doctor');
        $role->users()->attach($user->id);

        $doctor->own_user_id = $user->id;
        $doctor->save();

        Session::flash('success', 'Doctor Added Succeed!');
        Pharma::activities("Added", "Doctor", "Added a New Doctor");
        return redirect('doctor');
    }

    public function show(Request $request,Doctor $doctor){
        $search = [
            'start' => '-',
            'end'   => '-',
        ];

        $appoint = New DocAppointment;
        if($request->has('start') && $request->start != '-'){
            $appoint = $appoint->where('date','>=',$request->start);
            $search['start'] = $request->start;
        }
        if($request->has('end') && $request->end != '-'){
            $appoint = $appoint->where('date','<=',$request->end);
            $search['end'] = $request->end;
        }

        $doctorPayment = DoctorPayment::with('transation')->where('doctor_id',$doctor->id)->get();
        $patient_data = $appoint->where('doctor_id',$doctor->id)->get();
       
        
        return view('doctors.show',compact('doctor','doctorPayment','search','patient_data'));
    }

    public function edit(Doctor $doctor){
        $departmets = Department::all();
        return view('doctors.edit',compact('doctor','departmets'));
    }

    public function update(Request $request,Doctor $doctor){
        $this->validateForm($request);
        $data = [
            'full_name'      => $request->full_name,
            'email'          => $request->email,    
            'department_id'  => $request->department_id, 
            'picture'       => Pharma::fileUpload($request,'picture','old_image','/uploads/patients'),
            'gender'         => $request->gender,
            'blood_group'    => $request->blood_group,
            'designation'    => $request->designation,
            'phone_no'       => $request->phone_no,
            'mobile_no'      => $request->mobile_no,
            'address'        => $request->address,
            'biography'      => $request->biography,
            'age'            => $request->age,
            'marital_status' => $request->marital_status,
            'religion'       => $request->religion, 
            'user_id'        => Sentinel::getUser()->id,
            'created_at'     => now() ,
        ];
        
        $doctor->update($data);

        $userData = [
            'name'              => $request->full_name,
            'email'             => $request->email,
            'password'          => '123456',
            'last_login'        => '',
            'first_name'        => $request->full_name,
            'last_name'         => '',
            'profile_image'     => $data['picture'],
            'profile_banar'     => $data['picture'],
        ];


        
        $user = Sentinel::findById($doctor->own_user_id);
        $user = Sentinel::update($user, $userData);

        Session::flash('success', 'Doctor updated Succeed!');
        Pharma::activities("Updated", "Doctor", "Update Doctor");
        return redirect('doctor');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        Session::flash('success', 'Doctor Deleted Succeed!');
        Pharma::activities("Deleted", "Doctor", "Deleted patient");
        return redirect('doctor');
    }

    private function validateForm($request)
    {
        $validatedData = $request->validate([
            
            'email' => 'sometimes|nullable|email', 
        ]);
    }
}
