<?php

namespace App\Http\Controllers\Pharma;
use App\Http\Controllers\Controller;

use App\Models\Pharma\Unit;
use Illuminate\Http\Request;
Use Sentinel;
use Pharma;
use Session;
class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct(){
       $this->middleware(['authorized','pharma']);
    }

    public function index(Unit $unit)
    {
        if (!Sentinel::hasAccess('unit-index')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        // $units = Pharma::ownResults($unit);
        $units = Unit::where('status','Active')->orderBy('id','desc')->get();
        return view('pharma.units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Sentinel::hasAccess('unit-create')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        return view('pharma.units.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Unit $type)
    {
        if (!Sentinel::hasAccess('unit-create')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $this->validateForm($request);
        $type->create($request->merge([
            'type_name'       => $request->unit_name,
            'description'   => $request->description,
            'slug'          => Pharma::getUniqueSlug($type,$request->unit_name),
            'user_id'       => Sentinel::getUser()->id,
            'created_at'    => now(),
        ])->all());

        Session::flash('success','unit Added Succeed!');
        Pharma::activities("Added", "unit", "Added a New unit");
        return redirect('products/unit');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        if (!Sentinel::hasAccess('unit-show')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        // Pharma::ownItems($unit);
        return view('pharma.units.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        if (!Sentinel::hasAccess('unit-edit')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        // Pharma::ownItems($unit);
        return view('pharma.units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        if (!Sentinel::hasAccess('unit-edit')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $this->validateForm($request);
        $unit->update($request->merge([
            'unit_name'       => $request->unit_name,
            'description'   => $request->description,
            'slug'          => Pharma::getUniqueSlug($unit,$request->unit_name),
            'updated_at'    => now(),
        ])->all());

        Session::flash('success','unit Updated Succeed!');
        Pharma::activities("Update", "unit", "Updated unit");
        return redirect('products/unit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        if (!Sentinel::hasAccess('unit-destroy')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $unit->delete();
        Session::flash('success','unit Deleted Succeed!');
        Pharma::activities("Deleted", "unit", "Deleted unit");
        return redirect('products/unit');
    }
    private function validateForm($request){
        $validatedData = $request->validate([
            'unit_name' => 'required',
        ]);
        }
}
