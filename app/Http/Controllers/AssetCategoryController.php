<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssetCategory;
use Pharma;
use Sentinel;
use Session;
class AssetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $category = AssetCategory::all();              
        return view ('asset.category.index',compact('category'));
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
        AssetCategory::create($data);
        Session::flash('success', 'Asset Category   Succeed!');
        Pharma::activities("Added", "Asset Category", "Added a New Asset Category ");
        return redirect('asset/category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AssetCategory $category)
    {
        return view ('asset.category.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AssetCategory $category)
    {
        return view ('asset.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssetCategory $category,Request $request)
    {
        $data = [          
            'name'              => $request->name,  
            'description'       => $request->description, 
            'user_id'           => Sentinel::getUser()->id,
            'Updated_at'        => now(),
         ];      
          $category->update($data);
          Session::flash('success', 'Asset Category  Update Succeed!');
          Pharma::activities("Update", "Asset Category ", "Updated Asset Category ");
          return redirect('asset/category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetCategory $category)
    {
        $category->delete();

        Session::flash('success','Asset Category  Deleted Succeed!');
        Pharma::activities("Deleted", "Asset Category ", "Deleted Asset Category ");
        return redirect('asset/category');
    
    }
}
