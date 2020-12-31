<?php

namespace App\Http\Controllers\Pharma;
use App\Http\Controllers\Controller;

use App\Models\Pharma\ProductType;
use Illuminate\Http\Request;
use Pharma;
use Sentinel;
use Session;
class ProductTypeController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * 
     */
    public function __construct(){
        $this->middleware(['authorized','pharma']);
    }

    public function index(ProductType $type)
    {
        if (!Sentinel::hasAccess('type-index')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        // $types = Pharma::ownResults($type);
        $types = ProductType::where('status','Active')->orderBy('id','desc')->get();
        return view('pharma.types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Sentinel::hasAccess('type-create')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        return view('pharma.types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,ProductType $product_type)
    {
        if (!Sentinel::hasAccess('type-create')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $this->validateForm($request);
        $product_type->create($request->merge([
            'type_name'       => $request->type_name,
            'description'   => $request->description,
            'slug'          => Pharma::getUniqueSlug($product_type,$request->type_name),
            'user_id'       => Sentinel::getUser()->id,
            'created_at'    => now(),
        ])->all());

        Session::flash('success','type Added Succeed!');
        Pharma::activities("Added", "type", "Added a New type");
        return redirect('products/product_type');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pharma\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function show(ProductType $product_type)
    {
        if (!Sentinel::hasAccess('type-show')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        Pharma::ownItems($product_type);
        return view('pharma.types.show', compact('product_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pharma\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductType $product_type)
    {
        if (!Sentinel::hasAccess('type-edit')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        Pharma::ownItems($product_type);
        return view('pharma.types.edit', compact('product_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pharma\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductType $product_type)
    {
        if (!Sentinel::hasAccess('type-edit')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $this->validateForm($request);
        $product_type->update($request->merge([
            'type_name'       => $request->type_name,
            'description'   => $request->description,
            'slug'          => Pharma::getUniqueSlug($product_type,$request->type_name),
            'updated_at'    => now(),
        ])->all());

        Session::flash('success','type Updated Succeed!');
        Pharma::activities("Update", "type", "Updated type");
        return redirect('products/product_type');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pharma\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductType $product_type)
    {
        if (!Sentinel::hasAccess('type-destroy')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $product_type->delete();
        Session::flash('success','type Deleted Succeed!');
        Pharma::activities("Deleted", "type", "Deleted type");
        return redirect('products/product_type');
    }

    private function validateForm($request){
    $validatedData = $request->validate([
        'type_name' => 'required',
    ]);
    }
}
