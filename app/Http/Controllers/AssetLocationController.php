<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssetLocation;
use Pharma;
use Sentinel;
use Session;
class AssetLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $location = AssetLocation::all();              
        return view ('asset.location.index',compact('location'));
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
        
        $data = [          
            'name'              => $request->name,  
            'description'       => $request->description, 
            'user_id'           => Sentinel::getUser()->id,
            'created_at'        => now(),
        ];
        //dd($data);
        AssetLocation::create($data);
        Session::flash('success', 'Asset Location   Succeed!');
        Pharma::activities("Added", "Asset Category", "Added a New Asset Category ");
        return redirect('asset/location');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AssetLocation $location)
    {
        return view ('asset.location.show',compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AssetLocation $location)
    {
        return view ('asset.location.edit',compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssetLocation $location,Request $request)
    {
        $data = [          
            'name'              => $request->name,  
            'description'       => $request->description, 
            'user_id'           => Sentinel::getUser()->id,
            'Updated_at'        => now(),
         ];      
          $location->update($data);
          Session::flash('success', 'Asset Location   Update Succeed!');
          Pharma::activities("Update", "Asset Category ", "Updated Asset Location ");
          return redirect('asset/location');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetLocation $location)
    {
        $location->delete();

        Session::flash('success','Asset Location   Deleted Succeed!');
        Pharma::activities("Deleted", "Asset Location  ", "Asset Location  ");
        return redirect('asset/location');
    
    }
}
