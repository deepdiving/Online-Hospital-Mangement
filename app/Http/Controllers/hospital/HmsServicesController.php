<?php

namespace App\Http\Controllers\hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hospital\HmsService;
use App\Models\hospital\HmsServiceCategory;
use Pharma;
use Sentinel;
use Session;

class HmsServicesController extends Controller
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
        $services = HmsService::with('servicecategory')->get();
        $hmsCategory = HmsServiceCategory::all();
        return view('hospital.services.service.index',compact('services','hmsCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hmsCategory = HmsServiceCategory::all();
        return view('hospital.services.service.create',compact('hmsCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,HmsService $service)
    {
        $request->validate([
         'name' => 'required|unique:hms_services|max:200',
         'price' => 'required|numeric|min:1',
        ]);

        $service_no = Pharma::getUniqueSlug($service,$request->name);
        $data = $request->only('name','slug','price','status','service_category_id','user_id');
        $data['user_id'] = Sentinel::getUser()->id;
        $data['slug'] = $service_no;

        HmsService::create($data);

        Session::flash('success', 'Service  Added Succeed!');
        Pharma::activities("Added", "Service", "Added a New Service");
        return redirect('hospital/services/service');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HmsService $service)
    {
        return view('hospital.services.service.show',compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(HmsService $service)
    {
        $hmsCategory = HmsServiceCategory::all();
        return view('hospital.services.service.edit',compact('service','hmsCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HmsService $service)
    {
        $request->validate([
         'name' => 'required|max:200',
         'price' => 'required|numeric|min:1',
        ]);

        $date = $request->only('name','slug','price','status','service_category_id','user_id');
        $data['user_id'] = Sentinel::getUser()->id;

        $service->update($date);

        Session::flash('success', 'Service  Updated Succeed!');
        Pharma::activities("Update", "Service", "Updated Service");
        return redirect('hospital/services/service');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HmsService $service)
    {
        $service->delete();

        Session::flash('success', 'Service  Deleted Succeed!');
        Pharma::activities("Deleted", "Service", "Deleted Service");
        return redirect('hospital/services/service');
    }
}
