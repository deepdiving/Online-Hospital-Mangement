<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Pharma\Sale;
use App\Models\Pharma\Purchase;
use App\Expense;
use App\Transation;
use App\SiteSetting;
use App\ExpenseCategory;
use App\Patient;
use App\Models\Pharma\Manufacturer;
use App\Models\Pharma\Product;
use App\Models\Pharma\Tax;
use Illuminate\Http\Request;
use App\Models\diagnostic\Bill;
use App\Models\diagnostic\DiagonReferral;
use App\Models\hospital\HmsAdmission;
use App\Models\hospital\HmsOperation;
use App\Models\hospital\HmsEmergency;
use App\Models\hospital\BedChargeCollection;
use App\Models\doctor\DocAppointment; 
use App\User;
use Sentinel;
use Session;
use Pharma;
use DB;

class ReportController extends Controller{

    public function __construct(){
        $this->middleware('authorized');
    }

    public function sales(Request $request){
        $search = [
            'start' => '-',
            'end'   => '-',
            'customer'  => 'All',
        ];
        $sale = New Sale;
        if($request->has('customer') && $request->customer != 'All'){
            $customer_id = Pharma::findIdBySlug('patients',$request->customer);
            $sale = $sale->where('patient_id',$customer_id);
            $search['customer'] = $request->customer;
        }
        if($request->has('start') && $request->start != '-'){
            $sale = $sale->where('date','>=',$request->start);
            $search['start'] = $request->start;
        }
        if($request->has('end') && $request->end != '-'){
            $sale = $sale->where('date','<=',$request->end);
            $search['end'] = $request->end;
        }
        $sales = $sale->with('patient')->where('status','Active')->orderBy('id','DESC')->get();


        $customers = Patient::where('status','Active')->get();
        return view('reports.salesReport',compact('sales','search','customers'));
    }

    public function salesReturn(Request $request){
        $search = [
            'start' => '-',
            'end'   => '-',
            'customer'  => 'All',
        ];
        $saleReturn = New SaleReturn;
        if($request->has('customer') && $request->customer != 'All'){
            $customer_id = Pharma::findIdBySlug('patients',$request->customer);
            $saleReturn = $saleReturn->where('patient_id',$customer_id);
            $search['customer'] = $request->customer;
        }
        if($request->has('start') && $request->start != '-'){
            $saleReturn = $saleReturn->where('date','>=',$request->start);
            $search['start'] = $request->start;
        }
        if($request->has('end') && $request->end != '-'){
            $saleReturn = $saleReturn->where('date','<=',$request->end);
            $search['end'] = $request->end;
        }
        $saleReturns = $saleReturn->with('sale.customer')->where('status','Active')->orderBy('id','DESC')->get();


        $customers = Patient::where('status','Active')->get();
        return view('reports.salesReturnReport',compact('saleReturns','search','customers'));
    }

    public function purchase(Request $request){
        $search = [
            'start' => '-',
            'end'   => '-',
            'manufacturer'  => 'All',
        ];

        $purchase = new Purchase;
        if($request->has('manufacturer') && $request->manufacturer != 'All'){
            $manufacturer_id = Pharma::findIdBySlug('pharma_manufacturers',$request->manufacturer);
            $purchase = $purchase->where('manufacturer_id',$manufacturer_id);
            $search['manufacturer'] = $request->manufacturer;
        }
        if($request->has('start') && $request->start != '-'){
            $purchase = $purchase->where('date','>=',$request->start);
            $search['start'] = $request->start;
        }
        if($request->has('end') && $request->end != '-'){
            $purchase = $purchase->where('date','<=',$request->end);
            $search['end'] = $request->end;
        }
        $purchases = $purchase->with('manufacturer')->where('status','Active')->orderBy('id','DESC')->get();

        $manufacturers = Manufacturer::where('status','Active')->get();
        return view('reports.purchaseReport',compact('purchases','search','manufacturers'));
    }

    public function purchaseReturn(Request $request){
        $search = [
            'start' => '-',
            'end'   => '-',
            'manufacturer'  => 'All',
        ];

        $purchaseReturn = new PurchaseReturn;
        if($request->has('manufacturer') && $request->manufacturer != 'All'){
            $manufacturer_id = Pharma::findIdBySlug('pharma_manufacturers',$request->manufacturer);
            $purchaseReturn = $purchaseReturn->where('manufacturer_id',$manufacturer_id);
            $search['manufacturer'] = $request->manufacturer;
        }
        if($request->has('start') && $request->start != '-'){
            $purchaseReturn = $purchaseReturn->where('date','>=',$request->start);
            $search['start'] = $request->start;
        }
        if($request->has('end') && $request->end != '-'){
            $purchaseReturn = $purchaseReturn->where('date','<=',$request->end);
            $search['end'] = $request->end;
        }
        $purchaseReturns = $purchaseReturn->with('purchase.manufacturer')->where('status','Active')->orderBy('id','DESC')->get();

        $manufacturers = Manufacturer::where('status','Active')->get();
        return view('reports.purchaseReturnReport',compact('purchaseReturns','search','manufacturers'));
    }
    
    public function expense(Request $request){
        $search = [
            'start' => '-',
            'end'   => '-',
            'category'  => 'All',
        ];

        $expenase = new Expense;
        if($request->has('category') && $request->category != 'All'){
            $expense_category_id = Pharma::findIdBySlug('expense_categories',$request->category);
            $expenase = $expenase->where('expense_category_id',$expense_category_id);
            $search['category'] = $request->category;
        }
        if($request->has('start') && $request->start != '-'){
            $expenase = $expenase->where('date','>=',$request->start);
            $search['start'] = $request->start;
        }
        if($request->has('end') && $request->end != '-'){
            $expenase = $expenase->where('date','<=',$request->end);
            $search['end'] = $request->end;
        }
        if(!Sentinel::getUser()->inRole('admin')){
            $expenses = $expenase->where('module',Pharma::getModule());
        }
        $expenses = $expenase->with('category')->where('status','Active')->orderBy('id','DESC')->get();

        $categories = ExpenseCategory::where('status','Active')->get();
        return view('reports.expenseReport',compact('expenses','search','categories'));
    }

    public function payment(Request $request){
        $search = [
            'start' => '-',
            'end'   => '-',
            'manufacturer'  => 'All',
        ];

        $payment = new Transation;
        if($request->has('manufacturer') && $request->manufacturer != 'All'){
            $manufacturer_id = Pharma::findIdBySlug('pharma_manufacturers',$request->manufacturer);
            $payment = $payment->where('vendor_id',$manufacturer_id);//->where('vendor','Manufacturer');
            $search['manufacturer'] = $request->manufacturer;
        }
        if($request->has('start') && $request->start != '-'){
            $payment = $payment->where('date','>=',$request->start);
            $search['start'] = $request->start;
        }
        if($request->has('end') && $request->end != '-'){
            $payment = $payment->where('date','<=',$request->end);
            $search['end'] = $request->end;
        }
        $payments = $payment->with('manufacturer')->where('status','Active')->where('vendor','Manufacturer')->orderBy('id','DESC')->get();

        $manufacturers = Manufacturer::where('status','Active')->get();
        return view('reports.paymentReport',compact('payments','search','manufacturers'));
    }

    public function received(Request $request){
        $search = [
            'start' => '-',
            'end'   => '-',
            'customer'  => 'All',
        ];

        $receive = new Transation;
        if($request->has('customer') && $request->customer != 'All'){
            $customer_id = Pharma::findIdBySlug('patients',$request->customer);
            $receive = $receive->where('vendor_id',$customer_id);//->where('vendor','customer');
            $search['customer'] = $request->customer;
        }
        if($request->has('start') && $request->start != '-'){
            $receive = $receive->where('date','>=',$request->start);
            $search['start'] = $request->start;
        }
        if($request->has('end') && $request->end != '-'){
            $receive = $receive->where('date','<=',$request->end);
            $search['end'] = $request->end;
        }
        $received = $receive->with('patient')->where('status','Active')->where('module','Pharmacy')->where('vendor','Patient')->orderBy('id','DESC')->get();

        $customers = Patient::where('status','Active')->get();
        return view('reports.receivedReport',compact('received','search','customers'));
    }

    public function profit_Loss_saleWise(Request $request){
        $sales = Sale::with(['saleItems','saleItems.product','saleItems.product.purchaseItems'])->where('status','Active')->get();
        // foreach($sales->saleItems as $item){
        //     dd($item->product);
        // }
        return view('reports.p&l.saleWise',compact('sales'));
    }

    public function profit_Loss_itemWise(Request $request){
        $filter = function ($query) {
            $query->where('status','Active');
         };
        $products = Product::whereHas('saleItems',$filter)->with(['purchaseItems','saleItems','unit'])->where('status','Active')->get();
        return view('reports.p&l.itemWise',compact('products'));

    }

    public function incomeStatement(Request $request){
        $data = $this->getStatement($request);
        $siteInfo = (object)session()->get('settings')[0];
        return view('reports.incomeStatementReport',compact('data','siteInfo'));
    }
    public function today(Request $request){
        $data = $this->getStatement($request);
        $siteInfo = (object)session()->get('settings')[0];
        return view('reports.incomeStatementReport',compact('data','siteInfo'));
    }

    private function getStatement($request){
        $data = [
            'start' => date('-'),
            'end'   => date('-'),
        ];
        $sale               = New Sale;
        $dues               = New Sale;

        $dues_collection    = New Transation;
        $payment            = New Transation;
        $expense            = New Expense;
        if($request->has('start') && $request->start != '-'){
            $sale               = $sale->where('date','>=',$request->start);
            $dues               = $dues->where('date','>=',$request->start);
            $dues_collection    = $dues_collection->where('date','>=',$request->start);
            $payment            = $payment->where('date','>=',$request->start);
            $expense            = $expense->where('date','>=',$request->start);
            $data['start']      = $request->start;
        }
        if($request->has('end') && $request->end != '-'){
            $sale               = $sale->where('date','<=',$request->end);
            $dues               = $dues->where('date','<=',$request->end);
            $dues_collection    = $dues_collection->where('date','<=',$request->end);
            $payment            = $payment->where('date','<=',$request->end);
            $expense            = $expense->where('date','<=',$request->end);
            $data['end']        = $request->end;
        }

        $data['sale_revenue']       = $sale->where('status','Active')->sum('paid_amount');
        $data['dues']               = $dues->where('status','Active')->sum('new_balance');
        $data['due_collection']     = $dues_collection->where('status','Active')->where('vendor','Patient')->where('transaction_type','Collection')->sum('amount');
        $data['supplier_payment']   = $payment->where('status','Active')->where('vendor','Manufacturer')->where('transaction_type','Payment')->sum('amount');
        $data['expense']            = $expense->with('category')->select(DB::raw('sum(amount) as amount,expense_category_id'))->where('status','Active')->groupBy('expense_category_id')->get();
        return $data;
    }

    public function cashFlow(Request $request){
        $search = [
            'start' => '-',
            'end'   => '-',
            'type'  => 'All',
        ];
        $trans    = New Transation;
        if($request->has('start') && $request->start != '-'){
            $trans    = $trans->where('date','>=',$request->start);
            $search['start'] = $request->start;
        }
        if($request->has('end') && $request->end != '-'){
            $trans    = $trans->where('date','<=',$request->end);
            $search['end'] = $request->end;
        }
        if($request->has('type') && $request->type != 'All'){
            $trans    = $trans->where('transaction_type',$request->type);
            $search['type'] = $request->type;
        }
        if(!Sentinel::getUser()->inRole('admin')){
            $trans = $trans->where('module',Pharma::getModule());
        }
        $transactions = $trans->with(['patient','manufacturer','expenseCat'])->where('status','Active')->orderBy('id','DESC')->get();
        return view('reports.cashFlowReport', compact('transactions','search'));
        // if (!empty($request->all())){
            
        //     if($request->type != 'All'){
        //         $transactions = Transation::where('date','>',$request->start)->where('date','<',$request->end)->where('transaction_type',$request->type)->get();
        //     }else{
        //         $transactions = Transation::where('date','>',$request->start)->where('date','<',$request->end)->get();
        //     }
        //     if($request->start == '--'){
        //         $transactions = Transation::where('transaction_type',$request->type)->get();
        //     }
        //     $search = [
        //         'start' => $request->start,
        //         'end'   => $request->end,
        //         'type'  => $request->type,
        //     ];
        // }else{
        //     $transactions = Pharma::ownResults($transaction);
        // }
        
    }

    public function diagon_today(Request $request){
        $siteInfo = (object)session()->get('settings')[0];
        $data = [
            'start' => date('-'),
            'end'   => date('-'),
        ];
        $bill               = New Bill;
        $dues               = New Bill;
        $appontmetn         = New DocAppointment;

        $dues_collection    = New Transation;
        $payment            = New Transation;
        $docPayment         = New Transation;
        $expense            = New Expense;
        if($request->has('start') && $request->start != '-'){
            $bill               = $bill->where('date','>=',$request->start);
            $appontmetn         = $appontmetn->where('date','>=',$request->start);
            $dues               = $dues->where('date','>=',$request->start);
            $dues_collection    = $dues_collection->where('date','>=',$request->start);
            $payment            = $payment->where('date','>=',$request->start);
            $docPayment         = $docPayment->where('date','>=',$request->start);
            $expense            = $expense->where('date','>=',$request->start);
            $data['start']      = $request->start;
        }
        if($request->has('end') && $request->end != '-'){
            $bill               = $bill->where('date','<=',$request->end);
            $appontmetn         = $appontmetn->where('date','<=',$request->end);
            $dues               = $dues->where('date','<=',$request->end);
            $dues_collection    = $dues_collection->where('date','<=',$request->end);
            $payment            = $payment->where('date','<=',$request->end);
            $docPayment         = $docPayment->where('date','<=',$request->end);
            $expense            = $expense->where('date','<=',$request->end);
            $data['end']        = $request->end;
        }

        $data['bill_revenue']       = $bill->where('status','Active')->sum('paid_amount');
        $data['appoint_revenue']    = $appontmetn->where('status','Paid')->sum('net_fees');
        $data['dues']               = $dues->where('status','Active')->sum('due');
        $data['due_collection']     = $dues_collection->where('module','Diagnostic')->where('status','Active')->where('vendor','Patient')->where('transaction_type','Collection')->sum('amount');
        $data['referral_payment']   = $payment->where('status','Active')->where('vendor','Referral')->where('transaction_type','Payment')->sum('amount');
        $data['doctor_payment']     = $docPayment->where('status','Active')->where('vendor','Doctor')->where('transaction_type','Payment')->sum('amount');  
        $data['expense']            = $expense->with('category')->select(DB::raw('sum(amount) as amount,expense_category_id'))->where('module','Diagnostic')->where('status','Active')->groupBy('expense_category_id')->get();

        return view('reports.diagon-incomeStatementReport',compact('data','siteInfo'));
    }

    public function hodpital_today(Request $request){
        $siteInfo = (object)session()->get('settings')[0];
        $data = [
            'start' => date('-'),
            'end'   => date('-'),
        ];

        $admission = $admission_dues = New HmsAdmission;
        $operation = $operation_dues = New HmsOperation;
        $emergency = $emergency_dues = New HmsEmergency;
        $dues_collection = $bedservice = $payment  = New Transation;
        $expense            = New Expense;

        if($request->has('start') && $request->start != '-'){
            $admission          = $admission->where('date','>=',$request->start);
            $admission_dues     = $admission_dues->where('date','>=',$request->start);
            
            $operation          = $operation->where('date','>=',$request->start);
            $operation_dues     = $operation_dues->where('date','>=',$request->start);
            
            $emergency          = $emergency->where('date','>=',$request->start);
            $emergency_dues     = $emergency_dues->where('date','>=',$request->start);

            $dues_collection    = $dues_collection->where('date','>=',$request->start);
            $bedservice         = $bedservice->where('date','>=',$request->start);
            $payment            = $payment->where('date','>=',$request->start);
            $expense            = $expense->where('date','>=',$request->start);
            $data['start']      = $request->start;
        }
        if($request->has('end') && $request->end != '-'){
            $admission          = $admission->where('date','<=',$request->end);
            $admission_dues     = $admission_dues->where('date','<=',$request->end);

            $operation          = $operation->where('date','<=',$request->end);
            $operation_dues     = $operation_dues->where('date','<=',$request->end);
            
            $emergency          = $emergency->where('date','<=',$request->end);
            $emergency_dues     = $emergency_dues->where('date','<=',$request->end);

            $dues_collection    = $dues_collection->where('date','<=',$request->end);
            $bedservice         = $bedservice->where('date','<=',$request->end);
            $payment            = $payment->where('date','<=',$request->end);
            $expense            = $expense->where('date','<=',$request->end);
            $data['end']        = $request->end;
        }

        $data['admission_revenue']  = $admission->where('status','Active')->sum('paid_amount');
        $data['admission_dues']     = $admission_dues->where('status','Active')->sum('due');

        $data['operation_revenue']  = $operation->where('status','Active')->sum('paid_amount');
        $data['operation_dues']     = $operation_dues->where('status','Active')->sum('due');

        $data['emergency_revenue']  = $emergency->where('status','Active')->sum('paid_amount');
        $data['emergency_dues']     = $emergency_dues->where('status','Active')->sum('due');
        
        $data['due_collection']     = $dues_collection->where('module','Hospital')->where('status','Active')->where('vendor','Patient')->where('transaction_type','Collection')->sum('amount');
        $data['bedservice']         = $bedservice->where('module','Hospital')->where('sub_module','Hospital-BedChargeCollection')->where('status','Active')->where('vendor','Patient')->sum('amount');
        $data['referral_payment']   = $payment->where('status','Active')->where('vendor','Referral')->where('transaction_type','Payment')->sum('amount');
        $data['expense']            = $expense->with('category')->select(DB::raw('sum(amount) as amount,expense_category_id'))->where('module','Hospital')->where('status','Active')->groupBy('expense_category_id')->get();

        
        $patients = Patient::where('status','Active')->get();
        $bedChargeDue = 0;
        foreach($patients as $p){
            $bedChargeDue += Pharma::getBedChargeCollection($p->id);
        }
        $data['bedChargeDue']   = $bedChargeDue;

        $data['dues']               = $data['admission_dues'] + $data['operation_dues'] + $data['emergency_dues'] + $data['bedChargeDue'];
        return view('reports.hospital-incomeStatementReport',compact('data','siteInfo'));
    }

    public function admin_today(Request $request){
        $siteInfo = (object)session()->get('settings')[0];
        $data = [
            'start' => date('-'),
            'end'   => date('-'),
        ];

        //Revenue
        $bill          = New Bill;
        $appointment   = new DocAppointment;
        $admission     = new HmsAdmission;
        $emergency     = new HmsEmergency; 
        $operation     = new HmsOperation; 
        $sale          = new Sale; 
        $saleAmount    = new Sale;
        $bedservice    = new Transation;
        
        //Dues
        $diagonDues    = new Bill;
        $admissionDues = new HmsAdmission;
        $emergencyDues = new HmsEmergency; 
        $operatoinDues = new HmsOperation;
        $saleDues      = new Sale; 

        //Due Collection
        $diagonDuecoll  = new Bill;
        $addmissDuecoll = new HmsAdmission;
        $emerDuecoll    = new HmsEmergency;
        $operaDuecoll   = new HmsOperation;
        $saleDuecoll    = new Sale;

        //Payment
        $payment        = New Transation;
        $docPayment     = New Transation;

        //Expences
        $expense        = New Expense;

        //Date Wise Search
        if($request->has('start') && $request->start != '-'){
            $bill               = $bill->where('date','>=',$request->start);
            $appointment        = $appointment->where('date','>=',$request->start);
            $admission          = $admission->where('date','>=',$request->start);
            $emergency          = $emergency->where('date','>=',$request->start);
            $operation          = $operation->where('date','>=',$request->start);
            $sale               = $sale->where('date','>=',$request->start);
            $bedservice         = $bedservice->where('date','>=',$request->start);
            $diagonDues         = $diagonDues->where('date','>=',$request->start);
            $admissionDues      = $admissionDues->where('date','>=',$request->start);
            $emergencyDues      = $emergencyDues->where('date','>=',$request->start);
            $operatoinDues      = $operatoinDues->where('date','>=',$request->start);
            $saleDues           = $saleDues->where('date','>=',$request->start);
            $payment            = $payment->where('date','>=',$request->start);
            $docPayment         = $docPayment->where('date','>=',$request->start);
            $expense            = $expense->where('date','>=',$request->start);
            $diagonDuecoll      = $diagonDuecoll->where('date','>=',$request->start);
            $addmissDuecoll     = $addmissDuecoll->where('date','>=',$request->start);
            $emerDuecoll        = $emerDuecoll->where('date','>=',$request->start);
            $operaDuecoll       = $operaDuecoll->where('date','>=',$request->start);
            $saleDuecoll        = $saleDuecoll->where('date','>=',$request->start);
            $data['start']      = $request->start;
        }
        if($request->has('end') && $request->end != '-'){
            $bill               = $bill->where('date','<=',$request->start);
            $appointment        = $appointment->where('date','<=',$request->start);
            $admission          = $admission->where('date','<=',$request->start);
            $emergency          = $emergency->where('date','<=',$request->start);
            $operation          = $operation->where('date','<=',$request->start);
            $sale               = $sale->where('date','<=',$request->start);
            $bedservice         = $bedservice->where('date','<=',$request->start);
            $diagonDues         = $diagonDues->where('date','<=',$request->start);
            $admissionDues      = $admissionDues->where('date','<=',$request->start);
            $emergencyDues      = $emergencyDues->where('date','<=',$request->start);
            $operatoinDues      = $operatoinDues->where('date','<=',$request->start);
            $saleDues           = $saleDues->where('date','<=',$request->start);
            $payment            = $payment->where('date','<=',$request->start);
            $docPayment         = $docPayment->where('date','<=',$request->start);
            $expense            = $expense->where('date','<=',$request->start);
            $diagonDuecoll      = $diagonDuecoll->where('date','<=',$request->start);
            $addmissDuecoll     = $addmissDuecoll->where('date','<=',$request->start);
            $emerDuecoll        = $emerDuecoll->where('date','<=',$request->start);
            $operaDuecoll       = $operaDuecoll->where('date','<=',$request->start);
            $saleDuecoll        = $saleDuecoll->where('date','<=',$request->start);
            $data['end']        = $request->end;
        }
        

        //Revene query
        $data['diagon_ravenu']    = $bill->where('status','Active')->sum('paid_amount');
        $data['appoint_revenu']   = $appointment->where('status','Paid')->sum('net_fees');
        $data['admission_revenu'] = $admission->where('status','Active')->sum('paid_amount');
        $data['emergency_revenu'] = $emergency->where('status','Active')->sum('paid_amount');
        $data['operation_revenu'] = $operation->where('status','Active')->sum('paid_amount');
        $data['sale_revenu']      = $sale->where('status','Active')->sum('paid_amount');
        $data['bed_revenu']       = $bedservice->where('module','Hospital')->where('sub_module','Hospital-BedChargeCollection')->where('status','Active')->where('vendor','Patient')->sum('amount');

        
        //Dues Query
        $data['sale_amount'] = $saleDues->where('status','Active')->sum('grand_total'); //For sale dues

        //bed dues
        $patient   = patient::where('status','Active')->get();
        $bedCharge = 0;
        foreach($patient as $row){
            $bedCharge += Pharma::getBedChargeCollection($row->id); 
        }
        $data['bed_due'] = $bedCharge;

        $data['diagon_due']       =  $diagonDues->where('status','Active')->sum('due');
        $data['admission_due']    =  $admissionDues->where('status','Active')->sum('due');
        $data['emergen_due']      =  $emergencyDues->where('status','Active')->sum('due');
        $data['operation_due']    =  $operatoinDues->where('status','Active')->sum('due');
        $data['sale_due']         =  $data['sale_amount'] -  $data['sale_revenu'];
        
        $totalDues                = $data['diagon_due'] + $data['admission_due'] +  $data['emergen_due'] + $data['operation_due'] + $data['sale_due']+$data['bed_due'] ;

        //Due colleciton Query
        $data['diagon_colle']     = $diagonDues->where('status','Active')->sum('due_collection');
        $data['admission_colle']  = $addmissDuecoll->where('status','Active')->sum('due_collection');
        $data['emergency_colle']  = $emerDuecoll->where('status','Active')->sum('due_collection');
        $data['operation_colle']  = $operaDuecoll->where('status','Active')->sum('due_collection');
        $data['sale_colle']       = $saleDuecoll->where('status','Active')->sum('due_collection');
       
        $totalDueColection        = $data['diagon_colle'] + $data['admission_colle'] +  $data['emergency_colle'] + $data['operation_colle'] + $data['sale_colle'];

        //Payment Query
        $data['referral_payment']   = $payment->where('status','Active')->where('vendor','Referral')->where('transaction_type','Payment')->sum('amount');
        $data['doctor_payment']     = $docPayment->where('status','Active')->where('vendor','Doctor')->where('transaction_type','Payment')->sum('amount'); 

        //Expences Query
        $data['expense']            = $expense->with('category')->select(DB::raw('sum(amount) as amount,expense_category_id'))->where('status','Active')->groupBy('expense_category_id')->get();
       
        
        return view('reports.adminToday',compact('data','siteInfo','totalDues','totalDueColection'));
    }

    public function user_trans(Request $request){
        $siteInfo = (object)session()->get('settings')[0];
        $data = [
            'start' => date('-'),
            'end'   => date('-'),
            'user'  => 0, 
        ];

        $userTransaction = New Transation;

        if($request->has('start') && $request->start != '-'){
            $userTransaction    = $userTransaction->where('date','>=',$request->start); 
            $data['start']      = $request->start;
        }
        if($request->has('end') && $request->end != '-'){
            $userTransaction    = $userTransaction->where('date','<=',$request->start); 
            $data['end']        = $request->end;
        }
        if($request->has('user') && $request->user != 0){
            $userTransaction     = $userTransaction->where('user_id',$request->user); 
            $data['user']        = $request->user;
        }
        $users = User::all();
        $user_trans = $data['user_tranaction'] = $userTransaction->where('status','Active')->get();
        return view('reports.userwiseTransaction',compact('siteInfo','data','user_trans','users'));
    }


    public function todayDelivaryReport(){
        $bills = Bill::with('referral')->where('delivary_date',date("Y-m-d"))->get();
        return view('reports.todayReport',compact('bills'));
    }

    public function todayAdmissionReport(){
        $admissions = HmsAdmission::with('referral')->where('status','active')->where('admit_date',date("Y-m-d"))->get();
        return view('reports.todayAdmission',compact('admissions'));
    }
}
