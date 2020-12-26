<?php

namespace App\Http\Controllers\Pharma;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Pharma\Purchase;
use App\Models\Pharma\Batch;
use App\Models\Pharma\ProductType;
use App\Transation;
use App\Models\Pharma\Manufacturer;
use App\Models\Pharma\Category;
use App\Models\Pharma\ProductTax;
use App\Models\Pharma\Product;
use Sentinel;
use Session;
use Pharma;
use PDF;
use App\SiteSetting;

class PurchaseController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(['authorized','pharma']);
    }

    public function index(Purchase $purchase){
        $purchase = Pharma::ownResults($purchase);
        $purchase = Purchase::where('status', 'Active')->orderBy('id','DESC')->get();
        $voided   = Purchase::where('status', 'void')->get();
        return view('pharma.purchases.index', compact('purchase', 'voided'));
    }

    public function voided(Purchase $purchase){
        $purchase = Pharma::ownResults($purchase);
        $voided   = Purchase::where('status', 'void')->get();
        return view('pharma.purchases.voided', compact('voided'));
    }

    public function create(){
        $tax = ProductTax::all();
        $product = Product::all();
        $manufacturer = Manufacturer::all();
        $invoice = Pharma::GenarateInvoiceNumber('pharma_purchases', session()->get('settings')[0]['purchase_prefix']);
        return view('pharma.purchases.create', compact('manufacturer', 'product', 'invoice'));
    }

    public function store(Request $request, Purchase $purchase){
        // DB::beginTransaction();
        // try {
            $invoice = strtoupper(Pharma::getUniqueSlug($purchase, $request->invoice));
            $dataItems = [];
            $purchaseData = [
                'date'              => date('Y-m-d', strtotime($request->date)),
                'slug'              => $invoice,
                'invoice'           => $invoice,
                'description'       => $request->description,
                'discount'          => $request->total_discount,
                'manufacturer_id'   => $request->manufacturer_id,
                'purchase_amount'   => $request->purchase_amount,
                'tax_percent'       => $request->tax_percent,
                'grand_total'       => $request->grand_total,
                'discount'          => $request->discount,
                'payable_amount'    => $request->payable_amount,
                'user_id'           => Sentinel::getUser()->id,
                'created_at'        => now(),
            ];
            $purchase = $purchase->create($request->merge($purchaseData)->all());
            $purchaseItems = $this->addPurchaseItems($request, $purchase->id);
            if(isset($request->isPayment)){
                $trans = $this->makePayment($request,$invoice);
                $purchase->trans_id = $trans->id;
                $purchase->save();
            }
            // DB::commit();
            Session::flash('success', 'purchase Added Succeed!');
            Pharma::activities("Added", "purchase", "Added a New purchase");
            // return redirect('purchase/invoice/'.$invoice);
            if(session()->get('settings')[0]['voucher_type'] == 'A4'){
                return redirect('purchase/invoice/a4/' . $invoice);
            }else if(session()->get('settings')[0]['voucher_type'] == 'POS'){
                return redirect('purchase/invoice/pos/' . $invoice);
            }
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     Session::flash('warning', 'Purchase Add NOT Succeed!');
        //     return redirect('purchase');
        // }
    }

    private function addPurchaseItems($request, $purchaseId){
        $purchase_items = [];
        for ($i = 0; $i < count($request->product_id); $i++) {
            $batch_number = Pharma::GenarateInvoiceNumber('pharma_batches', session()->get('settings')[0]['batch_prefix']);
            $purchaseItem = [
                'manufacturer_id'   => $request->manufacturer_id,
                'purchase_id'       => $purchaseId,
                'product_id'        => $request->product_id[$i],
                'qty'               => $request->qty[$i],
                'unit_price'        => $request->unit_price[$i],
                'total_price'       => $request->qty[$i] * $request->unit_price[$i],
                'was_stock'         => $request->was_stock[$i],
                'new_stock'         => $request->was_stock[$i] + $request->qty[$i],
                'created_at'        => now(),
            ];
            $purchase_item_id = DB::table('pharma_purchase_items')->insertGetId($purchaseItem);
            $purchase_items[] = [
                'product_id'        => $request->product_id[$i],
                'qty'               => $request->qty[$i],
                'unit_price'        => $request->unit_price[$i],
                'total_price'       => $request->qty[$i] * $request->unit_price[$i],
                'was_stock'         => $request->was_stock[$i],
                'new_stock'         => $request->was_stock[$i] + $request->qty[$i],
                'purchase_item_id'  => $purchase_item_id,
                'batch_number'      => $batch_number,
                'expiry_date'       => date('Y-m-d', strtotime($request->expiry_date[$i])),
            ];
            $batchData = [
                'product_id'        => $request->product_id[$i],
                'purchase_id'       => $purchaseId,
                'purchase_item_id'  => $purchase_item_id,
                'batch_number'      => $batch_number,
                'in_stock'          => $request->qty[$i],
                'expiry_date'       => date('Y-m-d', strtotime($request->expiry_date[$i])),
                'created_at'        => now(),
            ];
            DB::table('pharma_batches')->insert($batchData);
            Pharma::StockIncrement('pharma_products', 'stock', $request->product_id[$i], $request->qty[$i]);
        }
        return $purchase_items;
    }

    private function makePayment($request,$invoice){
        $transaction = new Transation;
        $url = url('purchase/invoice/'.$invoice);
        $trans = $transaction->create($request->merge([
            'date'                  =>  date('Y-m-d', strtotime($request->date)),
            'trans_id'              => Pharma::GenarateInvoiceNumber('transations',session()->get('settings')[0]['transaction_prefix']),
            'amount'                => $request->payable_amount,
            'description'           => "Make Payment on Purchase <a target='_blank' href='{$url}'>{$invoice}</a>",
            'transaction_type'      => 'Payment',
            'vendor_id'             => $request->manufacturer_id,
            'vendor'                => 'Manufacturer',
            'user_id'               => Sentinel::getUser()->id,
            'created_at'            => now(),
        ])->all());
        return $trans;
    }

    private function validateForm($request)
    {
        $validatedData = $request->validate([
            // 'name' => 'required',
        ]);
    }


    public function void($slug){
        $purchase = Purchase::where('slug', $slug)->first();
        DB::beginTransaction();
        try {
            $items = DB::table('pharma_purchase_items')->where('purchase_id', $purchase->id)->get();
            foreach ($items as $item) {
                DB::table('pharma_products')->where('id', $item->product_id)->decrement('stock', $item->qty);
                DB::table('pharma_purchase_items')->where('id', $item->id)->update(['status' => 'void']);
                DB::table('pharma_batches')->where('purchase_id', $purchase->id)->update(['status' => 'void']);
                DB::table('transations')->where('id', $purchase->trans_id)->update(['status' => 'void']);
            }
            DB::table('pharma_purchases')->where('id', $purchase->id)->update(['status' => 'void']);
            DB::commit();
            Session::flash('success', 'purchase Void Succeed!');
            Pharma::activities("Voided", "purchase", "voided purchase");
            return redirect('purchase');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('warning', 'Purchase Add NOT Succeed!');
            return redirect('purchase');
        }
    }

    public function restore($slug){
        DB::beginTransaction();
        try {
            $purchase = Purchase::where('slug', $slug)->first();
            $items = DB::table('pharma_purchase_items')->where('purchase_id', $purchase->id)->get();
            foreach ($items as $item) {
                DB::table('pharma_products')->where('id', $item->product_id)->increment('stock', $item->qty);
                DB::table('pharma_purchase_items')->where('id', $item->id)->update(['status' => 'Active']);
                DB::table('pharma_batches')->where('purchase_id', $purchase->id)->update(['status' => 'Active']);
                DB::table('transations')->where('id', $purchase->trans_id)->update(['status' => 'Active']);
            }
            DB::table('pharma_purchases')->where('id', $purchase->id)->update(['status' => 'Active']);
            DB::commit();
            Session::flash('success', 'purchase Active Succeed!');
            Pharma::activities("Actived", "purchase", "Restored purchase");
            return redirect('purchase');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('warning', 'Purchase Add NOT Succeed!');
            return redirect('purchase');
        }
    }

    public function printPurchaseInvoiceA4($invoiceNumber)
    {
        $purchase = Purchase::with(['purchaseItems', 'manufacturer'])->where('invoice', $invoiceNumber)->first();
        $siteInfo = SiteSetting::find(1);
        return view('pharma.invoices.purchaseCurrentInvoiceA4', compact('purchase', 'siteInfo'));
    }
    public function printPurchaseInvoicePos($invoiceNumber)
    {
        $purchase = Purchase::with(['purchaseItems', 'manufacturer'])->where('invoice', $invoiceNumber)->first();
        $siteInfo = SiteSetting::find(1);
        return view('pharma.invoices.purchaseCurrentInvoicePos', compact('purchase', 'siteInfo'));
    }
}
