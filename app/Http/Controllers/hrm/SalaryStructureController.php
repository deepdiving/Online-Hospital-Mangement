<?php

namespace App\Http\Controllers\hrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hrm\HrmSalaryStructure;
use Pharma;
use Sentinel;
use Session;
class SalaryStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       
        $salaryst = HrmSalaryStructure::all();         
       return view ('hrm.salaryst.index',compact('salaryst'));
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
            'title' => 'required',
            'type'  => 'required'

           ]);

           $data = [                     
            'title'             => $request->title, 
            'type'              => $request->type, 
            'user_id'           => Sentinel::getUser()->id,
            'created_at'        => now(),
        ];
        //dd($data);
        HrmSalaryStructure::create($data);
        Session::flash('success', 'Salary Stracture Succeed!');
        Pharma::activities("Added", "Salary Stracture", "Added a New Salary Stracture Type");
        return redirect('salary/structure');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HrmSalaryStructure $structure)
    {
        return view ('hrm.salaryst.show',compact('structure'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(HrmSalaryStructure $structure)
    {
        return view ('hrm.salaryst.edit',compact('structure')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HrmSalaryStructure $structure,Request $request)
    {
        $request->validate([            
            'title' => 'required',
            'type'  => 'required'

           ]);

           $data = [                     
            'title'             => $request->title, 
            'type'              => $request->type, 
            'user_id'           => Sentinel::getUser()->id,
            'Updated_at'        => now(),
        ];         
        $structure->update($data);
        Session::flash('success', 'Salary Stracture Succeed!');
        Pharma::activities("Update", "Salary Stracture", "Update a New Salary Stracture Type");
        return redirect('salary/structure');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HrmSalaryStructure $structure)
    {      
        $structure->delete();
        Session::flash('success','Salary Structure Deleted Succeed!');
        Pharma::activities("Deleted", "Salary Structure", "Deleted Salary Structure");
        return redirect('salary/structure');
    }
}
