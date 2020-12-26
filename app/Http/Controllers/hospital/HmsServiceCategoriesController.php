<?php

namespace App\Http\Controllers\hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hospital\HmsServiceCategory;
use Pharma;
use Sentinel;
use Session;
class HmsServiceCategoriesController extends Controller
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
        $serviceCategory = HmsServiceCategory::all();
        return view('hospital.services.servicecategory.index',compact('serviceCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hospital.services.servicecategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,HmsServiceCategory $servicecategory)
    {
        $request->validate([
         'name' => 'required|unique:hms_service_categories|max:200',
        ]);

        $service_number = Pharma::getUniqueSlug($servicecategory,$request->name);
        $data = $request->only('name','slug','status','user_id');
        $data['user_id'] = Sentinel::getUser()->id;
        $data['slug'] = $service_number;

        HmsServiceCategory::create($data);

        Session::flash('success', 'Service  Categroy Succeed!');
        Pharma::activities("Added", "Service", "Added a New Service Categroy");
        return redirect('hospital/services/servicecategory');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HmsServiceCategory $servicecategory)
    {
        return view('hospital.services.servicecategory.show',compact('servicecategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(HmsServiceCategory $servicecategory)
    {
        return view('hospital.services.servicecategory.edit',compact('servicecategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HmsServiceCategory $servicecategory)
    {
        $request->validate([
         'name' => 'required|max:200',      
        ]);

        $data = $request->only('name','slug','status','user_id');
        $data['user_id'] = Sentinel::getUser()->id;

        $servicecategory->update($data);
        Session::flash('success', 'Service  Categroy Update Succeed!');
        Pharma::activities("Update", "Service", "Updated Service Categroy");
        return redirect('hospital/services/servicecategory');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HmsServiceCategory $servicecategory)
    {
        $servicecategory->delete();

        Session::flash('success', 'Service  Categroy Deleted Succeed!');
        Pharma::activities("Deleted", "Service", "Deleted Service Category");
        return redirect('hospital/services/servicecategory');
    }
}
