<?php

namespace App\Http\Controllers\Pharma;
use App\Http\Controllers\Controller;

use App\Models\Pharma\Product;
use App\Models\Pharma\Category;
use App\Models\Pharma\ProductType;
use App\Models\Pharma\ProductTax;
use App\Models\Pharma\Batch;
use App\Models\Pharma\PurchaseItem;
use App\Models\Pharma\Manufacturer;
use App\Models\Pharma\Unit;
use App\Models\Pharma\SaleItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Session;
use Pharma;
use Sentinel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware(['authorized','pharma']);
    }

    public function index(Product $product)
    {
        if (!Sentinel::hasAccess('product-index')) {Session::flash('error', 'Permission Denied!');return redirect()->back();}
        $products = Product::orderBY('id','DESC')->get();//Pharma::ownResults($product);
        return view('pharma.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Sentinel::hasAccess('product-create')) {
            Session::flash('error', 'Permission Denied!');
            return redirect()->back();
        }
        $categories     = Category::all()->where('status', 'Active');
        $units          = Unit::all()->where('status', 'Active');
        $types          = ProductType::all()->where('status', 'Active');
        $taxes          = ProductTax::all()->where('status', 'Active');
        $manufacturers  = Manufacturer::all()->where('status', 'Active');
        return view('pharma.products.create', compact('categories', 'units', 'types', 'taxes', 'manufacturers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        if (!Sentinel::hasAccess('product-create')) {
            Session::flash('error', 'Permission Denied!');
            return redirect()->back();
        }
        $this->validateForm($request);
        $slug = Pharma::getUniqueSlug($product, $request->title);
        $product->create($request->merge([
            'title'             => $request->title,
            'slug'              => $slug,
            'generic_name'      => $request->generic_name,
            'note'              => $request->note,
            'box_size'          => $request->box_size,
            'shelf_no'          => $request->shelf_no,
            'purchase_price'    => $request->purchase_price,
            'sale_price'        => $request->sale_price,
            'manufacturer_id'   => $request->manufacturer_id,
            'category_id'       => $request->category_id,
            'unit_id'           => $request->unit_id,
            'product_type_id'   => $request->type_id,
            'image'             => $request->hasfile('medicine_image') ? $request->medicine_image->storeAs('public/medicines', $slug . '.' . $request->medicine_image->getClientOriginalExtension()) : '',
            'user_id'           => Sentinel::getUser()->id,
            'created_at'        => now(),
        ])->all());

        Session::flash('success', 'Product Added Succeed!');
        Pharma::activities("Added", "product", "Added a New Product");
        return redirect('products/product');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pharma\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if (!Sentinel::hasAccess('product-show')) {Session::flash('error', 'Permission Denied!');return redirect()->back();}
        // Pharma::ownItems($product);
        $product = $product->load('unit', 'category', 'type', 'manufacturer');
        $batches = Batch::where('product_id', $product->id)->where('status', 'Active')->get();
        $purchaseItems = PurchaseItem::where('product_id', $product->id)->where('status', 'Active')->get();
        $saleItems = SaleItems::where('product_id', $product->id)->where('status', 'Active')->get();
        // dd($saleItems);
        return view('pharma.products.show', compact('product', 'batches', 'purchaseItems', 'saleItems'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pharma\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if (!Sentinel::hasAccess('product-edit')) {
            Session::flash('error', 'Permission Denied!');
            return redirect()->back();
        }
        // Pharma::ownItems($product);
        $product = $product->load('unit', 'category', 'type');
        $categories = Category::all()->where('status', 'Active');
        $units      = Unit::all()->where('status', 'Active');
        $types      = ProductType::all()->where('status', 'Active');
        $manufacturers  = Manufacturer::all()->where('status', 'Active');
        return view('pharma.products.edit', compact('product', 'categories', 'units', 'types', 'manufacturers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pharma\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if (!Sentinel::hasAccess('product-edit')) {
            Session::flash('error', 'Permission Denied!');
            return redirect()->back();
        }
        $this->validateForm($request);

        $slug = Pharma::getUniqueSlug($product, $request->title);
        if ($request->hasfile('medicine_image')) {
            $path = $request->medicine_image->storeAs('public/medicines', $slug . '.' . $request->medicine_image->getClientOriginalExtension());
            Storage::delete($request->old_img);
        } else {
            $path = $request->old_img;
        }

        $product->update($request->merge([
            'title'             => $request->title,
            'slug'              => $slug,
            'generic_name'      => $request->generic_name,
            'note'              => $request->note,
            'box_size'          => $request->box_size,
            'shelf_no'          => $request->shelf_no,
            'purchase_price'    => $request->purchase_price,
            'manufacturer_id'   => $request->manufacturer_id,
            'sale_price'        => $request->sale_price,
            'category_id'       => $request->category_id,
            'unit_id'           => $request->unit_id,
            'product_type_id'   => $request->type_id,
            'image'             => $path,
            'user_id'           => Sentinel::getUser()->id,
            'updated_at'        => now(),
        ])->all());

        Session::flash('success', 'product Updated Succeed!');
        Pharma::activities("Update", "product", "Updated product");
        return redirect('products/product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pharma\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (!Sentinel::hasAccess('product-destroy')) {
            Session::flash('error', 'Permission Denied!');
            return redirect()->back();
        }
        Storage::delete($product->image);
        $product->delete();
        Session::flash('success', 'product Deleted Succeed!');
        Pharma::activities("Deleted", "product", "Deleted product");
        return redirect('products/product');
    }
    private function validateForm($request)
    {
        $validatedData = $request->validate([
            'title'             => 'required',
            'generic_name'      => 'required',
            // 'note'              => 'required',
            'box_size'          => 'required|numeric',
            'image'             => 'sometimes|nullable|image',
            'purchase_price'    => 'required|numeric',
            'sale_price'        => 'required|numeric',
            // 'shelf_no'          => 'required',
            'manufacturer_id'   => 'required|numeric',
            'category_id'       => 'required|numeric',
            'unit_id'           => 'required|numeric',
            'type_id'           => 'required|numeric',
        ]);
    }

    public function barcode(Request $request, Product $product){
        // dd($product->batch);
        $data = [];
        if(!empty($request)){
            foreach($product->batch as $batch){
                $key = $batch->batch_number;
                $data[$key] = $request->$key;
            }
        }
        return view('pharma.products.barcode',compact('product','data'));
    }
}
