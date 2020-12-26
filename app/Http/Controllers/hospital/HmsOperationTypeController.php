<?php

namespace App\Http\Controllers\hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hospital\HmsOperationType;
use Pharma;
use Sentinel;
use Session;
class HmsOperationTypeController extends Controller
{

    public function __construct(){
        $this->middleware(['authorized','hospital']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operation = HmsOperationType::all();
        return view('hospital.operations.types.index',compact('operation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('hospital.operations.types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,HmsOperationType $types)
    {
        $request->validate([
         'name' => 'required|unique:hms_operation_types|max:200',       
        ]);

        $category = Pharma::getUniqueSlug($types,$request->name);
        $data = [
            'date'              => date('Y-m-d'),
            'name'              => $request->name,
            'slug'              =>  $category,
            'user_id'           => Sentinel::getUser()->id,
            'created_at'        => now(),
        ];
        //dd($data);
        HmsOperationType::create($data);
        Session::flash('success', 'Operation  Categroy Succeed!');
        Pharma::activities("Added", "Category", "Added a New Operation Categroy");
        return redirect('hospital/operation/type');

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $operation=HmsOperationType::findorfail($id) ;
         //dd($operataion);
       return view('hospital.operations.types.show',compact('operation'));

    }
   /*
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $operation = HmsOperationType::findorfail($id) ;
        return view('hospital.operations.types.edit',compact('operation'));
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
         'name' => 'required|max:200',      
        ]);

        $operation = HmsOperationType::findorfail($id);
        $operation->name = $request->name;
        $operation->save();

        //dd($data);
        Session::flash('success', 'Operation  Categroy Update Succeed!');
        Pharma::activities("Added", "Category", "Added a New Operation Categroy");
        return redirect('hospital/operation/type');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $operation = HmsOperationType::findorfail($id);
        $operation->delete();
        Session::flash('success', 'Operation Categroy Deleted Succeed!');
        Pharma::activities("Deleted", "Operation", "Deleted Service Category");
        return redirect('hospital/operation/type');
    }
}
