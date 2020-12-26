<?php

namespace App\Http\Controllers\Pharma;
use App\Http\Controllers\Controller;

use App\Models\Pharma\ProductTax;
use Illuminate\Http\Request;
Use Sentinel;
use Pharma;
use Session;
class ProductTaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware(['authorized','pharma']);
    }

    public function index(ProductTax $tax)
    {
        if (!Sentinel::hasAccess('tax-index')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        // $taxs = Pharma::ownResults($tax);
        $taxs = ProductTax::where('status','Active')->orderBy('id','desc')->get();
        return view('pharma.taxes.index', compact('taxs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Sentinel::hasAccess('tax-create')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        return view('pharma.taxes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,ProductTax $type)
    {
        if (!Sentinel::hasAccess('tax-create')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $this->validateForm($request);
        $type->create($request->merge([
            'tax_name'       => $request->tax_name,
            'description'   => $request->description,
            'tax_amount'   => $request->tax_amount,
            'slug'          => Pharma::getUniqueSlug($type,$request->tax_name),
            'user_id'       => Sentinel::getUser()->id,
            'created_at'    => now(),
        ])->all());

        Session::flash('success','tax Added Succeed!');
        Pharma::activities("Added", "tax", "Added a New tax");
        return redirect('products/tax');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show(ProductTax $tax)
    {
        if (!Sentinel::hasAccess('tax-show')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        Pharma::ownItems($tax);
        return view('pharma.taxes.show', compact('tax'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductTax $tax)
    {
        if (!Sentinel::hasAccess('tax-edit')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        Pharma::ownItems($tax);
        return view('pharma.taxes.edit', compact('tax'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductTax $tax)
    {
        if (!Sentinel::hasAccess('tax-edit')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $this->validateForm($request);
        $tax->update($request->merge([
            'tax_name'       => $request->tax_name,
            'tax_amount'     => $request->tax_amount,
            'description'   => $request->description,
            'slug'          => Pharma::getUniqueSlug($tax,$request->tax_name),
            'updated_at'    => now(),
        ])->all());

        Session::flash('success','tax Updated Succeed!');
        Pharma::activities("Update", "tax", "Updated tax");
        return redirect('products/tax');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductTax $tax)
    {
        if (!Sentinel::hasAccess('tax-destroy')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $tax->delete();
        Session::flash('success','tax Deleted Succeed!');
        Pharma::activities("Deleted", "tax", "Deleted tax");
        return redirect('products/tax');
    }
    private function validateForm($request){
        $validatedData = $request->validate([
            'tax_name' => 'required',
            'tax_amount' => 'required',
        ]);
        }
}
