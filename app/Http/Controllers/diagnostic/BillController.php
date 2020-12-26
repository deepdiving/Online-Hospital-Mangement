<?php

namespace App\Http\Controllers\diagnostic;

use App\Http\Controllers\Controller;
use App\Patient;
use App\Models\diagnostic\Bill;
use App\Models\diagnostic\BillItem;
use Illuminate\Http\Request;
use App\Referral;
use App\Models\diagnostic\DiagonTestCategory;
use App\Models\diagnostic\DiagonTestList;
use App\Models\doctor\Prescription;
use App\Transation;
use App\Expense;
use Sentinel;
use Session;
use Pharma;
use DB;
class BillController extends Controller
{

    // public function __construct(){
    //     $this->middleware(['authorized','diagnostic']);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $bills = Bill::with('referral')->where('status','active')->get();
        return view('diagnostic.bills.index',compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $refarences = Referral::all();
        $tests = DiagonTestList::orderBy('count','DESC')->get();
        $testCategories = DiagonTestCategory::all();
        $TotalBillAmount = Bill::where('status','Active')->sum('grand_total');
        $TotalDue = Bill::where('status','Active')->sum('due');
        $TotalExpense = Expense::where('module','Diagnostic')->sum('amount');
        $TodayBillCount = Bill::where('status','Active')->where('date','>=',date('Y-m-d'))->where('date','<=',date('Y-m-d'))->count();
        return view('diagnostic.bills.create',compact('refarences','tests','testCategories','TotalBillAmount','TotalDue','TotalExpense','TodayBillCount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Bill $bill)
    {
        // dd($request->all());
        $patientId = $this->getPatient($request);
        $referral_id = $this->getReferral($request);
        $invoice = Pharma::GenarateInvoiceNumber('diagon_bills',session()->get('settings')[0]['prefix_diagnostic_bill']);
        $result = $this->dataCalculation($request);
        $data = [
            'date'              => date('Y-m-d'),
            'invoice'           => $invoice,
            'slug'              => $invoice,
            'delivary_date'     => $request->delivary_date,
            'delivary_time'     => $request->delivary_time,
            'description'       => $request->description,
            'sub_total'         => $result['sub_total'],
            'discount_percent'  => $request->discountPercent,
            'discount_overall'  => $request->discountOverall,
            'discount_total'    => $result['total_discount'],
            'grand_total'       => $result['grand_total'],
            'paid_amount'       => $result['paidAmount'],
            'actual_paid_amount'=> $result['actualPaidAmount'],
            'due'               => $result['due'],
            'change'            => $result['change'],
            'user_id'           => Sentinel::getUser()->id,
            'referral_id'       => $referral_id,
            'patient_id'        => $patientId,
            'created_at'        => now(),
        ];

        //dd($data);
        
        
        $testBill = $bill->create($data);
        $this->testItems($request,$testBill->id,$patientId);
        if($result['paidAmount'] > 0){
            $transId = $this->makeTransaction($invoice,$result,$patientId);
            $testBill->trans_id = $transId;
            $testBill->save();
        }

        Session::flash('success', 'Bill inserted!');
        Pharma::activities("Added", "Diagnostic Bill", "Added a New Diagnostic Bill with ".$result['paidAmount']);
        if(session()->get('settings')[0]['voucher_type'] == 'A4'){
            //A4 size print
            return redirect('diagnostic/bill/invoice/a4/' . $invoice);
        }else if(session()->get('settings')[0]['voucher_type'] == 'POS'){
        //pos size print
            return redirect('diagnostic/bill/invoice/pos/'.$invoice);
        }


    }
    private function testItems($request,$billId,$patientId){
        $bill_items = new BillItem;
        for ($i = 0; $i < count($request->test_items); $i++) {
            $items = [
                'date'          => date('Y-m-d'),
                'bill_id'       => $billId,
                'test_id'       => $request->test_items[$i],
                'test_price'    => $request->test_item_price[$i],
                'user_id'       => Sentinel::getUser()->id,
                'patient_id'    => $patientId,
            ];
            $bill_items->create($items);
        }
    }

    private function makeTransaction($invoice,$result,$patientId){
        $transaction = New Transation;
        $url = url('diagnostic/bill/invoice/a4/'.$invoice);
        $trans = $transaction->create([
            'date'                  => date('Y-m-d'),
            'trans_id'              => Pharma::GenarateInvoiceNumber('transations',session()->get('settings')[0]['transaction_prefix']),
            'amount'                => $result['paidAmount'],
            'description'           => "Received from diagnostic bill. <a target='_blank' href='{$url}'>{$invoice}</a>",
            'vendor_id'             => $patientId,
            'user_id'               => Sentinel::getUser()->id,
            'module'                => 'Diagnostic',
            'created_at'            => now(),
        ]);
        return $trans->id;
    }
    private function dataCalculation($request){
        $result = [];
        $result['sub_total']            = array_sum($request->test_item_price);
        $result['dis_percent_amount']   = $result['sub_total'] * $request->discountPercent / 100;
        $result['total_discount']      = ($result['dis_percent_amount'] + $request->discountOverall);
        $result['grand_total']          = $result['sub_total'] - $result['total_discount'];

        if ($result['grand_total'] <= $request->paidAmount) {
            $result['due']          = 0;
            $result['change']       = $request->paidAmount - $result['grand_total'];
            $result['paidAmount']   = $request->paidAmount;
            $result['actualPaidAmount']   = $result['grand_total'];
        } else {
            $result['due']          = $result['grand_total'] - $request->paidAmount;
            $result['change']       = 0;
            $result['paidAmount']   = $request->paidAmount;
            $result['actualPaidAmount']   = $request->paidAmount;
        }
        return $result;
    }
    private function getPatient($request){
        $patient = new Patient;
        if (isset($request->patient_id)) {
            return $request->patient_id;
        } else {
            $new_patient = $patient->create([
                'patient_name'      => $request->patient_name,
                'age'               => $request->age,
                'phone'             => $request->phone,
                'blood_group'       => $request->blood_group,
                'address'           => $request->address,
                'gender'            => $request->gender,
                'marital_status'    => $request->marital_status,
                'slug'              => Pharma::GenaratePatientSlug(),
                'user_id'           => Sentinel::getUser()->id,
                'created_at'        => now(),
            ]);
            return $new_patient->id;
        }
    }
    private function getReferral($request){
        $referral = new Referral;
        if (isset($request->ref_id)) {
            return $request->ref_id;
        } else {
            $new_referral = $referral->create([
                'name'          => $request->ref_name,
                'contact'       => $request->ref_contact,
                'designation'   => $request->ref_designation,
                'email'         => $request->ref_email,
                // 'user_id'           => Sentinel::getUser()->id,
                'created_at'    => now(),
            ]);
            return $new_referral->id;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\diagnostic\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill)
    {
        // echo 'jelho';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\diagnostic\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
        $refarences = Referral::all();
        $tests = DiagonTestList::orderBy('count','DESC')->get();
        $testCategories = DiagonTestCategory::all();
        $TotalBillAmount = Bill::where('status','Active')->sum('grand_total');
        $TotalDue = Bill::where('status','Active')->sum('due');
        $TotalExpense = Expense::where('module','Diagnostic')->sum('amount');
        $TodayBillCount = Bill::where('status','Active')->where('date','>=',date('Y-m-d'))->where('date','<=',date('Y-m-d'))->count();
        return view('diagnostic.bills.edit',compact('refarences','tests','testCategories','bill','TotalBillAmount','TotalDue','TotalExpense','TodayBillCount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\diagnostic\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
        // dd($request->all());
        $result = $this->dataCalculation($request);
        $data = [
            'invoice'           => $request->invoice,
            'delivary_date'     => $request->delivary_date,
            'delivary_time'     => $request->delivary_time,
            'description'       => $request->description,
            'sub_total'         => $result['sub_total'],
            'discount_percent'  => $request->discountPercent,
            'discount_overall'  => $request->discountOverall,
            'discount_total'    => $result['total_discount'],
            'grand_total'       => $result['grand_total'],
            'paid_amount'       => $result['paidAmount'],
            'due'               => $result['due'],
            'change'            => $result['change'],
            'updated_at'        => now(),
        ];

        $testBill = $bill->update($data);
        DB::table('diagon_bill_items')->where('bill_id',$request->id)->delete();
        $this->testItems($request,$request->id,$request->patient_id);
        
        if($request->trans_id != 0 ){
            $trans = New Transation;
            $trans = $trans->find($request->trans_id);
            $trans->amount = $result['paidAmount']; 
            $trans->save();
        }

        Session::flash('success', 'Bill Updated!');
        Pharma::activities("Updated", "Diagnostic Bill", "Updated Diagnostic Bill ".$request->invoice);
        if(session()->get('settings')[0]['voucher_type'] == 'A4'){
            //A4 size print
            return redirect('diagnostic/bill/invoice/a4/' . $request->invoice);
        }else if(session()->get('settings')[0]['voucher_type'] == 'POS'){
        //pos size print
            return redirect('diagnostic/bill/invoice/pos/'.$request->invoice);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\diagnostic\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        //
    }

    

    public function invoicePos($invoice){ 
        $invoicePrint = Bill::with(['patient','billItem.test'])->where('invoice',$invoice)->first();
        return view('diagnostic.invoice.invicePos',compact('invoicePrint'));
    }
    public function invoiceA4($invoice){
        $invoicePrint = Bill::with(['patient','billItem.test'])->where('invoice',$invoice)->first();
        return view('diagnostic.invoice.invoiceA4',compact('invoicePrint'));
    }

    public function voided(Bill $bill){
         $bills = Bill::where('status','void')->get();
         return view('diagnostic.bills.restoreVoided',compact('bills'));
    }

    public function void($slug){
        //echo $slug;
        $bill = Bill::where('slug', $slug)->first();
        $bill->update(['status' => 'void']);
       
        DB::table('transations')->where('id', $bill->trans_id)->update(['status' => 'void']);   

        Pharma::activities("Voided", "Diagnostic Bill", "Added a New Diagnostic Bill with ".$bill['paidAmount']);
        Session::flash('success', 'Bill Void Succeed!'); 
        return redirect('diagnostic/bill');
    }

    public function restore($slug){
         $bill = Bill::where('slug', $slug)->first();
        $bill->update(['status' => 'active']);
       
        DB::table('transations')->where('id', $bill->trans_id)->update(['status' => 'active']);   
        Pharma::activities("Restore", "Diagnostic Bill", "Added a New Diagnostic Bill with ".$bill['paidAmount']);

        Session::flash('success', 'Bill Restored Succeed!'); 
        return redirect('diagnostic/bill');
    }

    public function diagonPrescriptionList(){
        $presctiption = Prescription::where('status','Active')->where('date',date('Y-m-d'))->get();
        $allPrescription = Prescription::where('status','Active')->get();
        return view('diagnostic.prescriptionList',compact('presctiption','allPrescription'));
    }
}
