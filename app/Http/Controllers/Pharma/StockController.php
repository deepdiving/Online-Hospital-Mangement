<?php

namespace App\Http\Controllers\Pharma;
use App\Http\Controllers\Controller;
use App\Models\Pharma\Product;
use App\Models\Pharma\Batch;
use App\Models\Pharma\Manufacturer;
use App\Models\Pharma\Category;
use App\Models\Pharma\Unit;
use Illuminate\Http\Request;
Use Sentinel;
use Pharma;
use Session;

class StockController extends Controller{
    public function __construct(){
        $this->middleware(['authorized','pharma']);
    }
    
    public function lowstock(){
        $lqty = Pharma::getLowQty();
        $products = Product::with(['manufacturer','unit','category'])
                        ->where('stock','<=',$lqty)
                        ->where('status','Active')
                        ->orderBy('stock','ASC')
                        ->get();
        return view('pharma.stocks/lowQty',compact('products'));
    }
    
    public function closingStock(Request $request){
        $search = [
            'manufacturer' => "All",
            'unit' => "All",
            'category' => "All",
        ];

        $product = new Product;
        if($request->has('manufacturer') && $request->manufacturer != 'All'){
            $manufacturer_id = Pharma::findIdBySlug('pharma_manufacturers',$request->manufacturer);
            $product =  $product->where('manufacturer_id',$manufacturer_id);
            $search['manufacturer'] = $request->manufacturer;
        }
        if($request->has('unit') && $request->unit != 'All'){
            $unit_id = Pharma::findIdBySlug('pharma_units',$request->unit);
            $product =  $product->where('unit_id',$unit_id);
            $search['unit'] = $request->unit;
        }
        if($request->has('category') && $request->category != 'All'){
            $category_id = Pharma::findIdBySlug('pharma_categories',$request->category);
            $product =  $product->where('category_id',$category_id);
            $search['category'] = $request->category;
        }

        $products = $product->with(['manufacturer','unit','category'])->orderBy('id','DESC')->get();
        $manufacturers = Manufacturer::where('status','Active')->get();
        $categories = Category::where('status','Active')->get();
        $units = Unit::where('status','Active')->get();
        return view('pharma.stocks/closingStock',compact('products','manufacturers','search','categories','units'));
    }
    public function expiry(Request $request){
        $expiry = $request->expiry;
        if($expiry == 'expired'){
            $ExpMedicines = Batch::with(['product.unit','product.manufacturer','product.category'])
                                ->where('expiry_date','<=',date('Y-m-d'))
                                ->where('status','Active')
                                ->where('in_stock','!=','0')
                                ->orderBy('expiry_date','ASC')
                                ->get();
        }else{
            $epiryDate = Pharma::getUpcomingDate();
            $ExpMedicines = Batch::with(['product.unit','product.manufacturer','product.category'])
                                ->where('expiry_date','>=',date('Y-m-d'))
                                ->where('expiry_date','<=',$epiryDate)
                                ->where('status','Active')
                                ->where('in_stock','!=','0')
                                ->orderBy('expiry_date','ASC')
                                ->get();
        }
        return view('pharma.stocks/expiry',compact('ExpMedicines','expiry'));
    }

    public function batchStock(){
        $products = Product::with(['batch','unit'])->where('status','Active')->orderBy('id','DESC')->get();
        $batchwithZero = Batch::where('in_stock',0)->where('status','Active')->count();
        return view('pharma.stocks/batch',compact('products','batchwithZero'));
    }

    public function batchStockRefresh(){
        Batch::where('in_stock',0)->delete();
        Session::flash('success', 'Batch stock has been refresh');
        Pharma::activities("deleted", "Batch", "Batch stock refresh");
        return redirect('stocks/batch');
    }
}
