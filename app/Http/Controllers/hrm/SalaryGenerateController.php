<?php

namespace App\Http\Controllers\hrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hrm\HrmSalary;
use App\Models\hrm\SalaryTrack;
use App\Models\hrm\HrmEmployee;
use App\Models\hrm\HrmSalaryStructure;
use App\Models\hrm\HrmEmpPaidSalaryStructure;
use Sentinel;
use Pharma;
use Session;

class SalaryGenerateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genetateBy = SalaryTrack::all();
        $employee   = HrmEmployee::where('status','Active')->get(); 
        return view ('hrm.salary_generate.index',compact('genetateBy','employee'));
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
        
        $data = [
            'date'        => now(),
            'month'       => $request->month,
            'year'        => $request->year,
            'user_id'     => Sentinel::getUser()->id,
            'created_at'  => now()
        ];
        

        $salaryTrack = SalaryTrack::create($data);  

        for($i = 0; $i<count($request->emp_id);$i++){
            $data = [
                'salary_track_id'   => $salaryTrack->id,
                'month'             => $request->month,
                'year'              => $request->year,
                'emp_id'            => $request->emp_id[$i],
                'date'              => now(),
                'basic_salary'      => $request->basic_salary[$i],
                'gross_salary'      => $request->gross_salary[$i],
                'addamount'         => $request->addamount[$i],
                'deductamount'      => $request->deductamount[$i],
                'thismonthamount'   => $request->thismonthamount[$i],
                'remark'            => $request->remark[$i],
                'user_id'           => Sentinel::getUser()->id,
                'created_at'        => now()
            ];
            // dd($data);
            
            $salaryGenerate = HrmSalary::create($data) ; 
        } 

        $salaryGenerate->all();
        $salaryGenerate->update(['status' => 'Pending']);
        
        Session::flash('success', 'Salary Generated Successfully!');
        Pharma::activities("Added", "Salary", "Added a New Salary");
        return redirect('salary/generate');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function salaryList(){
        $salaryList = HrmSalary::all();
        return view('hrm.salary_generate.salaryList',compact('salaryList'));
    }

    public function paidSalary($id,Request $request){
        // dd($request->all());
        $employee = HrmEmployee::with('empSalaryStr.salarystr')->find($request->emp_id);
        
        foreach($employee->empSalaryStr as $srt){
            $data = [
                'emp_id'            => $request->emp_id,
                'hrm_salary_id'     => $request->hrm_salary_id,
                'structure'         => $srt->salarystr->title,
                'percent'           => $srt->amount,
                'amount'            => $srt->amount/100*$employee->basic_salary,
                'type'              => $srt->salarystr->type,
                'user_id'           => Sentinel::getUser()->id,
            ];
            HrmEmpPaidSalaryStructure::create($data);
        }
        // dd($data);
        $salaryList = HrmSalary::where('id',$id)->first();
        $salaryList->update(['status' => 'Paid']);



        return redirect('salary/list');
    }

    public function salarySlip($id){
        $slip = HrmSalary::where('id',$id)->with('employee.empPaidSalary')->first(); 
        // dd($slip);
        return view('hrm.salary_generate.salarySlip',compact('slip'));
    }
}
