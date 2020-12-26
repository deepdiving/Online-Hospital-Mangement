<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\Transaction;
use Illuminate\Http\Request;
Use Sentinel;
use Pharma;
use Session;
use DB;
class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct(){
    //     $this->middleware('authorized');
    // }

    public function index(BankAccount $bankaccount)
    {
        if (!Sentinel::hasAccess('bankaccount-index')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $bankaccounts = Pharma::ownResults($bankaccount);
        return view('bank_accounts.index', compact('bankaccounts'));
    }

    public function indexTransaction()
    {
        if (!Sentinel::hasAccess('bankTransaction-index')) { Session::flash('error','Permission Denied!');return redirect()->back();}

        $bankTransaction = DB::table('bank_transections')->orderBy('id','DESC')->get();
        return view('bank_accounts.bank_transactions.index', compact('bankTransaction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Sentinel::hasAccess('bankaccount-create')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        return view('bank_accounts.create');
    }
    public function createTransaction(BankAccount $bankaccount)
    {
        if (!Sentinel::hasAccess('bankTransaction-create')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $bankaccounts = Pharma::ownResults($bankaccount);
        return view('bank_accounts.bank_transactions.create',compact('bankaccounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,BankAccount $bankaccount)
    {
        // dd($request->all());
        if (!Sentinel::hasAccess('bankaccount-create')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $this->validateForm($request);
        $bankaccount->create($request->merge([
            'bank_name'     =>$request->bank_name,
            'account_number'=>$request->account_no,
            'account_name'  =>$request->account_name,
            'branch_name'   =>$request->branch_name,
            'balance'       =>$request->balance,
            'user_id'       => Sentinel::getUser()->id,
            'created_at'    => now(),

        ])->all());

        Session::flash('success','Bank Account Added Succeed!');
        Pharma::activities("Added", "bank account", "Added a New bank account");
        return redirect('/bankaccount');
    }
    public function storeTransaction(Request $request)
    {   
        // dd($request->all());
        if (!Sentinel::hasAccess('bankTransaction-create')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $request->validate([
            'bank_account_id' => 'required',
            'transection_type' => 'required',
            'checkOrslip_no' => 'required',
            'amount' => 'numeric|required',
        ]);
        
        $transection = [
            'date'              => date('Y-m-d', strtotime($request->date)),
            'bank_account_id'   => $request->bank_account_id,
            'trnsactionId'      => Pharma::GenarateInvoiceNumber('bank_transections',session()->get('settings')[0]['bank_transaction_prefix']),
            'transection_type'  => $request->transection_type,
            'checkOrslip_no'    => $request->checkOrslip_no,
            'amount'            => $request->amount,
            'description'       => $request->description,
            'user_id'           => Sentinel::getUser()->id,
            'created_at'        => now(),
        ];
        DB::table('bank_transections')->insert($transection);
        Session::flash('success','New Transaction Succeed!');
        Pharma::activities("Added", "Bank Transaction", "Added a New bank transection");
        return redirect('/bankaccount/transaction');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\bank  $bankaccount
     * @return \Illuminate\Http\Response
     */
    public function edit(BankAccount $bankaccount)
    {
        if (!Sentinel::hasAccess('bankaccount-edit')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        Pharma::ownItems($bankaccount);
        // dd($bankaccount);
        return view('bank_accounts.edit', compact('bankaccount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\bank  $bankaccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankAccount $bankaccount)
    {
        if (!Sentinel::hasAccess('bankaccount-edit')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $this->validateForm($request);
        $bankaccount->update($request->merge([
            'bank_name'     =>$request->bank_name,
            'account_number'    =>$request->account_no,
            'account_name'  =>$request->account_name,
            'branch_name'   =>$request->branch_name,
            // 'balance'       =>$request->balance,
            'created_at'    => now(),
        ])->all());

        Session::flash('success','Bank Account Updated Succeed!');
        Pharma::activities("Update", "bank", "Updated bank");
        return redirect('/bankaccount');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\bank  $bankaccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankAccount $bankaccount)
    {
        // if (!Sentinel::hasAccess('bankaccount-destroy')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        // $bankaccount->delete();
        // // Session::flash('success','bank Deleted Succeed!');
        // // Pharma::activities("Deleted", "bank", "Deleted bank");
        // // return redirect('products/bank');
    }
    private function validateForm($request){
        $validatedData = $request->validate([
            'bank_name'     =>'required',
            'account_no'    =>'required',
            'account_name'  =>'required',
            'branch_name'   =>'required',
        ]);
        }
}
