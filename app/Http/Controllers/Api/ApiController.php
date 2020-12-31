<?php

namespace App\Http\Controllers\Api;
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

class ApiController extends Controller{

    // public function admin_today(Request $request){
    //     return response()->json(['hello' => 'sdf'], 201); 
    // }
    public function admin_today(Request $request){
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
        $data['totalDues'] = $totalDues;
        $data['totalDuesCollection'] = $totalDueColection;

        return response()->json(['error' => false,'data'=>$data,'message'=>'data fatch successfully'], 201);
        // dd($data);
        // return view('reports.adminToday',compact('data','totalDues','totalDueColection'));
    }

    public function user_trans(Request $request){
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
        // $users = User::all();
        $user_trans = $data['user_tranaction'] = $userTransaction->where('status','Active')->get();
        $data['users'] = User::all();
        return response()->json(['error' => false,'data'=>$data,'message'=>'data fatch successfully'], 201);
        // return view('reports.userwiseTransaction',compact('siteInfo','data','user_trans','users'));
    }

    public function cashFlow(Request $request){
        $data = [
            'start' => '-',
            'end'   => '-',
            'type'  => 'All',
        ];
        $trans    = New Transation;
        if($request->has('start') && $request->start != '-'){
            $trans    = $trans->where('date','>=',$request->start);
            $data['start'] = $request->start;
        }
        if($request->has('end') && $request->end != '-'){
            $trans    = $trans->where('date','<=',$request->end);
            $data['end'] = $request->end;
        }
        if($request->has('type') && $request->type != 'All'){
            $trans    = $trans->where('transaction_type',$request->type);
            $data['type'] = $request->type;
        }
        // if(!Sentinel::getUser()->inRole('admin')){
        //     $trans = $trans->where('module',Pharma::getModule());
        // }
        $data['transactions'] = $trans->with(['patient','manufacturer','expenseCat'])->where('status','Active')->orderBy('id','DESC')->get();

        return response()->json(['error' => false,'data'=>$data,'message'=>'data fatch successfully'], 201);
        // return view('reports.cashFlowReport', compact('transactions','search'));        
    }

}