<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
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
      $department = Department::all();
        return view('departments.index',compact('department'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('departments.index',compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request ,Department $description)
    {
         $request->validate([
          'dep_name' => 'required|unique:departments|max:200',
          'description' => 'required',
         ]);
         $data = [
                'dep_name'          => $request->dep_name,
                'description'       => $request->description,
                'user_id'           => Sentinel::getUser()->id,
                'created_at'        => now(),
         ];
          //dd($data);
          Department::create($data);
          Session::flash('success', 'Departments Succeed!');
          Pharma::activities("Added", "Departments", "Added a New Departments");
          return redirect('departments');

      }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $department=Department::findorfail($id) ;
       //dd($operataion);
     return view('departments.show',compact('department'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $department = Department::findorfail($id) ;
     return view('departments.edit',compact('department'));
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
       'dep_name' => 'required|max:200',
       'description' => 'required',
      ]);

      $department = Department::findorfail($id) ;
      $department->dep_name = $request->dep_name;
      $department->description = $request->description;
      $department->save();

      //dd($data);
      Session::flash('success', 'Department Update Succeed!');
      Pharma::activities("Added", "Department", "Added a New Department");
      return redirect('departments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $department = Department::findorfail($id);
      $department->delete();
      Session::flash('success', 'Department Deleted Succeed!');
      Pharma::activities("Deleted", "Department", "Deleted Department");
      return redirect('departments');
   }

}
