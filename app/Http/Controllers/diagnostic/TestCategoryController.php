<?php

namespace App\Http\Controllers\diagnostic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\diagnostic\DiagonTestCategory;
use Session;

class TestCategoryController extends Controller
{

    public function __construct(){
        $this->middleware(['authorized','diagnostic']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diagontestcategories = DiagonTestCategory::all();
        return view('diagnostic.categories.index',compact('diagontestcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('diagnostic.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateForm($request);
        $data = $request->only('category','commission');

        DiagonTestCategory::create($data);
        
        Session::flash('success','Test Category Added Succeed!');
        return redirect('diagnostic/categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $DiagonTestCategory = DiagonTestCategory::findOrFail($id);
        return view('diagnostic.categories.show',compact('DiagonTestCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $DiagonTestCategory = DiagonTestCategory::findOrFail($id);
        return view('diagnostic.categories.edit',compact('DiagonTestCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateForm($request);
        $DiagonTestCategory = DiagonTestCategory::findOrFail($id);

        $DiagonTestCategory->update($request->only('category','commission'));

        Session::flash('success','Test Category Updated Succeed!');
        return redirect('diagnostic/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $DiagonTestCategory = DiagonTestCategory::findOrFail($id);

        $DiagonTestCategory->delete();

        Session::flash('success','Test Category Deleted Succeed!');
        return redirect('diagnostic/categories');
    }

     private function validateForm($request){
        $validatedData = $request->validate([
            'category' => 'required',
        ]);
    }
}
