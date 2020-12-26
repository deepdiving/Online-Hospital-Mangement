<?php

namespace App\Http\Controllers\hrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hrm\HrmEmployee;
use App\Models\hrm\HrmDepartment;
use App\Models\hrm\HrmPosition;
use App\Models\hrm\HrmSalaryStructure;
use App\Models\hrm\HrmEmpSalaryStructure;
use Sentinel;
use Pharma;
use Session;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = HrmEmployee::where('status','Active')->get();
        //dd($employee);
        return view('hrm.employee.index',compact('employee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departmetn  = HrmDepartment::where('status','Active')->get();
        $position    = HrmPosition::where('status','Active')->get();
        $Addstr      = HrmSalaryStructure::where('type','Add')->get();
        $Deductstr   = HrmSalaryStructure::where('type','Deduct')->get();
       return view('hrm.employee.create',compact('departmetn','position','Addstr','Deductstr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $employee = HrmEmployee::create([
            'name'              => $request->name,
            'picture'           => Pharma::fileUpload($request,'picture','','/uploads/employees'),
            'date_of_birth'     => $request->date_of_birth,
            'phone_no'          => $request->phone_no,
            'email'             => $request->email,
            'joining_date'      => $request->joining_date,
            'address'           => $request->address,
            'gender'            => $request->gender,
            'basic_salary'      => $request->basic_salary,
            'gross_salary'      => $request->gross_salary,
            'department_id'     => $request->department_id,
            'position_id'       => $request->position_id,
            'marital_status'    => $request->marital_status,
            'emergency_contact' => $request->emergency_contact,
            'emergency_address' => $request->emergency_address,
            'user_id'           => Sentinel::getUser()->id,
            'created_at'        => now()
        ]);
         
        
        for($i= 0; $i < count($request->salary_structure_id); $i++){
            $empsalary = HrmEmpSalaryStructure::create([
                'emp_id'              => $employee->id,
                'salary_structure_id' => $request->salary_structure_id[$i], 
                'amount'              => $request->amount[$i],  
                'user_id'             => Sentinel::getUser()->id,
                'created_at'          => now()
            ]); 
        }
       
        Session::flash('success', 'Employee Added Succeed!');
        Pharma::activities("Added", "Employee", "Added a New Employee");
        return redirect('employee');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HrmEmployee $employee)
    {
        return view('hrm.employee.show',compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(HrmEmployee $employee)
    {
        $departmetn         = HrmDepartment::where('status','Active')->get();
        $position           = HrmPosition::where('status','Active')->get();
        $Addstr             = HrmSalaryStructure::where('type','Add')->get();
        $Deductstr          = HrmSalaryStructure::where('type','Deduct')->get();
        $empsalarystructure = HrmEmpSalaryStructure::where('emp_id',$employee->id)->with('salarystr')->get();
        // dd($empsalarystructure);
        return view('hrm.employee.edit',compact('employee','departmetn','position','Addstr','Deductstr','empsalarystructure'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HrmEmployee $employee)
    {
        $data = [
            'name'              => $request->name, 
            'picture'           => Pharma::fileUpload($request,'picture','old_image','/uploads/employees'),
            'date_of_birth'     => $request->date_of_birth,
            'phone_no'          => $request->phone_no,
            'email'             => $request->email,
            'joining_date'      => $request->joining_date,
            'address'           => $request->address,
            'gender'            => $request->gender,
            'basic_salary'      => $request->basic_salary,
            'gross_salary'      => $request->gross_salary,
            'department_id'     => $request->department_id,
            'position_id'       => $request->position_id,
            'marital_status'    => $request->marital_status,
            'emergency_contact' => $request->emergency_contact,
            'emergency_address' => $request->emergency_address,
            'user_id'           => Sentinel::getUser()->id,
            'update_at'        => now()
        ];

        

        $emp = $employee->update($data);  
       
        
        for($i=0;$i<count($request->salary_structure_id); $i++){
            $empsalary = HrmEmpSalaryStructure::where('id',$request->salary_structure_id[$i])->update([  
                'amount'              => $request->amount[$i],
                'user_id'             => Sentinel::getUser()->id,
                'updated_at'          => now()
            ]); 
        }

        

        Session::flash('success', 'Employee Updated Succeed!');
        Pharma::activities("Updated", "Employee", "Update Position");
        return redirect('employee');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HrmEmployee $employee)
    {
        $employee->delete();

        Session::flash('success', 'Employee Deleted Succeed!');
        Pharma::activities("Deleted", "Employee", "Deleted Employee");
        return redirect('employee');
    }
}
