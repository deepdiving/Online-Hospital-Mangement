<?php

namespace App\Http\Controllers\Pharma;
use App\Http\Controllers\Controller;

use App\Models\Pharma\Sale;
use App\Patient;
use App\Models\Pharma\Product;
use App\Models\Pharma\SaleItems;
use App\Models\Pharma\Batch;
use App\SiteSetting;
use App\Models\Pharma\Tax;
use Illuminate\Http\Request;
use Sentinel;
use Session;
use Pharma;
use DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware(['authorized','pharma']);
        // \Debugbar::disable();

    }

    public function index(Sale $sale){
        if (!Sentinel::hasAccess('sale-index')) {
            $sale       = Pharma::ownResults($sale);
        }else{
            $sale       = Sale::where('status', 'Active')->orderBy('id','DESC')->get();
        }
        
        $voided     = Sale::where('status', 'void')->get();
        return view('pharma.sales.index', compact('sale', 'voided'));
    }
    public function voided(Sale $sale){
        if (!Sentinel::hasAccess('sale-index')) {Session::flash('error', 'Permission Denied!');return redirect()->back();}
        $sale       = Pharma::ownResults($sale);
        $voided   = Sale::where('status', 'void')->get();
        return view('pharma.sales.voided', compact('voided'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        if (!Sentinel::hasAccess('sale-create')) {Session::flash('error', 'Permission Denied!');return redirect()->back();}
        $invoice = Pharma::GenarateInvoiceNumber('pharma_sales',session()->get('settings')[0]['sale_prefix']);
        $products = Product::all();
        $customers = Patient::all();
        return view('pharma.sales.create', compact('customers', 'products', 'invoice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Sale $sale, Patient $customer){
        // dd($request->all());
        if (!Sentinel::hasAccess('sale-create')) {Session::flash('error', 'Permission Denied!');return redirect()->back();}
        // DB::beginTransaction();
        // try {
        $customerId = $this->getCustomer($request);
        $result = $this->dataCalculation($request, $customerId);
        $invoice = Pharma::GenarateInvoiceNumber('pharma_sales',session()->get('settings')[0]['sale_prefix']);
        $saleData = [
            'date'              => date('Y-m-d', strtotime($request->date)),
            'invoice'           => $invoice,
            'slug'              => $invoice,
            'description'       => $request->description,
            'sub_total'         => $result['sub_total'],
            'invoice_discount'  => (!empty($request->invoice_discount))? $request->invoice_discount :0,
            'total_discount'    => $result['total_discount'],
            'tax_percent'       => !empty($request->tax_percent)?$request->tax_percent:0,
            'total_tax'         => $result['tax_amount'],
            'grand_total'       => $result['grand_total'],
            'paid_amount'       => $result['paid_amount'],
            'new_balance'       => $result['new_balance'],
            'change'            => $result['change'],
            'user_id'           => Sentinel::getUser()->id,
            'patient_id'       => $customerId,
            'status'            => 'Active',
            'created_at'        => now()
        ];
        $sale = $sale->create($saleData);
        $saleItems = $this->addSaleItems($request, $customerId, $sale->id);
        $this->addTax($sale->id,$request->date,$invoice, $result['tax_amount']);
        if($result['paid_amount'] > 0){
            $trans = Pharma::receivedPayment($saleData);
            $sale->trans_id = $trans->id;
            $sale->save();
        }
        // DB::commit();
        Session::flash('success', 'Sale Added Succeed!');
        Pharma::activities("Added", "sale", "Added a New sale");
        if($request->save == 'savePrint'){
            // return redirect('sale/invoice/' . $invoice.'?print');

            if(session()->get('settings')[0]['voucher_type'] == 'A4'){
                return redirect('sale/invoice/a4/' . $invoice.'?print');
            }else if(session()->get('settings')[0]['voucher_type'] == 'POS'){
                return redirect('sale/invoice/pos/' . $invoice.'?print');
            }
        }
        return redirect('sale/create/');
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     Session::flash('warning', 'sale NOT Succeed!');
        //     return redirect('sale');
        // }
    }

    private function addSaleItems($request, $customerId, $saleId){
        $salesItems = [];
        $saleItemModel = new SaleItems;
        for ($i = 0; $i < count($request->product_id); $i++) {
            $saleItem  = [
                'patient_id'       => $customerId,
                'sale_id'           => $saleId,
                'product_id'        => $request->product_id[$i],
                'batch_id'          => $request->batch_id[$i],
                'current_stock'     => $request->current_stock[$i],
                'expiry_date'       => $request->expiry_date[$i],
                'sale_qty'          => $request->sale_qty[$i],
                'unit_price'        => $request->unit_price[$i],
                'discount_percent'  => !empty($request->discount_percent[$i])?$request->discount_percent[$i]:0,
                'discount_amount'   => $request->discount_amount[$i],
                'total_price'       => $request->total_price[$i],
                'new_stock'         => $request->current_stock[$i] - $request->sale_qty[$i],
                'status'            => 'Active',
            ];
            $saleItemModel->create($saleItem);
            Pharma::StockIncrement('pharma_products', 'stock', $saleItem['product_id'], $saleItem['sale_qty']);
            Pharma::StockIncrement('pharma_batches', 'in_stock', $saleItem['batch_id'], $saleItem['sale_qty']);
            $salesItems[] = $saleItem;
        }
        return $salesItems;
    }

    private function addTax($id,$date,$saleInvoice,$amount){
        $tax = new Tax;
        $tax->create([
            'date'          => date('Y-m-d', strtotime($date)),
            'sale_id'       => $id,
            'sale_invoice'  => $saleInvoice,
            'amount'        => $amount,
            'user_id'       => Sentinel::getUser()->id,
            'created_at'    => now()
        ]);
    }

    private function dataCalculation($request, $customerId){
        $result = [];
        $result['sub_total']          = array_sum($request->total_price);
        $result['discount_amount']    = array_sum($request->discount_amount);
        $result['total_discount']     = $result['discount_amount'] + $request->invoice_discount;
        $result['after_discount']     = $result['sub_total'] - $request->invoice_discount;
        $result['tax_amount']         = $result['after_discount'] * $request->tax_percent / 100;
        $result['grand_total']        = $result['after_discount'] + $result['tax_amount'];
        // $result['net_total']          = $result['grand_total'] + $request->pre_balance;

        if ($result['grand_total'] <= $request->paid_amount) {
            $result['new_balance']    = 0;
            $result['change']         = $request->paid_amount - $result['grand_total'];
            $result['paid_amount']    = $result['grand_total'];
            // DB::table('pharma_customers')->where('id', $customerId)->update(['customer_balance' => 0]);
        } else {
            $result['new_balance']    = $result['grand_total'] - $request->paid_amount;
            $result['change']         = 0;
            $result['paid_amount']    = $request->paid_amount;
            // DB::table('pharma_customers')->where('id', $customerId)->update(['customer_balance' => $result['new_balance']]);
        }
        // dd($result);
        return $result;
    }

    private function getCustomer($request){
        $customer = new Patient;
        if (isset($request->patient_id)) {
            return $request->patient_id;
        } else {
            $new_customer = $customer->create([
                'patient_name'     => $request->patient_name,
                'phone'             => $request->customer_phone,
                'address'           => $request->customer_address,
                'slug'              => Pharma::GenaratePatientSlug(),
                'user_id'           => Sentinel::getUser()->id,
                'created_at'        => now(),
            ]);
            return $new_customer->id;
        }
    }

    public function saleInvoice($invoiceNumber){
        $sale = Sale::where('invoice', $invoiceNumber)->first();
        return view('pharma.invoices.saleInvoice', compact('sale'));
    }

    public function findProduct($batch_number){
        $products = Product::all();
        $batch = Batch::where('batch_number', $batch_number)->first();
        if(!empty($batch)){
            if($batch->expiry_date >= date('Y-m-d')){
                $results = Batch::with('product')->where('batch_number', $batch_number)->first();
                $productOption = Pharma::GetOptions($products, 'title', $results->product_id);
                $batchData = Batch::where('product_id', $results->product_id)->get();
                $batchOption = Pharma::GetOptions($batchData, 'batch_number', $batch->id);

                $info = [
                    'expiry_date'   =>  $batch->expiry_date,
                    'in_stock'      =>  $batch->in_stock,
                    'mrp'           =>  $results->product->sale_price,
                    'batch_id'      =>  $batch->id,
                ];
                $arr = [
                    'status'        => 'OK',
                    'result'        => $info,
                    'productOption' => $productOption,
                    'batchOption'   => $batchOption,
                ];
                echo json_encode($arr);
            }else{
                echo json_encode(['status'=>'Expired']);
            }
        }else{
            echo json_encode(['status'=>'NOT OK']);
        }
    }

    public function void($slug){
        DB::beginTransaction();
        try {
            $sale = Sale::where('slug', $slug)->first();
            $items = DB::table('pharma_sale_items')->where('sale_id', $sale->id)->get();
            foreach ($items as $item) {
                DB::table('pharma_products')->where('id', $item->product_id)->increment('stock', $item->sale_qty);
                DB::table('pharma_sale_items')->where('id', $item->id)->update(['status' => 'void']);
                DB::table('pharma_batches')->where('id', $sale->batch_id)->increment('in_stock', $item->sale_qty);
            }
            DB::table('pharma_sales')->where('id', $sale->id)->update(['status' => 'void']);
            DB::table('pharma_taxes')->where('sale_id', $sale->id)->update(['status' => 'void']);
            DB::table('transations')->where('id', $sale->trans_id)->update(['status' => 'void']);
            DB::commit();
            Session::flash('success', 'Sale Void Succeed!');
            Pharma::activities("Voided", "Sales", "voided Sale");
            return redirect('sale/voided');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('warning', 'Void NOT Succeed!');
            return redirect('sale');
        }
    }

    public function restore($slug){
        DB::beginTransaction();
        try {
            $sale = Sale::where('slug', $slug)->first();
            $items = DB::table('pharma_sale_items')->where('sale_id', $sale->id)->get();
            foreach ($items as $item) {
                DB::table('pharma_products')->where('id', $item->product_id)->decrement('stock', $item->sale_qty);
                DB::table('pharma_sale_items')->where('id', $item->id)->update(['status' => 'Active']);
                DB::table('pharma_batches')->where('id', $sale->batch_id)->decrement('in_stock', $item->sale_qty);
            }
            DB::table('pharma_sales')->where('id', $sale->id)->update(['status' => 'Active']);
            DB::table('pharma_taxes')->where('sale_id', $sale->id)->update(['status' => 'Active']);
            DB::table('transations')->where('id', $sale->trans_id)->update(['status' => 'Active']);
            DB::commit();
            Session::flash('success', 'Sale Active Succeed!');
            Pharma::activities("Actived", "sale", "Restored sale");
            return redirect('sale');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('warning', 'Restore NOT Succeed!');
            return redirect('sale');
        }
    }
   
    public function printSaleInvoiceA4($invoiceNumber){
        $sale = Sale::with(['saleItems.product', 'patient'])->where('invoice', $invoiceNumber)->first();
        $siteInfo = SiteSetting::find(1);
        return view('pharma.invoices.saleCurrentInvoiceA4', compact('sale', 'siteInfo'));
    }
    public function printSaleInvoicePos($invoiceNumber){
        $sale = Sale::with(['saleItems.product', 'patient'])->where('invoice', $invoiceNumber)->first();
        $siteInfo = SiteSetting::find(1);
        return view('pharma.invoices.saleCurrentInvoicePos', compact('sale', 'siteInfo'));
    }
   
}
