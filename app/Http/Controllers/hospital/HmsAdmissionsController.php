<?php

namespace App\Http\Controllers\hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Patient;
use App\Referral;
use App\Models\diagnostic\DiagonTestList;
use App\Models\diagnostic\DiagonTestCategory;
use App\Models\diagnostic\Bill; 
use App\Models\Pharma\Sale; 
use App\Models\hospital\HmsOperation;
use App\Models\hospital\HmsBed;
use App\Models\hospital\HmsServiceCategory;
use App\Models\hospital\HmsService;
use App\Models\hospital\HmsAdmission;
use App\Models\hospital\HmsEmergency;
use App\Models\hospital\HmsGivenService;
use App\Transation;

use App\Expense;
use Sentinel;
use Session;
use Pharma;
use DB;


class HmsAdmissionsController extends Controller
{

    public function __construct(){
        $this->middleware(['authorized','hospital']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admissions = HmsAdmission::with('patient','bed','referral')->where('status','Active')->orderBy('id','DESC')->get();
        return view('hospital.admission.index',compact('admissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $refarences = Referral::all();
        // $tests = DiagonTestList::orderBy('count','DESC')->get(); 
        $totalBillEmr = HmsEmergency::where('status','Active')->sum('grand_total');
        $totalBillAdm = HmsAdmission::where('status','Active')->sum('grand_total');
        $TotalBillAmount = abs($totalBillEmr+$totalBillAdm );
        $totalDueEmr = HmsEmergency::where('status','Active')->sum('due');
        $totalDueAdm = HmsAdmission::where('status','Active')->sum('due');
        $transAmount = Transation::where('status','Active')->where('transaction_type','collection')->where('module','Diagnostic')->sum('amount');
        $TotalDue = abs($totalDueAdm+$totalDueEmr-$transAmount);
        $TotalExpense = Expense::where('module','Hospital')->sum('amount');
        $TodayBillCount = HmsAdmission::where('status','Active')->where('date','>=',date('Y-m-d'))->where('date','<=',date('Y-m-d'))->count();
        $beds = HmsBed::where('patient',0)->get();
        $servicecategory = HmsServiceCategory::all();
        $service = HmsService::orderBy('id','ASC')->get();
        $serviceAdmission = HmsService::first(); 
        return view('hospital.admission.create',compact('serviceAdmission','refarences','servicecategory','service','TotalBillAmount','TotalDue','TotalExpense','TodayBillCount','beds'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,HmsBed $bed){
        // dd($request->all());
        $patientId  = $this->getPatient($request);
        $referralId = $this->getReferral($request);
        $invoice    = Pharma::GenarateInvoiceNumber('hms_admissions',session()->get('settings')[0]['prefix_hms_admission']);
        $result     = $this->dataCalculation($request);

        $data = [
            'date'              =>  date('Y-m-d'),
            'slug'              =>  $invoice,
            'invoice'           =>  $invoice,
            'admit_date'        =>  $request->admit_date,
            'admit_time'        =>  $request->admit_time,
            'sub_total'         =>  $result['sub_total'],
            'discount_percent'  =>  $request->discountPercent,
            'discount_overall'  =>  $request->discountOverall,
            'discount_total'    =>  $result['total_discount'],
            'grand_total'       =>  $result['grand_total'],
            'paid_amount'       =>  $result['paidAmount'],
            'actual_paid_amount'=>  $result['actualPaidAmount'],
            'due'               =>  $result['due'],
            'change'            =>  $result['change'],
            'remark'            =>  $request->remark,
            'bed_id'            =>  $request->bed_id,
            'patient_id'        =>  $patientId,
            'user_id'           =>  Sentinel::getUser()->id,
            'referral_id'       =>  $referralId,
            'crated_at'         =>  now()
        ]; 
        $admission = HmsAdmission::create($data);
        $this->addServices($admission->id,$request,$patientId);
        $bed = HmsBed::find($request->bed_id);
        $bed->patient = $patientId;
        $bed->updated_at = now();
        $bed->save();

        if($result['actualPaidAmount'] > 0){
            $transId = $this->makeTransaction($invoice,$result,$patientId);
            $admission->trans_id = $transId;
            $admission->save();
        }

        Session::flash('success', 'Admission Bill inserted!');
        Pharma::activities("Added", "New Admission", "Added a New Admission Bill with ".$result['actualPaidAmount']);
        if(session()->get('settings')[0]['voucher_type'] == 'A4'){
            //A4 size print
            return redirect('hospital/admission/invoice/a4/' . $invoice);
            // return redirect('hospital/admission');
        }else if(session()->get('settings')[0]['voucher_type'] == 'POS'){
            // return redirect('hospital/admission');
        //pos size print
            return redirect('hospital/admission/invoice/pos/'.$invoice);
        }
    }

    private function addServices($adId,$request,$patientId){
        $service_items = new HmsGivenService;
        for ($i = 0; $i < count($request->test_items); $i++) {
            $service = HmsService::find($request->test_items[$i]);
            $services = [
                'service_date'  => date('Y-m-d'),
                'admission_id'  => $adId,
                'service_id'    => $request->test_items[$i],
                'service_name'  => $service->name,
                'service_price' => $service->price,
                'user_id'       => Sentinel::getUser()->id,
                'patient_id'    => $patientId,
            ];
            $service_items->create($services);
        }
    }

    private function makeTransaction($invoice,$result,$patientId){
        $transaction = New Transation;
        $url = url('hospital/admission/invoice/a4/'.$invoice);
        $trans = $transaction->create([
            'date'                  => date('Y-m-d'),
            'trans_id'              => Pharma::GenarateInvoiceNumber('transations',session()->get('settings')[0]['transaction_prefix']),
            'amount'                => $result['actualPaidAmount'],
            'description'           => "Received from admission bill. <a target='_blank' href='{$url}'>{$invoice}</a>",
            'vendor_id'             => $patientId,
            'user_id'               => Sentinel::getUser()->id,
            'module'                => 'Hospital',
            'sub_module'            => 'Hospital-Admission',
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(HmsAdmission $admission){
        $given_service = $this->serviceArray($admission->id);
        $refarences = Referral::all();
        // $tests = DiagonTestList::orderBy('count','DESC')->get(); 
        $totalBillEmr = HmsEmergency::where('status','Active')->sum('grand_total');
        $totalBillAdm = HmsAdmission::where('status','Active')->sum('grand_total');
        $TotalBillAmount = abs($totalBillEmr+$totalBillAdm );
        $totalDueEmr = HmsEmergency::where('status','Active')->sum('due');
        $totalDueAdm = HmsAdmission::where('status','Active')->sum('due');
        $transAmount = Transation::where('status','Active')->where('transaction_type','collection')->where('module','Diagnostic')->sum('amount');
        $TotalDue = abs($totalDueAdm+$totalDueEmr-$transAmount);
        $TotalExpense = Expense::where('module','Hospital')->sum('amount');
        $TodayBillCount = HmsAdmission::where('status','Active')->where('date','>=',date('Y-m-d'))->where('date','<=',date('Y-m-d'))->count();
        // $beds = HmsBed::where('patient',0)->get();
        $servicecategory = HmsServiceCategory::all();
        $service = HmsService::orderBy('price','DESC')->get();
        $stayDay = Pharma::two_date_diff($admission->date,date('Y-m-d'));

        return view('hospital.admission.edit',compact('admission','given_service','servicecategory','stayDay','service','TotalBillAmount','TotalDue','TotalExpense','TodayBillCount','refarences'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HmsAdmission $admission){
        $result     = $this->dataCalculation($request);
        $data = [
            'sub_total'         =>  $result['sub_total'],
            'discount_percent'  =>  $request->discountPercent,
            'discount_overall'  =>  $request->discountOverall,
            'discount_total'    =>  $result['total_discount'],
            'grand_total'       =>  $result['grand_total'],
            'paid_amount'       =>  $result['paidAmount'],
            'actual_paid_amount'=>  $result['actualPaidAmount'],
            'change'            =>  $result['change'],
            'due'               =>  $result['due'],
            'remark'            =>  $request->remark,
        ]; 
        $admission->update($data);
        $this->batchUpdate($request,$admission->id);

        if($request->trans_id != 0 ){
            $trans = New Transation;
            $trans = $trans->find($request->trans_id);
            $trans->amount = $result['actualPaidAmount']; 
            $trans->save();
        }else{
            $transId = $this->makeTransaction($admission->invoice,$result,$admission->patient_id);
            $admission->trans_id = $transId;
            $admission->save();
        }

        // Pharma::StockIncrement('hms_admissions','due',$admission->id,$result['due']);
        Session::flash('success', 'Admission Bill Updated');
        Pharma::activities("Update", "New Admission", "Update a New Admission Bill with ".$result['actualPaidAmount']);
        if(session()->get('settings')[0]['voucher_type'] == 'A4'){
            //A4 size print
            return redirect('hospital/admission/invoice/a4/' . $admission->invoice);
            // return redirect('hospital/admission');
        }else if(session()->get('settings')[0]['voucher_type'] == 'POS'){
        //pos size print
            return redirect('hospital/admission/invoice/pos/'.$admission->invoice);
        }
    }

    private function serviceArray($adId){
        $givenService = HmsGivenService::where('admission_id',$adId)->select('service_id')->get()->toArray();
        $old_service = [];
        foreach($givenService as $service){
            $old_service[] = $service['service_id'];
        }
        return $old_service;
    }
    private function batchUpdate($request,$adId){
        $old_service = $this->serviceArray($adId);
        $addService = array_diff($request->test_items,$old_service);
        $removeService = array_diff($old_service,$request->test_items);
        foreach($addService as $srv){
            $service = HmsService::find($srv);
            $data = [
                'service_date'  => date('Y-m-d'),
                'admission_id'  => $adId,
                'service_id'    => $srv,
                'service_name'  => $service->name,
                'service_price' => $service->price,
                'user_id'       => Sentinel::getUser()->id,
                'patient_id'    => $request->patient_id,
            ];
            HmsGivenService::create($data);
        }
        foreach($removeService as $rm){
            HmsGivenService::where('admission_id',$adId)->where('service_id',$rm)->delete();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function invoicePos($invoice){ 
        $invoicePrint = HmsAdmission::with(['patient','given_services.service','bed'])->where('invoice',$invoice)->first();
         return view('hospital.admission.invoice.invoicePos',compact('invoicePrint'));
    }
    public function invoiceA4($invoice){
         $invoicePrint = HmsAdmission::with(['patient','given_services.service'])->where('invoice',$invoice)->first();
         return view('hospital.admission.invoice.invoiceA4',compact('invoicePrint'));
    }

    public function discharge($slug){
        $admission = HmsAdmission::where('slug',$slug)->first();
        $patient = $admission->patient;
        $given_service = $this->serviceArray($admission->id);
        $DueDiagnosticBill = Bill::where('patient_id',$admission->patient_id)->where('status','Active')->where('due','>',0)->whereRaw('due > due_collection')->get();
        $DuePharmacy = Sale::where('patient_id',$admission->patient_id)->where('status','Active')->where('new_balance','>',0)->whereRaw('new_balance > due_collection')->get();
        $DueOperation = HmsOperation::where('patient_id',$admission->patient_id)->where('status','Active')->where('due','>',0)->whereRaw('due > due_collection')->get();
        $DueEmergency = HmsEmergency::where('patient_id',$admission->patient_id)->where('status','Active')->where('due','>',0)->whereRaw('due > due_collection')->get();

        $stayDay = Pharma::two_date_diff($admission->date,date('Y-m-d'));
        $refarences = Referral::all();
        
        // $beds = HmsBed::where('patient',0)->get();
        $servicecategory = HmsServiceCategory::all();
        $service = HmsService::orderBy('price','DESC')->get();
        return view('hospital.admission.discharge',compact('admission','patient','given_service','DueOperation','DueEmergency','DueDiagnosticBill','DuePharmacy','stayDay','refarences','servicecategory','service'));
    }
    public function postdischarge($slug,Request $request) {
        // dd($request->all());
        $admission = HmsAdmission::where('slug',$slug)->first();
        $result     = $this->dataCalculation($request);
        $data = [
            'sub_total'         =>  $result['sub_total'],
            'discount_percent'  =>  $request->discountPercent,
            'discount_overall'  =>  $request->discountOverall,
            'discount_total'    =>  $result['total_discount'],
            'grand_total'       =>  $result['grand_total'],
            'paid_amount'       =>  $result['paidAmount'],
            'actual_paid_amount'=>  $result['actualPaidAmount'],
            'due'               =>  $result['due'],
            'change'            =>  $result['change'],
            'remark'            =>  $request->remark,
            'discharge_date'    =>  $request->discharge_date,
            'discharge_time'    =>  $request->discharge_time,
            'status'            =>  'Discharged',
        ]; 
        $admission->update($data);
        $this->batchUpdate($request,$admission->id);
        $stayDay = Pharma::two_date_diff($admission->date,$request->discharge_date);
        $data = [
            'service_date'  => date('Y-m-d'),
            'admission_id'  => $admission->id,
            'service_id'    => 0,
            'service_name'  => "Bed Service {$admission->bed->bed_no} ({$admission->bed->price} X {$stayDay} Days)",
            'service_price' => $admission->bed->price * $stayDay,
            'user_id'       => Sentinel::getUser()->id,
            'patient_id'    => $admission->patient_id,
        ];
        HmsGivenService::create($data);

        HmsBed::where('patient',$admission->patient_id)->update(['patient'=>0]);

        if($request->trans_id != 0 ){
            $trans = New Transation;
            $trans = $trans->find($request->trans_id);
            $trans->amount = $result['actualPaidAmount']; 
            $trans->save();
        }else{
            $transId = $this->makeTransaction($admission->invoice,$result,$admission->patient_id);
            $admission->trans_id = $transId;
            $admission->save();
        }
        Session::flash('success', 'Admission Discharged!');
        Pharma::activities("Discharged", "Admission", "Admission Bill Discharged with ".$result['actualPaidAmount']);
        if(session()->get('settings')[0]['voucher_type'] == 'A4'){
            //A4 size print
            return redirect('hospital/admission/invoice/a4/' . $admission->invoice);
        }else if(session()->get('settings')[0]['voucher_type'] == 'POS'){
        //pos size print
            return redirect('hospital/admission/invoice/pos/'.$admission->invoice);
        }
    }


    
    public function voided(HmsAdmission $admission){
        $admissions = HmsAdmission::where('status','void')->get();
         return view('hospital.admission.restoreVoided',compact('admissions'));
    } 

   
   public function void($slug){
       $admission = HmsAdmission::where('slug', $slug)->first();
       $admission->update(['status' => 'void']);
      
       DB::table('transations')->where('id', $admission->trans_id)->update(['status' => 'void']);   
       DB::table('hms_beds')->where('id',$admission->bed_id)->update(['patient' => 0]);

       Pharma::activities("Voided", "Hospital admission", "Voided a Hospital admission with ".$admission['paidAmount']);
       Session::flash('success', 'Admission Void Succeed!'); 
       return redirect('hospital/admission');
   }

//    public function restore($slug){
//        $admission = HmsAdmission::where('slug', $slug)->first();
//        $admission->update(['status' => 'active']);
      
//        DB::table('transations')->where('id', $admission->trans_id)->update(['status' => 'active']);   
//        Pharma::activities("Restore", "Diagnostic admission", "Added a New Diagnostic admission with ".$admission['paidAmount']);

//        Session::flash('success', 'admission Restored Succeed!'); 
//        return redirect('hospital/admission');
//    } 

   public function dischargelist(HmsAdmission $admission){
       $admissions = HmsAdmission::where('status','discharged')->get(); 
       return view('hospital.dischargeList',compact('admissions'));
   } 

}
