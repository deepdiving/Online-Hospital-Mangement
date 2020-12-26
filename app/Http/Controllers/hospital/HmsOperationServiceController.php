<?php

namespace App\Http\Controllers\hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hospital\HmsOperationService;
use App\Models\hospital\HmsOperationType;
use Pharma;
use Sentinel;
use Session;
class HmsOperationServiceController extends Controller
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
        $types = HmsOperationType::all();
        $services = HmsOperationService::with('category')->get();
        return view('hospital.operations.services.index',compact('types','services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hospital.operations.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,HmsOperationService $service)
    {
        $request->validate([
         'name' => 'required|unique:hms_operation_services|max:200',
         'price' => 'required|numeric|min:1',
        ]);

        $type = Pharma::getUniqueSlug( $service,$request->name);
        $data = [
          'name'              => $request->name,
          'price'             => $request->price,
          'slug'              => $type,
          'operation_type_id' => $request->operation_type_id ,
          'user_id'           => Sentinel::getUser()->id,
          'created_at'        => now(),
        ];

        HmsOperationService::create($data);

        Session::flash('success', 'Operation Type  Added Succeed!');
        Pharma::activities("Added", "Operation", "Added a New Type");
        return redirect('hospital/operation/service');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = HmsOperationService::findorfail($id) ;
        // dd($type);
       return view('hospital.operations.services.show',compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(HmsOperationService $service)
    {
        // $service = HmsOperationService::findorfail($id) ;
        $category = HmsOperationType::all();
        // dd($type->category);
        // dd($category);
        return view('hospital.operations.services.edit',compact('service','category'));
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
         'price' => 'required|numeric|min:1',
        ]);

        $type = HmsOperationService::findorfail($id);
        $type->name = $request->name;
        $type->price = $request->price;
        $type->operation_type_id=$request->operation_type_id;
        $type->save();
        //dd($data);
        Session::flash('success', 'Operation  Type Update Succeed!');
        Pharma::activities("Added", "Type", "Added a New Operation Type");
        return redirect('hospital/operation/service');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = HmsOperationService::findorfail($id) ;
        $type->delete();
        Session::flash('success', 'Operation Type Deleted Succeed!');
        Pharma::activities("Deleted", "Operation", "Deleted Operation Type");
        return redirect('hospital/operation/service');
    }
}
