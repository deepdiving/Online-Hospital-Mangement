<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Transation;
use Illuminate\Http\Request;
Use App\Patient;
Use App\Models\Pharma\Manufacturer;
use App\BankAccount;
Use Sentinel;
use Pharma;
use Session;

class TransationController extends Controller
{

    public function __construct(){
        $this->middleware('authorized');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transation $transaction,Request $request){
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
            $module = Pharma::getModule();
            $trans    = $trans->where('module',$module);
        }
        $transactions = $trans->with(['patient','manufacturer','expenseCat','referral'])->where('status','Active')->orderBy('id','DESC')->get();
        // dd($transactions);
        return view('transations.index', compact('transactions','search'));
    }


    public function makepayment(){
        $vendor = 'Manufacturer';
        $transaction_type = 'Payment';
        $customers = '';
        $manufacturers = Manufacturer::all();
        $bankAccounts = BankAccount::all();
        return view('transations.create',compact('vendor','transaction_type','customers','manufacturers','bankAccounts'));
    }

    public function receivedpayment(){
        $vendor = 'Patient';
        $transaction_type = 'Collection';
        $customers = Patient::where('id','!=',1)->get();
        $manufacturers = '';
        $bankAccounts = BankAccount::all();
        return view('transations.create',compact('vendor','transaction_type','customers','manufacturers','bankAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Transation $transaction){
        // dd($request->all());
        $this->validateForm($request);

        if($request->transaction_way == 'bank'){
            $bank_transaction_id = $this->makeBankTransaction($request);
        }else{
            $bank_transaction_id = 0;
        }

        $transaction->create($request->merge([
            'date'                  =>  date('Y-m-d', strtotime($request->date)),
            'trans_id'              => Pharma::GenarateInvoiceNumber('transations',session()->get('settings')[0]['transaction_prefix']),
            'amount'                => $request->amount,
            'description'           => $request->description,
            'transaction_way'       => $request->transaction_way,
            'bank_transaction_id'   => $bank_transaction_id,
            'transaction_type'      => $request->transaction_type,
            'vendor_id'             => $request->vendor_id,
            'vendor'                => $request->vendor,
            'module'                => Pharma::getModule(),
            'user_id'               => Sentinel::getUser()->id,
            'created_at'            => now(),
        ])->all());

        Session::flash('success','transaction Added Succeed!');
        Pharma::activities("Added", "transaction", "Added a New transaction amount ".$request->amount);
        return redirect('accounts/transaction');
    }

    private function makeBankTransaction($request){
        $bank_transection = [
            'date'              =>  date('Y-m-d', strtotime($request->date)),
            'bank_account_id'   => $request->bank_account_id,
            'trnsactionId'      => Pharma::GenarateInvoiceNumber('bank_transections',session()->get('settings')[0]['bank_transaction_prefix']),
            'transection_type'  => ($request->transaction_type == 'Payment') ? 'Credit' : 'Debit',
            'checkOrslip_no'    => $request->checkOrslip_no,
            'amount'            => $request->amount,
            // 'description'       => $request->description,
            'created_at'        => now(),
        ];
        return DB::table('bank_transections')->insertGetId($bank_transection);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transation  $transation
     * @return \Illuminate\Http\Response
     */
    public function show(Transation $transation){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transation  $transation
     * @return \Illuminate\Http\Response
     */
    public function edit(Transation $transation){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transation  $transation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transation $transation){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transation  $transation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transation $transation){
        //
    }

    private function validateForm($request){
        $validatedData = $request->validate([
            'date'                  => 'required',
            'amount'                => 'numeric|required',
            // 'description'           => 'required',
            'transaction_way'       => 'required',
            // 'bank_transaction_id'   => 'required',
            'vendor_id'             => 'numeric|required',
            'vendor'                => 'required',
            'transaction_type'      => 'required',
        ]);
    }
}