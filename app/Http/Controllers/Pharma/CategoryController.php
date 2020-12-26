<?php

namespace App\Http\Controllers\Pharma;

use App\Models\Pharma\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use Sentinel;
use Pharma;
use Session;
class CategoryController extends Controller{
    
    public function __construct(){
        $this->middleware(['authorized','pharma']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category){
        if (!Sentinel::hasAccess('category-index')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        // $categories = Pharma::ownResults($category);
        $categories = Category::where('status','Active')->orderBy('id','desc')->get();
        return view('pharma.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        if (!Sentinel::hasAccess('category-create')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        return view('pharma.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category){
        if (!Sentinel::hasAccess('category-create')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $this->validateForm($request);
        $category->create($request->merge([
            'name'       => $request->name,
            'description'   => $request->description,
            'slug'          => Pharma::getUniqueSlug($category,$request->name),
            'user_id'       => Sentinel::getUser()->id,
            'created_at'    => now(),
        ])->all());

        Session::flash('success','Category Added Succeed!');
        Pharma::activities("Added", "Category", "Added a New Category");
        return redirect('products/category');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category){
        if (!Sentinel::hasAccess('category-show')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        // Pharma::ownItems($category);
        return view('pharma.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category){
        if (!Sentinel::hasAccess('category-edit')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        // Pharma::ownItems($category);
        return view('pharma.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category){
        if (!Sentinel::hasAccess('category-edit')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $this->validateForm($request);
        $category->update($request->merge([
            'name'       => $request->name,
            'description'   => $request->description,
            'slug'          => Pharma::getUniqueSlug($category,$request->name),
            'updated_at'    => now(),
        ])->all());

        Session::flash('success','Category Updated Succeed!');
        Pharma::activities("Update", "Category", "Updated Category");
        return redirect('products/category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category){
        if (!Sentinel::hasAccess('category-destroy')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $category->delete();
        Session::flash('success','Category Deleted Succeed!');
        Pharma::activities("Deleted", "Category", "Deleted Category");
        return redirect('products/category');
    }

    private function validateForm($request){
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
    }
}
