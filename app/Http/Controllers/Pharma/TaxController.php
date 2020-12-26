<?php

namespace App\Http\Controllers\Pharma;
use App\Http\Controllers\Controller;
use App\Models\Pharma\Tax;
use App\Expense;
use App\BankAccount;
use Illuminate\Http\Request;
use Sentinel;
use Session;
use Pharma;
use DB;

class taxController extends Controller{

    public function __construct(){
        $this->middleware(['authorized','pharma']);
    }
    
    public function index(Request $request){
        if (!Sentinel::hasAccess('tax-index')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $search = [
            'start' => '-',
            'end'   => '-',
        ];

        $tax = new Tax;
        $paidList = new Expense;
        if($request->has('start') && $request->start != '-'){
            $tax = $tax->where('date','>=',$request->start);
            $paidList = $paidList->where('date','>=',$request->start);
            $search['start'] = $request->start;
        }
        if($request->has('end') && $request->end != '-'){
            $tax = $tax->where('date','<=',$request->end);
            $paidList = $paidList->where('date','<=',$request->end);
            $search['end'] = $request->end;
        }
        $taxes = $tax->where('status','Active')->orderBy('id','DESC')->get();
        $total = Tax::where('status','Active')->sum('amount');
        $paid = Expense::where('status','Active')->where('expense_category_id',1)->sum('amount');
        $due = $total-$paid;
        $paidList = $paidList->where('status','Active')->where('expense_category_id',1)->get();

        return view('pharma.taxes.account.index',compact('taxes','search','total','paid','due','paidList'));
    }

    public function payment(){
        if (!Sentinel::hasAccess('tax-pay')) { Session::flash('error','Permission Denied!');return redirect()->back();}
        $total = Tax::where('status','Active')->sum('amount');
        $paid = Expense::where('status','Active')->where('expense_category_id',1)->sum('amount');
        $due = $total-$paid;
        $bankAccounts = BankAccount::all();
        return view('pharma.taxes.account.pay',compact('due','bankAccounts'));
    }
}
