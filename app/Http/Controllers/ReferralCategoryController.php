<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReferralCategory;
use Pharma;
use Sentinel;
use Session;
class ReferralCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $category=ReferralCategory::all();
        return view('referrals.referralcategory.index',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('referrals.referralcategory.index',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,ReferralCategory $category ){

      $request->validate([
          'cat_name' => 'required',
          'price'    => 'required',
         ]);

        $category = Pharma::getUniqueSlug($category,$request->cat_name);
        $data = [
            'cat_name'          => $request->cat_name,
            'price'             => $request->price,
            'slug'              => $category,
            'created_at'        => now(),
        ];
        ReferralCategory::create($data);
        Session::flash('success', 'Referral  Categroy Succeed!');
        Pharma::activities("Added", "Category", "Added a New Referral Categroy");
        return redirect('referral/category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ReferralCategory $category){
        return view('referrals.referralcategory.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ReferralCategory $category){
        return view('referrals.referralcategory.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReferralCategory $category){
        $request->validate([
            'cat_name' => 'required',
            'price'    => 'required',
           ]);

        $data = [
            'cat_name'          => $request->cat_name,
            'price'             => $request->price,
            'updated_at'        => now(),
        ];
        $category->update($data);
        Session::flash('success', 'category Updated Succeed!');

        Pharma::activities("Update", "category", "Updated Bed");
        return redirect('referral/category');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( ReferralCategory $category){
        $category->delete();
        Session::flash('success', 'Category Deleted Succeed!');
        Pharma::activities("Deleted", "Category", "Deleted category");
        return redirect('referral/category');
    }

}
