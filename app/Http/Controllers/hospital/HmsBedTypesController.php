<?php

namespace App\Http\Controllers\hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hospital\HmsBedType;
use Pharma;
use Sentinel;
use Session;

class HmsBedTypesController extends Controller
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
        $beds = HmsBedType::all();
        return view('hospital.beds.bedtype.index',compact('beds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hospital.beds.bedtype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, HmsBedType $bedtype)
    {
      $request->validate([
       'name' => 'required|unique:hms_bed_types|max:200',
      ]);

        $bed_number = Pharma::getUniqueSlug($bedtype,$request->name);
        $data = $request->only('name','user_id','slug','status');
        $data['user_id'] = Sentinel::getUser()->id;
        $data['slug'] = $bed_number ;

        HmsBedType::create($data);
        Session::flash('success', 'Bed Added Succeed!');
        Pharma::activities("Added", "Bed", "Added a New Bed");
        return redirect('hospital/beds/bedtype');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HmsBedType $bedtype)
    {
        return view('hospital.beds.bedtype.show',compact('bedtype'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(HmsBedType $bedtype)
    {
        return view('hospital.beds.bedtype.edit',compact('bedtype'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HmsBedType $bedtype)
    {
        $request->validate([
         'name' => 'required|max:200',
        ]);

        $data = $request->only('name','user_id','slug','status');
        $data['user_id'] = Sentinel::getUser()->id;

        $bedtype->update($data);
        Session::flash('success', 'Bed Updated Succeed!');
        Pharma::activities("Update", "Bed", "Updated Bed");
        return redirect('hospital/beds/bedtype');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HmsBedType $bedtype)
    {
        $bedtype->delete();

        Session::flash('success', 'Bed Deleted Succeed!');
        Pharma::activities("Deleted", "Bed", "Deleted Bed");
        return redirect('hospital/beds/bedtype');
    }
}
