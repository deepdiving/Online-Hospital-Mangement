<?php

namespace App\Http\Controllers\hrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hrm\HrmDepartment;
use Pharma;
use Sentinel;
use Session;
class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $department = HrmDepartment::all();         
       return view ('hrm.department.index',compact('department'));
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
        $request->validate([
            'name' => 'required|unique:hrm_departments|',
            'description' => 'required',

           ]);

           $data = [          
            'name'              => $request->name,  
            'description'       => $request->description, 
            'user_id'           => Sentinel::getUser()->id,
            'created_at'        => now(),
        ];
        //dd($data);
        HrmDepartment::create($data);
        Session::flash('success', 'Department   Succeed!');
        Pharma::activities("Added", "Department", "Added a New Department Type");
        return redirect('department');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HrmDepartment $department)   
    {  
        return view ('hrm.department.show',compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(HrmDepartment $department)
    {                 
        return view ('hrm.department.edit',compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HrmDepartment $department,Request $request)
    {
      
        $request->validate([
            'name' => 'required',
            'description' => 'required',

           ]);

           $data = [          
            'name'              => $request->name,  
            'description'       => $request->description, 
            'user_id'           => Sentinel::getUser()->id,
            'Updated_at'        => now(),
         ];      
          $department->update($data);
          Session::flash('success', 'Department Update Succeed!');
          Pharma::activities("Update", "Department", "Updated Medicine");
          return redirect('department/');
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HrmDepartment $department)
    {
       
        $department->delete();

        Session::flash('success','Department Deleted Succeed!');
        Pharma::activities("Deleted", "Department", "Deleted Bed");
        return redirect('department');
    }
   
}
