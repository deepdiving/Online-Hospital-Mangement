<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Support\Facades\DB;
use App\ExpenseCategory;
use App\BankAccount;
use Illuminate\Http\Request;
Use Sentinel;
use Pharma;
use Session;

class ExpenseController extends Controller
{
    public function __construct(){
        $this->middleware('authorized');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Expense $expense){
        // $expenses = Pharma::ownResults($expense);
        if(Sentinel::getUser()->inRole('admin')){
            $expenses = Expense::where('status','Active')->orderBy('id','DESC')->with('category')->get();
        }else{
            $module = Pharma::getModule();
            $expenses = Expense::where('module',$module)->orderBy('id','DESC')->where('status','Active')->with('category')->get();
        }
        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $eCategories = ExpenseCategory::all();
        $bankAccounts = BankAccount::all();
        return view('expenses.create',compact('eCategories','bankAccounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Expense $expense){
        $this->validateForm($request);
        if($request->payment_type == 'bank'){
            $bank_transaction_id = $this->makeBankTransaction($request);
        }else{
            $bank_transaction_id = 0;
        }
        $data = [
            'date'                  => date('Y-m-d', strtotime($request->date)),
            'description'           => $request->description,
            'expense_category_id'   => $request->expense_category_id,
            'amount'                => $request->amount,
            'payment_type'          => $request->payment_type,
            'bank_transaction_id'   => $bank_transaction_id,
            'module'                => Pharma::getModule(),
            'user_id'               => Sentinel::getUser()->id,
            'created_at'            => now(),
        ];
        // dd($data);
        $expense->create($request->merge($data)->all());
        Pharma::makePayment($data);
        Session::flash('success','expense Added Succeed!');
        Pharma::activities("Added", "expense", "Added a New expense");
        return redirect('expense/');
    }

    private function makeBankTransaction($request){
        $bank_transection = [
            'date'              =>  date('Y-m-d', strtotime($request->date)),
            'bank_account_id'   => $request->bank_account_id,
            'trnsactionId'      => Pharma::GenarateInvoiceNumber('bank_transections',session()->get('settings')[0]['bank_transaction_prefix']),
            'transection_type'  => 'Credit',
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
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense){
        //Pharma::ownItems($expense);
        $expense = Expense::where('status','Active')->get();
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense){
        Pharma::ownItems($expense);
        return view('expenses.edit', compact('expense'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense){
        $this->validateForm($request);
        $expense->update($request->merge([
            'name'       => $request->name,
            'description'   => $request->description,
            'slug'          => Pharma::getUniqueSlug($expense,$request->name),
            'updated_at'    => now(),
        ])->all());

        Session::flash('success','expense Updated Succeed!');
        Pharma::activities("Update", "expense", "Updated expense");
        return redirect('products/expense');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense){
        $expense->delete();
        Session::flash('success','expense Deleted Succeed!');
        Pharma::activities("Deleted", "expense", "Deleted expense");
        return redirect('expense');
    }

    private function validateForm($request){
        $validatedData = $request->validate([
            'date' => 'required',
            'expense_category_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'payment_type' => 'required',
        ]);
    }

     public function void($id){
        $expences = Expense::where('id', $id)->first();
        $expences->status = "Void";
        $expences->save();

        DB::table('transations')->where('id', $expences->trans_id)->update(['status' => 'void']);
        
        Pharma::activities("Voided", "Expences", "Voided Expences with ".$expences['paidAmount']);
        Session::flash('success', 'Expences Void Succeed!'); 
        return redirect('expense');
    }

    public function voided(Expense $expense){
      $expences = Expense::where('status','void')->get();
      return view('expenses.voidList',compact('expences'));
    }










    //Expense Category

    public function indexExpenseCategory(ExpenseCategory $expenseCategory){
        $expenseCategorys = Pharma::ownResults($expenseCategory);
        return view('expenses.categories.index', compact('expenseCategorys'));
    
    }

    public function createExpenseCategory(){

        return view('expenses.categories.create');
    }

    public function storeExpenseCategory(ExpenseCategory $expenseCategory,Request $request){
        $validatedData = $request->validate([
            'category_name' => 'required',
        ]);
        $expenseCategory->create($request->merge([
            'category_name' => $request->category_name,
            'slug'          => Pharma::getUniqueSlug($expenseCategory,$request->category_name),
            'user_id'       => Sentinel::getUser()->id,
            'created_at'    => now(),
        ])->all());

        Session::flash('success',' add Expense category Succeed!');
        Pharma::activities("add", "Expense category", "add a category");
        return redirect('expenses/category');
    }

    public function editExpenseCategory($slug){
        $expenseCategory = ExpenseCategory::where('slug',$slug)->first();
        // dd($expenseCategory);
        return view('expenses.categories.edit',compact('expenseCategory'));
    }

    public function updateExpenseCategory(ExpenseCategory $expenseCategory,Request $request){
        $validatedData = $request->validate([
            'category_name' => 'required',
        ]);
        // dd($expenseCategory);
        $expenseCategory->where('slug',$request->slug)->update([
            'category_name' => $request->category_name,
            'slug'          => Pharma::getUniqueSlug($expenseCategory,$request->category_name),
            'user_id'       => Sentinel::getUser()->id,
            'created_at'    => now()
        ]);

        Session::flash('success',' Edit Expense category Succeed!');
        Pharma::activities("edit", "Expense category", "Edit a category");
        return redirect('expenses/category');
    }

   
}
