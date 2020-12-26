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
use App\Models\hospital\HmsAdmission;
use App\Models\hospital\HmsOperation;
use App\Models\hospital\HmsBed;
use App\Models\hospital\HmsServiceCategory;
use App\Models\hospital\HmsService;
use App\Models\hospital\HmsEmergency;
use App\Models\hospital\HmsEmergencyService;
use App\Transation;

use App\Expense;
use Sentinel;
use Session;
use Pharma;
use DB;

class HmsEmergencyController extends Controller
{

    public function __construct(){
        $this->middleware(['authorized','hospital']);
    }
    
    public function index(){
        $emergency_data = HmsEmergency::orderBy('id','desc')->where('status','Active')->get();
        return view('hospital.emergency.index',compact('emergency_data'));
    }

    public function create(){
        $refarences = Referral::all();
        $totalBillAdm = HmsAdmission::where('status','Active')->sum('grand_total');
        $totalBillEmr = HmsEmergency::where('status','Active')->sum('grand_total');
        $TotalBillAmount = abs($totalBillAdm+$totalBillEmr);
        $totalDueAdm = HmsAdmission::where('status','Active')->sum('due');
        $totalDueEmr = HmsEmergency::where('status','Active')->sum('due');
        $TotalDue = abs($totalDueAdm+$totalDueEmr);
        $TotalExpense = Expense::where('module','Hospital')->sum('amount');
        $todayBillCountAdm = HmsAdmission::where('status','Active')->where('date','>=',date('Y-m-d'))->where('date','<=',date('Y-m-d'))->count();
        $todayBillCountEmr = HmsEmergency::where('status','Active')->where('date','>=',date('Y-m-d'))->where('date','<=',date('Y-m-d'))->count();
        $TodayBillCount = abs($todayBillCountAdm+$todayBillCountEmr);
        $servicecategory = HmsServiceCategory::all();
        $service = HmsService::orderBy('id','ASC')->get();
        return view('hospital.emergency.create',compact('refarences','servicecategory','service','TotalBillAmount','TotalDue','TotalExpense','TodayBillCount'));
    }

    public function store(Request $request){
        // dd($request->all());
        $patientId  = $this->getPatient($request);
        $referralId = $this->getReferral($request);
        // $invoice    = Pharma::GenarateInvoiceNumber('hms_admissions',session()->get('settings')[0]['prefix_hms_emergency']);
        $invoice    = Pharma::GenarateInvoiceNumber('hms_emergencies','EMR');
        $result     = $this->dataCalculation($request);

        $data = [
            'date'              =>  date('Y-m-d'),
            'time'              =>  date('H:i:s'),
            'slug'              =>  $invoice,
            'invoice'           =>  $invoice,
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
            'patient_id'        =>  $patientId,
            'referral_id'       =>  $referralId,
            'user_id'           =>  Sentinel::getUser()->id,
            'created_at'        =>  now()
        ];

        $emergency = HmsEmergency::create($data);
        $this->addServices($emergency->id,$request,$patientId);
       

        if($result['actualPaidAmount'] > 0){
            $transId = $this->makeTransaction($invoice,$result,$patientId);
            $emergency->trans_id = $transId;
            $emergency->save();
        }

        Session::flash('success', 'Emergency Bill inserted!');
        Pharma::activities("Added", "New Emergency", "Added a New Emergency Bill with ".$result['actualPaidAmount']);
        if(session()->get('settings')[0]['voucher_type'] == 'A4'){
            
            //A4 size print
             return redirect('hospital/emergency/invoice/a4/' . $invoice);
            // return redirect('hospital/admission');
        }else if(session()->get('settings')[0]['voucher_type'] == 'POS'){
           // echo 'done';
             return redirect('hospital/admission');
        //pos size print
             return redirect('hospital/emergency/invoice/pos/'.$invoice);
        }

    }

    private function addServices($adId,$request,$patientId){
        $service_items = new HmsEmergencyService;
        for ($i = 0; $i < count($request->test_items); $i++) {
            $service = HmsService::find($request->test_items[$i]);
            $services = [
                'service_date'  => date('Y-m-d'),
                'hms_emergency_id'  => $adId,
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
        $url = url('hospital/emergency/invoice/a4/'.$invoice);
        $trans = $transaction->create([
            'date'                  => date('Y-m-d'),
            'trans_id'              => Pharma::GenarateInvoiceNumber('transations',session()->get('settings')[0]['transaction_prefix']),
            'amount'                => $result['actualPaidAmount'],
            'description'           => "Received from emergency bill. <a target='_blank' href='{$url}'>{$invoice}</a>",
            'vendor_id'             => $patientId,
            'user_id'               => Sentinel::getUser()->id,
            'module'                => 'Hospital',
            'sub_module'            => 'Hospital-Emergency',
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
    
    public function edit(HmsEmergency $emergency){
        $refarences = Referral::all();
        $totalBillAdm = HmsAdmission::where('status','Active')->sum('grand_total');
        $totalBillEmr = HmsEmergency::where('status','Active')->sum('grand_total');
        $TotalBillAmount = abs($totalBillAdm+$totalBillEmr);
        $totalDueAdm = HmsAdmission::where('status','Active')->sum('due');
        $totalDueEmr = HmsEmergency::where('status','Active')->sum('due');
        $TotalDue = abs($totalDueAdm+$totalDueEmr);
        $TotalExpense = Expense::where('module','Hospital')->sum('amount');
        $todayBillCountAdm = HmsAdmission::where('status','Active')->where('date','>=',date('Y-m-d'))->where('date','<=',date('Y-m-d'))->count();
        $todayBillCountEmr = HmsEmergency::where('status','Active')->where('date','>=',date('Y-m-d'))->where('date','<=',date('Y-m-d'))->count();
        $TodayBillCount = abs($todayBillCountAdm+$todayBillCountEmr);
        $servicecategory = HmsServiceCategory::all();
        $service = HmsService::orderBy('id','ASC')->get();
        return view('hospital.emergency.edit',compact('refarences','TotalBillAmount','TotalDue','TotalExpense','TodayBillCount','servicecategory','service','emergency'));
    }

    public function update(Request $request,HmsEmergency $emergency){
        $result = $this->dataCalculation($request);
        $data = [ 
            'invoice'           => $request->invoice,
            'sub_total'         =>  $result['sub_total'],
            'discount_percent'  =>  $request->discountPercent,
            'discount_overall'  =>  $request->discountOverall,
            'discount_total'    =>  $result['total_discount'],
            'grand_total'       =>  $result['grand_total'],
            'paid_amount'       =>  $result['paidAmount'], 
            'due'               =>  $result['due'],
            'change'            =>  $result['change'],
            'remark'            =>  $request->remark, 
            'updated_at'        =>  now()
        ];

         $emergency = $emergency->update($data);
         DB::table('hms_emergency_services')->where('hms_emergency_id',$request->id)->delete();
         $this->addServices($request->id,$request,$request->patient_id);

         if($result['actualPaidAmount'] > 0){
             $transId         = New Transation;
             $transId         = $transId->find($request->trans_id);
             $transId->amount = $result['paidAmount'];
             $transId->save();
        }

        Session::flash('success', 'Emergency Bill Updated!');
        Pharma::activities("Updated", "Emergency Bill", "Update Emergency Bill with ".$result['actualPaidAmount']);
        if(session()->get('settings')[0]['voucher_type'] == 'A4'){ 
            //A4 size print
             return redirect('hospital/emergency/invoice/a4/' . $request->invoice);
            // return redirect('hospital/admission');
        }else if(session()->get('settings')[0]['voucher_type'] == 'POS'){
           // echo 'done';
             //return redirect('hospital/admission');
        //pos size print
             return redirect('hospital/emergency/invoice/pos/'.$request->invoice);
        }

    }
    
    public function voided(HmsEmergency $emergency){
        $admissions = HmsEmergency::where('status','void')->get();
         return view('hospital.emergency.restoreVoided',compact('admissions'));
   } 

    public function invoiceA4($invoice){ 
         $invoicePrint = HmsEmergency::with(['patient','given_emergency_services'])->where('invoice',$invoice)->first();
         return view('hospital.emergency.invoice.invoiceA4',compact('invoicePrint'));
    }
    public function invoicePos($invoice){
         $invoicePrint = HmsEmergency::with(['patient','given_emergency_services'])->where('invoice',$invoice)->first();
         return view('hospital.emergency.invoice.invoicePos',compact('invoicePrint'));
    }


    public function void($slug){
        $emergency = HmsEmergency::where('slug', $slug)->first();
        $emergency->update(['status' => 'void']);
       
        DB::table('transations')->where('id', $emergency->trans_id)->update(['status' => 'void']);
 
        Pharma::activities("Voided", "Hospital Emergency", "Voided Emergency with ".$emergency['paidAmount']);
        Session::flash('success', 'Admission Void Succeed!'); 
        return redirect('hospital/emergency');
    }

}
