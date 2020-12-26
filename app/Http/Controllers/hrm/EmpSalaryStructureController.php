<?php

namespace App\Http\Controllers\hrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hrm\HrmEmployee;
use App\Models\hrm\HrmEmpSalaryStructure;
use App\Models\hrm\HrmSalaryStructure;
use Pharma;
use Sentinel;
use Session;
class EmpSalaryStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $employee = HrmEmployee::all();
       $salarystr = HrmSalaryStructure::all();
       $empsalarystr = HrmEmpSalaryStructure::all(); 
       //dd($empsalarystr);   
       return view ('hrm.empsalaryst.index',compact('employee','salarystr','empsalarystr'));
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
    public function store(HrmEmpSalaryStructure $structure,Request $request)
    {
        $request->validate([
            'emp_id'              => 'required',
            'salary_structure_id' => 'required',
            'amount'              => 'required',

           ]);

           $data = [          
            'emp_id'                => $request->emp_id,  
            'salary_structure_id'   => $request->salary_structure_id, 
            'amount'                => $request->amount,     
            'user_id'               => Sentinel::getUser()->id,
            'created_at'            => now(),
        ];
        // dd($data);
        HrmEmpSalaryStructure::create($data);
        Session::flash('success', 'Employee Salary Structure  Succeed!');
        Pharma::activities("Added", "Employee Salary Structure  ", "Added a New Employee Salary Structure  ");
        return redirect('employee/salary/structure');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HrmEmpSalaryStructure $structure)
    {
        return view ('hrm.empsalaryst.show',compact('structure'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(HrmEmpSalaryStructure $structure)
    {
        $employee = HrmEmployee::all();
        $salarystr = HrmSalaryStructure::all();
        return view ('hrm.empsalaryst.edit',compact(['structure','employee','salarystr']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HrmEmpSalaryStructure $structure,Request $request)
    {
        $request->validate([
            'emp_id'              => 'required',
            'salary_structure_id' => 'required',
            'amount'              => 'required',

           ]);

           $data = [          
            'emp_id'                => $request->emp_id,  
            'salary_structure_id'   => $request->salary_structure_id, 
            'amount'                => $request->amount,     
            'user_id'               => Sentinel::getUser()->id,
            'Updated_at'            => now(),
        ];

        $structure->update($data);

        Session::flash('success', 'Employee Salary Structure Updated Succeed!');
        Pharma::activities("Update", "Employee Salary Structure", "Updated Service");
        return redirect('employee/salary/structure');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HrmEmpSalaryStructure $structure)
    {
        
        $structure->delete();

        Session::flash('success', 'Employee Salary Structure  Deleted Succeed!');
        Pharma::activities("Deleted", "Employee Salary Structure", "Deleted Service");
        return redirect('employee/salary/structure');
    }
}
