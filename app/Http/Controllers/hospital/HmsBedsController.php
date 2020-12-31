<?php

namespace App\Http\Controllers\hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hospital\HmsBedType;
use App\Models\hospital\HmsBed;
use Pharma;
use Sentinel;
use Session;

class HmsBedsController extends Controller
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
        $beds = HmsBed::with('bedtype')->get();
        $bedtype = HmsBedType::all();
        return view('hospital.beds.bed.index',compact('beds','bedtype'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bedtype = HmsBedType::all();
        return view('hospital.beds.bed.create',compact('bedtype'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,HmsBed $bed)
    {
      $request->validate([
        'bed_no' => 'required|unique:hms_beds|max:20000',
        'price' => 'required|numeric|min:1|max:20000',
      ]);

        $bed_no = Pharma::getUniqueSlug($bed,$request->bed_no);
        $data = $request->only('price','slug','bed_no','status','bed_status','bed_type_id','user_id');
        $data['user_id'] = Sentinel::getUser()->id;
        $data['slug'] = $bed_no;

        HmsBed::create($data);
        Session::flash('success', 'Bed Added Succeed!');
        Pharma::activities("Added", "Bed", "Added a New Bed");
        return redirect('hospital/beds/bed');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HmsBed $bed)
    {
        return view('hospital.beds.bed.show',compact('bed'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(HmsBed $bed)
    {
         $bedtype = HmsBedType::all();
        return view('hospital.beds.bed.edit',compact('bedtype','bed'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HmsBed $bed)
    {
        $request->validate([
          'bed_no' => 'required|max:20000',
          'price' => 'required|numeric|min:1|max:20000',
        ]);

        $data = $request->only('price','slug','bed_no','status','bed_type_id','user_id');
        $data['user_id'] = Sentinel::getUser()->id;

        $bed->update($data);
        Session::flash('success', 'Bed Update Succeed!');
        Pharma::activities("Update", "Bed", "Updated Bed");
        return redirect('hospital/beds/bed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HmsBed $bed)
    {
        $bed->delete();

        Session::flash('success','Bed Deleted Succeed!');
        Pharma::activities("Deleted", "Bed", "Deleted Bed");
        return redirect('hospital/beds/bed');
    }

    public function status(){

        $bed = HmsBed::with('bedtype')->get();
        $bedtypes = HmsBedType::with('bed')->get();
        // dd($bedtypes);
        return view('hospital.beds.bed.status',compact('bed','bedtypes'));
    }
}
