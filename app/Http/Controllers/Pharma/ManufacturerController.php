<?php

namespace App\Http\Controllers\Pharma;
use App\Http\Controllers\Controller;

use App\Models\Pharma\Manufacturer;
use Illuminate\Http\Request;
Use Sentinel;
use Pharma;
use Session;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware(['authorized','pharma']);
    }

    public function index(Manufacturer $manufacturer)
    {
        if (!Sentinel::hasAccess('manufacturer-index')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $manufacturers = Manufacturer::where('status','Active')->get(); //Pharma::ownResults($manufacturer);
        return view('pharma.manufacturers.index', compact('manufacturers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Sentinel::hasAccess('manufacturer-create')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        return view('pharma.manufacturers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Manufacturer $manufacturer)
    {
        if (!Sentinel::hasAccess('manufacturer-create')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        // $this->validateForm($request);
        $manufacturer->create($request->merge([
            'manufacturer_name'       => $request->manufacturer_name,
            'phone'   => $request->phone,
            'address'   => $request->address,
            'manufacturer_balance'   => $request->manufacturer_balance,
            'slug'          => Pharma::getUniqueSlug($manufacturer,$request->manufacturer_name),
            'user_id'       => Sentinel::getUser()->id,
            'created_at'    => now(),
        ])->all());

        Session::flash('success','manufacturer Added Succeed!');
        Pharma::activities("Added", "manufacturer", "Added a New manufacturer");
        return redirect('manufacturers/manufacturer/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\manufacturer  $manufacturer
     * @return \Illuminate\Http\Response
     */
    public function show(Manufacturer $manufacturer)
    {
        if (!Sentinel::hasAccess('manufacturer-show')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        Pharma::ownItems($manufacturer);
        return view('pharma.manufacturers.show', compact('manufacturer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\manufacturer  $manufacturer
     * @return \Illuminate\Http\Response
     */
    public function edit(Manufacturer $manufacturer)
    {
        if (!Sentinel::hasAccess('manufacturer-edit')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        Pharma::ownItems($manufacturer);
        return view('pharma.manufacturers.edit', compact('manufacturer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\manufacturer  $manufacturer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Manufacturer $manufacturer)
    {
        if (!Sentinel::hasAccess('manufacturer-edit')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $this->validateForm($request);
        $manufacturer->update($request->merge([
            'manufacturer_name'       => $request->manufacturer_name,
            'phone'   => $request->phone,
            'address'   => $request->address,
            'manufacturer_balance'   => $request->manufacturer_balance,
            'slug'          => Pharma::getUniqueSlug($manufacturer,$request->manufacturer_name),
            'user_id'       => Sentinel::getUser()->id,
            'updated_at'    => now(),
        ])->all());

        Session::flash('success','manufacturer Updated Succeed!');
        Pharma::activities("Update", "manufacturer", "Updated manufacturer");
        return redirect('manufacturers/manufacturer/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\manufacturer  $manufacturer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manufacturer $manufacturer)
    {
        if (!Sentinel::hasAccess('manufacturer-destroy')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $manufacturer->delete();
        Session::flash('success','manufacturer Deleted Succeed!');
        Pharma::activities("Deleted", "manufacturer", "Deleted manufacturer");
        return redirect('manufacturers/manufacturer');
    }
    private function validateForm($request){
        $validatedData = $request->validate([
            'manufacturer_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'manufacturer_balance' =>'required'
        ]);
        }
}

