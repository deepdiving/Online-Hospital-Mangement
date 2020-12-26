<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssetLocation;
use App\AssetCategory;
use App\AssetEquipment;
use Pharma;
use Sentinel;
use Session;
class AssetEquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $location  = AssetLocation::where('status','Active')->get(); 
         $category  = AssetCategory::where('status','Active')->get();
       
        //dd($category);
        $equipment = AssetEquipment::with(['location','category'])->get();      
    //    dd($equipment);
        return view('asset.equipment.index',compact('location','category','equipment'));
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
    public function store( AssetEquipment $equipment,Request $request)
    {
        $identification_no = Pharma::identification_no($equipment,$request->category_id,$request->item_name);
        // dd($identification_no);
        $data = [          
            'item_name'            => $request->item_name,  
            'description'          => $request->description, 
            'model'                => $request->model,  
            'identification_no'    => $identification_no,
            'serial_number'        => $request->serial_number,  
            'current_status'       => $request->current_status, 
            'condition'            => $request->condition,  
            'received_date'        => $request->received_date, 
            'acquisition_cost'     => $request->acquisition_cost,  
            'category_id'          => $request->category_id, 
            'location_id'          => $request->location_id,  
            'user_id'              => Sentinel::getUser()->id,
            'Created_at'           => now(),
         ];      
          AssetEquipment::create($data);
          Session::flash('success', 'Asset Equipment  Update Succeed!');
          Pharma::activities("Create", "Asset Equipment ", "Create Asset Equipment ");
          return redirect('asset/equipment');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AssetEquipment $equipment)
    {
        return view('asset.equipment.show',compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AssetEquipment $equipment)
    {
        $location  = AssetLocation::where('status','Active')->get(); 
        $category  = AssetCategory::where('status','Active')->get();
        return view('asset.equipment.edit',compact('location','category','equipment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( AssetEquipment $equipment,Request $request)
    {
        $data = [          
            'item_name'            => $request->item_name,  
            'description'          => $request->description, 
            'model'                => $request->model,  
            'identification_no'    => $request->identification_no, 
            'serial_number'        => $request->serial_number,  
            'current_status'       => $request->current_status, 
            'condition'            => $request->condition,  
            'received_date'        => $request->received_date, 
            'acquisition_cost'     => $request->acquisition_cost,  
            'category_id'          => $request->category_id, 
            'location_id'          => $request->location_id,  
            'user_id'              => Sentinel::getUser()->id,
            'Update_at'            => now(),
         ];      
         $equipment->update($data);
          Session::flash('success', 'Asset Equipment  Update Succeed!');
          Pharma::activities("Update", "Asset Equipment ", "Updated Asset Equipment ");
          return redirect('asset/equipment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetEquipment $equipment)
    {
       
        $equipment->delete();

        Session::flash('success','Asset Equipment   Deleted Succeed!');
        Pharma::activities("Deleted", "Asset Equipment  ", "Asset Equipment  ");
        return redirect('asset/equipment');
    }
}
