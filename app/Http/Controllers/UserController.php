<?php

namespace App\Http\Controllers;

use App\User;
use App\Permission;
use App\Transation;
use App\Models\Pharma\Purchase;
use App\Expense;
use App\Models\Pharma\Product;
use App\Models\diagnostic\Bill;
use App\Models\Pharma\Batch;
use App\Models\Pharma\Sale;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\hospital\HmsAdmission;
use App\Models\hospital\HmsEmergency;
use App\Models\doctor\DocAppointment;
use App\Models\hospital\HmsOperation;
use App\Models\doctor\Prescription;
use App\Models\doctor\PreMedicineItem;
use App\Models\doctor\PreMedicine;
use App\Models\diagnostic\BillItem;
use App\Models\laboratory\LabReport;
use App\Doctor;
use App\Patient;
use Pharma;
use Sentinel;
use Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('authorized');
    }

    public function dashboard(){
        if(Sentinel::getUser()->inRole('pharmacy')){
            return $this->pharmecyDashboard();
        }elseif(Sentinel::getUser()->inRole('admin')){
            return $this->adminDashboard();
        }elseif(Sentinel::getUser()->inRole('laboratory')){
            return $this->laboratoryDashboard();
        }elseif(Sentinel::getUser()->inRole('diagnostic')){
            return $this->diagnosticDashboard();
        }elseif(Sentinel::getUser()->inRole('hospital')){
            return $this->hospitalDashboard();
        }elseif(Sentinel::getUser()->inRole('doctor')){
            return $this->doctorDashboard();
        }elseif(Sentinel::getUser()->inRole('manager')){
            return $this->managerDashboard();
        }elseif(Sentinel::getUser()->inRole('receptionist')){
            return $this->receptionistDashboard();
        }
    }

    private function adminDashboard(){
        $lineData = $this->adminlineChartData();
        $barData = $this->adminBarChartData();
         //bed dues
         $patient   = patient::where('status','Active')->get();
         $bedCharge = 0;
         foreach($patient as $row){
             $bedCharge += Pharma::getBedChargeCollection($row->id); 
         }
         $data['bed_due'] = $bedCharge;
         $TotalbedCharge = $data['bed_due'] = $bedCharge;

         $patient   = patient::where('status','Active')->where('created_at',date('Y-m-d'))->get();
         $bedCharge = 0;
         foreach($patient as $row){
             $bedCharge += Pharma::getBedChargeCollection($row->id); 
         }
         $data['bed_due'] = $bedCharge;
         $TodaybedCharge = $data['bed_due'] = $bedCharge;
          

         $last10diagnostic  = Bill::take(10)->where('status','Active')->orderBy('id','DESC')->get();
         $last10emergency   = HmsEmergency::take(10)->where('status','Active')->orderBy('id','DESC')->get();
         $last10sales       = Sale::take(10)->where('status','Active')->orderBy('id','DESC')->get();
         $last10appoint     = DocAppointment::take(10)->where('status','Paid')->orderBy('id','DESC')->get();
         $last10expence     = Expense::take(10)->orderBy('id','DESC')->get();

         $todaySale         = Sale::where('date',date('Y-m-d'))->where('status','Active')->sum('paid_amount');  
         $TotalPurchase     = Purchase::where('status','Active')->sum('payable_amount');
         $TotalSale         = Sale::where('status','Active')->sum('grand_total');
         $TotalDiagonBill   = Bill::where('status','Active')->sum('grand_total');
         $TotalAppointmetn  = DocAppointment::count('invoice');
         $TodayAppointmetn  = DocAppointment::where('date',date('Y-m-d'))->count('invoice');
         $TotalPrescription = Prescription::where('status','Active')->count('invoice');
         $TotalLabReport    = LabReport::where('status','Active')->count('invoice');
         $TodaylLabReport   = LabReport::where('date',date('Y-m-d'))->where('status','Active')->count('invoice');
         $TotalAdmission    = HmsAdmission::where('status','Active')->count('invoice');
         $TodayAdmission    = HmsAdmission::where('status','Active')->where('date',date('Y-m-d'))->count('invoice');
         $TotalEmergency    = HmsEmergency::where('status','Active')->count('invoice');
         $TodayEmergency    = HmsEmergency::where('status','Active')->where('date',date('Y-m-d'))->count('invoice');
         $TotalPatient      = Patient::where('status','Active')->count('slug');
         $TotalPayment      = Transation::where('status','Active')->where('transaction_type','Payment')->sum('amount');
         $TotalReceive      = Transation::where('status','Active')->where('transaction_type','Received')->sum('amount');
         $TotalDoctor       = Doctor::where('status','Active')->count('id');
         $userTransaction   = Transation::where('date',date('Y-m-d'))->where('status','Active')->get();
         $Totalotbill       = Transation::where('status','Active')->where('sub_module','Hospital-Operation')->sum('amount');
         $Todayotbill       = Transation::where('status','Active')->where('sub_module','Hospital-Operation')->where('date',date('Y-m-d'))->sum('amount');
         $users             = User::where('id','!=',1)->get(); 
        //  dd($userTransaction);
        return view('dashboard.admin-dashboard',compact('users','todaySale','TodaylLabReport','TodayAppointmetn','Todayotbill','Totalotbill','TodaybedCharge','TotalbedCharge','TodayAdmission','TodayEmergency','TotalSale','TotalPurchase','TotalDiagonBill','TotalAppointmetn','TotalPrescription','TotalLabReport','TotalAdmission','TotalEmergency','TotalPatient','TotalPayment','TotalReceive','TotalDoctor','userTransaction','barData','lineData','TotalSale','TotalPurchase','last10diagnostic','last10emergency','last10sales','last10appoint','last10expence'));
    }

    private function managerDashboard(){
        $lineData = $this->adminlineChartData();
        $barData = $this->adminBarChartData();
         

         //bed dues
         $patient   = patient::where('status','Active')->get();
         $bedCharge = 0;
         foreach($patient as $row){
             $bedCharge += Pharma::getBedChargeCollection($row->id); 
         }
         $data['bed_due'] = $bedCharge;
         $TotalbedCharge = $data['bed_due'] = $bedCharge;

         $patient   = patient::where('status','Active')->where('created_at',date('Y-m-d'))->get();
         $bedCharge = 0;
         foreach($patient as $row){
             $bedCharge += Pharma::getBedChargeCollection($row->id); 
         }
         $data['bed_due'] = $bedCharge;
         $TodaybedCharge = $data['bed_due'] = $bedCharge;
          

         $last10diagnostic  = Bill::take(10)->where('status','Active')->orderBy('id','DESC')->get();
         $last10emergency   = HmsEmergency::take(10)->where('status','Active')->orderBy('id','DESC')->get();
         $last10sales       = Sale::take(10)->where('status','Active')->orderBy('id','DESC')->get();
         $last10appoint     = DocAppointment::take(10)->where('status','Paid')->orderBy('id','DESC')->get();
         $last10expence     = Expense::take(10)->orderBy('id','DESC')->get();

         $todaySale         = Sale::where('date',date('Y-m-d'))->where('status','Active')->sum('paid_amount');  
         $TotalPurchase     = Purchase::where('status','Active')->sum('payable_amount');
         $TotalSale         = Sale::where('status','Active')->sum('grand_total');
         $TotalDiagonBill   = Bill::where('status','Active')->sum('grand_total');
         $TotalAppointmetn  = DocAppointment::count('invoice');
         $TodayAppointmetn  = DocAppointment::where('date',date('Y-m-d'))->count('invoice');
         $TotalPrescription = Prescription::where('status','Active')->count('invoice');
         $TotalLabReport    = LabReport::where('status','Active')->count('invoice');
         $TodaylLabReport   = LabReport::where('date',date('Y-m-d'))->where('status','Active')->count('invoice');
         $TotalAdmission    = HmsAdmission::where('status','Active')->count('invoice');
         $TodayAdmission    = HmsAdmission::where('status','Active')->where('date',date('Y-m-d'))->count('invoice');
         $TotalEmergency    = HmsEmergency::where('status','Active')->count('invoice');
         $TodayEmergency    = HmsEmergency::where('status','Active')->where('date',date('Y-m-d'))->count('invoice');
         $TotalPatient      = Patient::where('status','Active')->count('slug');
         $TotalPayment      = Transation::where('status','Active')->where('transaction_type','Payment')->sum('amount');
         $TotalReceive      = Transation::where('status','Active')->where('transaction_type','Received')->sum('amount');
         $TotalDoctor       = Doctor::where('status','Active')->count('id');
         $userTransaction   = Transation::where('date',date('Y-m-d'))->where('status','Active')->get();
         $Totalotbill       = Transation::where('status','Active')->where('sub_module','Hospital-Operation')->sum('amount');
         $Todayotbill       = Transation::where('status','Active')->where('sub_module','Hospital-Operation')->where('date',date('Y-m-d'))->sum('amount');
         $users             = User::where('id','!=',1)->get(); 
        //  dd($userTransaction);
        return view('dashboard.manager-dashboard',compact('users','todaySale','TodaylLabReport','TodayAppointmetn','Todayotbill','Totalotbill','TodaybedCharge','TotalbedCharge','TodayAdmission','TodayEmergency','TotalSale','TotalPurchase','TotalDiagonBill','TotalAppointmetn','TotalPrescription','TotalLabReport','TotalAdmission','TotalEmergency','TotalPatient','TotalPayment','TotalReceive','TotalDoctor','userTransaction','barData','lineData','TotalSale','TotalPurchase','last10diagnostic','last10emergency','last10sales','last10appoint','last10expence'));
    }

    private function pharmecyDashboard(){
        $lineData = $this->PharmalineChartData();
        $barData = $this->PharmaBarChartData();
        $TotalExpense = Expense::where('module','Pharmacy')->sum('amount');
        $TotalPurchase = Purchase::where('status','Active')->sum('payable_amount');
        $TotalSale = Sale::where('status','Active')->sum('grand_total');
        $LowMedicine = Product::take(10)->with(['unit'])->where('status','Active')->orderBy('stock','ASC')->get();
        $ExpMedicine = Batch::take(10)->with(['product.unit'])->where('expiry_date','>=',date('Y-m-d'))->where('status','Active')->where('in_stock','!=','0')->orderBy('expiry_date','ASC')->get();
        $TodaySaleCount = Sale::where('date','>=',date('Y-m-d'))->where('date','<=',date('Y-m-d'))->where('status','Active')->count();
        $todaySale = Sale::where('date',date('Y-m-d'))->where('status','Active')->sum('paid_amount');
        $todayExpense = Expense::where('date',date('Y-m-d'))->where('module','Pharmacy')->sum('amount');
        $todayPurchase = Purchase::where('date',date('Y-m-d'))->where('status','Active')->sum('payable_amount');
        return view('dashboard.pharma-dashboard', compact('lineData','barData','lineData','TotalExpense','TotalPurchase','TotalSale','TodaySaleCount','LowMedicine','ExpMedicine','todaySale','todayExpense','todayPurchase'));
    }

    private function doctorDashboard(){
       $doctor = Pharma::getDoctor();
       $NumPres = Prescription::where('doctor_id',$doctor->id)->where('status','Active')->count('invoice');    
       $NumDraftPres = Prescription::where('doctor_id',$doctor->id)->where('status','Draft')->count('invoice');
       $PreMedi = PreMedicine::count('name');  
       $Todayappoin = DocAppointment::where('doctor_id',$doctor->id)->where('status','Paid','Confirmed')->count('invoice');   
       $Prescription = Prescription::take(10)->where('status','Active')->orderBy('invoice','ASC')->get(); 
       $DraftPres = Prescription::take(10)->where('status','Draft')->orderBy('invoice','ASC')->get();   
       $barData = $this->DoctorBarChartData();
    //    dd($barData ) ; 
       return view('dashboard.doctor-dashboard',compact('NumPres','NumDraftPres','PreMedi','Todayappoin','Prescription','DraftPres','barData'));
    }

    private function receptionistDashboard(){
        $totalTest     = BillItem::count('id');
        $totalReport   = LabReport::where('status','Active')->count('invoice');
        $todayReport   = LabReport::where('status','Active')->where('date',date('y-m-d'))->count('invoice');
        $reportInvoice = LabReport::where('status','Active')->where('date',date('y-m-d'))->count('invoice');
        $lst10reports  = LabReport::take(10)->where('status','Active')->orderBy('invoice','ASC')->get();
        $lst10tests    = BillItem::take(10)->orderBy('id','ASC')->get();
        return view('dashboard.receptionist-dashboard',compact('totalTest','totalReport','todayReport','reportInvoice','lst10reports','lst10tests'));
    }
    private function laboratoryDashboard(){
        $totalTest     = BillItem::count('id');
        $totalReport   = LabReport::where('status','Active')->count('invoice');
        $todayReport   = LabReport::where('status','Active')->where('date',date('y-m-d'))->count('invoice');
        $reportInvoice = LabReport::where('status','Active')->where('date',date('y-m-d'))->count('invoice');
        $lst10reports  = LabReport::take(10)->where('status','Active')->orderBy('invoice','ASC')->get();
        $lst10tests    = BillItem::take(10)->orderBy('id','ASC')->get();
        return view('dashboard.laboratory-dashboard',compact('totalTest','totalReport','todayReport','reportInvoice','lst10reports','lst10tests'));
    }

    private function diagnosticDashboard(){
        $barData = $this->DiagonBarChartData();
        $lineData = $this->DiagonlineChartData();
        $TotalExpense = Expense::where('module','Diagnostic')->sum('amount');
        $TotalBillAmount = Bill::where('status','Active')->sum('grand_total');
        $billlDue = Bill::where('status','Active')->sum('due');
        $transAmount = Transation::where('status','Active')->where('transaction_type','collection')->where('module','Diagnostic')->sum('amount');
        $TotalDue = abs($billlDue-$transAmount);
        $TodayBillCount = Bill::where('status','Active')->where('date','>=',date('Y-m-d'))->where('date','<=',date('Y-m-d'))->count();
        $last10Trans = Transation::take(10)->where('status','Active')->where('module','Diagnostic')->orderBy('id','DESC')->get();
        $last10Bills = Bill::take(10)->with('patient')->where('status','Active')->orderBy('id','DESC')->get();
        return view('dashboard.diagnostic-dashboard',compact('lineData','barData','last10Trans','last10Bills','TotalBillAmount','TotalExpense','TotalDue','TodayBillCount'));
    }

    private function hospitalDashboard(){
         $totalBillAdm = HmsAdmission::where('status','Active')->sum('grand_total');
         $totalBillEmr = HmsEmergency::where('status','Active')->sum('grand_total');
         $TotalBillAmount = abs($totalBillAdm+$totalBillEmr);
         $admissionDue = HmsAdmission::where('status','Active')->sum('due');
         $totalDueEmr = HmsEmergency::where('status','Active')->sum('due');
         $transAmount = Transation::where('status','Active')->where('transaction_type','Collection')->where('module','Hospital')->sum('amount');
         $TotalDue = abs($admissionDue+$totalDueEmr-$transAmount);
         $TotalExpense = Expense::where('module','Hospital')->sum('amount');
         $todayBillCountAdm = HmsAdmission::where('status','Active')->where('date','>=',date('Y-m-d'))->where('date','<=',date('Y-m-d'))->count();
         $todayBillCountEmr = HmsEmergency::where('status','Active')->where('date','>=',date('Y-m-d'))->where('date','<=',date('Y-m-d'))->count();
         $TodayBillCount = abs($todayBillCountAdm+$todayBillCountEmr);
         $last10Trans = Transation::take(10)->where('status','Active')->where('module','Hospital')->orderBy('id','DESC')->get();
         $last10Bills = HmsAdmission::take(10)->with('patient')->where('status','Active')->orderBy('id','DESC')->get();
         $lineData = $this->HospitallineChartData();
         $barData = $this->HospitalBarChartData();
        return view('dashboard.hospital-dashboard',compact('TotalBillAmount','TotalDue','TotalExpense','TodayBillCount','last10Trans','last10Bills','lineData','barData'));
    }


    private function DiagonBarChartData(){
        $startDate =  date('Y-m-d H:i:s');
        $startDate =  date('Y-m-d H:i:s', strtotime($startDate . ' -30 day'));
        $lebels = '';
        $amounts = '';
        for($i=0;$i<30;$i++){
            $nextDay = date('Y-m-d H:i:s', strtotime($startDate . ' +1 day'));
            $billAmount = Bill::where('date',date('Y-m-d',strtotime($nextDay)))->where('status','Active')->sum('paid_amount');
            $startDate = $nextDay;
            $amounts .= ', '.$billAmount;
            $lebels .= ', "'.date('d M', strtotime($nextDay)).'"';
            
        }
        $data['BarItems'] = ltrim($lebels,', ');
        $data['Barvalue'] = ltrim($amounts,', ');
        // dd($data);
        return $data;
    }
    private function DoctorBarChartData(){
        $startDate =  date('Y-m-d H:i:s');
        $startDate =  date('Y-m-d H:i:s', strtotime($startDate . ' -30 day'));
        $lebels = '';
        $amounts = '';
        for($i=0;$i<30;$i++){
            $nextDay = date('Y-m-d H:i:s', strtotime($startDate . ' +1 day'));
            $totalPrescription = Prescription::where('date',date('Y-m-d',strtotime($nextDay)))->where('status','Active')->count();
            $startDate = $nextDay;
            $amounts .= ', '.$totalPrescription;
            $lebels .= ', "'.date('d M', strtotime($nextDay)).'"';
        }
        $data['BarItems'] = ltrim($lebels,', ');
        $data['Barvalue'] = ltrim($amounts,', ');
        return $data;
    }

    private function PharmaBarChartData(){
        $startDate =  date('Y-m-d H:i:s');
        $startDate =  date('Y-m-d H:i:s', strtotime($startDate . ' -10 day'));
        $lebels = '';
        $amounts = '';
        for($i=0;$i<10;$i++){
            $nextDay = date('Y-m-d H:i:s', strtotime($startDate . ' +1 day'));
            $saleAmount = Sale::where('date',date('Y-m-d',strtotime($nextDay)))->where('status','Active')->sum('paid_amount');
            $startDate = $nextDay;
            $amounts .= ', '.$saleAmount;
            $lebels .= ', "'.date('d M', strtotime($nextDay)).'"';
            
        }
        $data['BarItems'] = ltrim($lebels,', ');
        $data['Barvalue'] = ltrim($amounts,', ');
        return $data;
    }

    private function adminBarChartData(){
        $startDate =  date('Y-m-d H:i:s');
        $startDate =  date('Y-m-d H:i:s', strtotime($startDate . ' -10 day'));
        $lebels = '';
        $amounts = '';
        for($i=0;$i<10;$i++){
            $nextDay = date('Y-m-d H:i:s', strtotime($startDate . ' +1 day'));
            $saleAmount = Sale::where('date',date('Y-m-d',strtotime($nextDay)))->where('status','Active')->sum('paid_amount');
            $startDate = $nextDay;
            $amounts .= ', '.$saleAmount;
            $lebels .= ', "'.date('d M', strtotime($nextDay)).'"';
            
        }
        $data['BarItems'] = ltrim($lebels,', ');
        $data['Barvalue'] = ltrim($amounts,', ');
        return $data;
    }

    private function HospitalBarChartData(){
        $startDate =  date('Y-m-d H:i:s');
        $startDate =  date('Y-m-d H:i:s', strtotime($startDate . ' -10 day'));
        $lebels = '';
        $amounts = '';
        for($i=0;$i<10;$i++){
            $nextDay = date('Y-m-d H:i:s', strtotime($startDate . ' +1 day'));
            $saleAmount = HmsAdmission::where('date',date('Y-m-d',strtotime($nextDay)))->where('status','Active')->sum('paid_amount');
            $startDate = $nextDay;
            $amounts .= ', '.$saleAmount;
            $lebels .= ', "'.date('d M', strtotime($nextDay)).'"';
            
        }
        $data['BarItems'] = ltrim($lebels,', ');
        $data['Barvalue'] = ltrim($amounts,', ');
        return $data;
    }
    private function DiagonlineChartData(){
        $received = Transation::selectRaw('year(date) year, monthname(date) month, sum(amount) amount')
                ->groupBy('year', 'month')
                ->whereDate('date', '>=', date('Y-01-01 00:00:00'))
                ->whereDate('date', '<=', date('Y-12-31 23:59:59'))
                ->where('status', 'Active')
                ->where('module', 'diagnostic')
                ->where('transaction_type', 'Received')
                ->get();
        $rec = $this->lineLevelData($received);
        $data['label']  = $rec['label'];
        $data['receivedValue']  = $rec['value'];
        return $data;
    }
    private function PharmalineChartData(){
        $payments = Transation::selectRaw('year(date) year, monthname(date) month, sum(amount) amount')
                ->groupBy('year', 'month')
                ->whereDate('date', '>=', date('Y-01-01 00:00:00'))
                ->whereDate('date', '<=', date('Y-12-31 23:59:59'))
                ->where('status', 'Active')
                ->where('module', 'pharmacy')
                ->where('transaction_type', 'Payment')
                ->get();
        $received = Transation::selectRaw('year(date) year, monthname(date) month, sum(amount) amount')
                ->groupBy('year', 'month')
                ->whereDate('date', '>=', date('Y-01-01 00:00:00'))
                ->whereDate('date', '<=', date('Y-12-31 23:59:59'))
                ->where('status', 'Active')
                ->where('module', 'pharmacy')
                ->where('transaction_type', 'Received')
                ->get();

        $pay = $this->lineLevelData($payments);
        $rec = $this->lineLevelData($received);
        $data['label']  = $pay['label'];
        $data['paymentValue']  = $pay['value'];
        $data['receivedValue']  = $rec['value'];
        return $data;
    }
    private function adminlineChartData(){
        $payments = Transation::selectRaw('year(date) year, monthname(date) month, sum(amount) amount')
                ->groupBy('year', 'month')
                ->whereDate('date', '>=', date('Y-01-01 00:00:00'))
                ->whereDate('date', '<=', date('Y-12-31 23:59:59'))
                ->where('status', 'Active') 
                ->where('transaction_type', 'Payment')
                ->get();
        $received = Transation::selectRaw('year(date) year, monthname(date) month, sum(amount) amount')
                ->groupBy('year', 'month')
                ->whereDate('date', '>=', date('Y-01-01 00:00:00'))
                ->whereDate('date', '<=', date('Y-12-31 23:59:59'))
                ->where('status', 'Active') 
                ->where('transaction_type', 'Received')
                ->get();

        $pay = $this->lineLevelData($payments);
        $rec = $this->lineLevelData($received);
        $data['label']  = $pay['label'];
        $data['paymentValue']  = $pay['value'];
        $data['receivedValue']  = $rec['value'];
        return $data;
    }

    private function HospitallineChartData(){
        $payments = Transation::selectRaw('year(date) year, monthname(date) month, sum(amount) amount')
                ->groupBy('year', 'month')
                ->whereDate('date', '>=', date('Y-01-01 00:00:00'))
                ->whereDate('date', '<=', date('Y-12-31 23:59:59'))
                ->where('status', 'Active')
                ->where('module', 'hospital')
                ->where('transaction_type', 'Payment')
                ->get();
        $received = Transation::selectRaw('year(date) year, monthname(date) month, sum(amount) amount')
                ->groupBy('year', 'month')
                ->whereDate('date', '>=', date('Y-01-01 00:00:00'))
                ->whereDate('date', '<=', date('Y-12-31 23:59:59'))
                ->where('status', 'Active')
                ->where('module', 'hospital')
                ->where('transaction_type', 'Received')
                ->get();

        $pay = $this->lineLevelData($payments);
        $rec = $this->lineLevelData($received);
        $data['label']  = $pay['label'];
        $data['paymentValue']  = $pay['value'];
        $data['receivedValue']  = $rec['value'];
        return $data;
    }

       private function lineLevelData($data){
        $label = '';
        $value = '';

        $array = [
            'Jan-'.date('Y')    => 0,
            'Feb-'.date('Y')    => 0,
            'Mar-'.date('Y')    => 0,
            'Apr-'.date('Y')    => 0,
            'May-'.date('Y')    => 0,
            'Jun-'.date('Y')    => 0,
            'Jul-'.date('Y')    => 0,
            'Aug-'.date('Y')    => 0,
            'Sep-'.date('Y')    => 0,
            'Oct-'.date('Y')    => 0,
            'Nov-'.date('Y')    => 0,
            'Dec-'.date('Y')    => 0,
        ];

        if(!empty($data)){
            foreach($data as $row){
                $index = substr($row->month, 0, 3).'-'.$row->year;
                $array[$index] = $row->amount;
            }
        }
        foreach($array as $key => $val){
            $label .= "'".$key."' , ";
            $value .= $val.',';
        }
        $data['label'] = rtrim($label,' ,');
        $data['value'] = rtrim($value,',');
        return $data;
    }




    public function myProfile()
    {
        $user = Sentinel::getUser();
        return view('users.my_profile', compact('user'));
    }

    public function updateMyProfile(Request $request)
    {
        $this->formValidate($request);
        $user = Sentinel::findById(Sentinel::getUser()->id);
        $profile_banar = $request->old_profile_banar;
        $profile_image = $request->old_profile_image;
        if ($request->hasFile('profile_image')) {
            $profile_image = $request->profile_image->store('public/profileImage/user');
            Storage::delete($request->old_profile_image);
        }
        if ($request->hasFile('profile_banar')) {
            $profile_banar = $request->profile_banar->store('public/profileImage/banar');
            Storage::delete($request->old_profile_banar);
        }
        // dd($profile_banar);
        $credentials = [
            'profile_image' => $profile_image,
            'profile_banar' => $profile_banar,
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'name'          => $request->first_name . ' ' . $request->last_name
        ];
        if (!empty($request->password)) {
            $credentials['password'] = $request->password;
        }
        $user = Sentinel::update($user, $credentials);
        Pharma::sendNotification([1], 'Update own profile', '/users');
        Pharma::activities("Edit", "Users", "Edit a user");
        Session::flash('success', 'Profile updated succeed!');
        return redirect('myprofile');
    }

    public function userCreate()
    {
        if (!Sentinel::hasAccess('user-add')) {
            Session::flash('error', 'Permission Denied!');
            return redirect()->back();
        }
        $roles = DB::table('roles')->get();
        return view('users.user.create', compact('roles'));
    }

    public function userStore(Request $request)
    {
        if (!Sentinel::hasAccess('user-add')) {
            Session::flash('error', 'Permission Denied!');
            return redirect()->back();
        }
        $this->formValidate($request);
        $request->validate(['role' => 'required', 'password' => 'required']);
        $credentials = [
            'email'     => $request->email,
            'password'  => $request->password,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name'      => $request->first_name . " " . $request->last_name,
        ];
        $user = Sentinel::registerAndActivate($credentials);
        $role = Sentinel::findRoleBySlug($request->role);
        $role->users()->attach($user->id);
        Session::flash('success', 'User registration Succeed!');
        Pharma::activities("Store", "Users", "Store a user");
        return redirect('users');
    }

    public function index()
    {
        if (!Sentinel::hasAccess('user-index')) {
            Session::flash('warning', 'Permission Denied!');
            return redirect()->back();
        }
        $users = User::orderBy('id', 'ASC')->get();
        return view('users.user.index', compact('users'));
    }

    public function userEdit($id)
    {
        if (!Sentinel::hasAccess('user-edit')) {
            Session::flash('error', 'Permission Denied!');
            return redirect()->back();
        }
        $user = Sentinel::findById($id);
        return view('users.user.edit', compact('user'));
    }

    public function userUpdate($id, Request $request)
    {
        if (!Sentinel::hasAccess('user-update')) {
            Session::flash('error', 'Permission Denied!');
            return redirect()->back();
        }
        $this->formValidate($request);
        $user = Sentinel::findById($id);
        // dd($user);
        $credentials = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name'      => $request->first_name . ' ' . $request->last_name
        ];
        if (!empty($request->password)) {
            $credentials['password'] = $request->password;
        }
        $user = Sentinel::update($user, $credentials);
        Session::flash('success', 'User updated succeed!');
        Pharma::activities("Edit", "Users", "Edit a user");
        return redirect('users');
    }

    public function userDelete($id)
    {
        if (!Sentinel::hasAccess('user-delete')) {
            Session::flash('error', 'Permission Denied!');
            return redirect()->back();
        }
        if (Sentinel::getUser()->id == $id) {
            Session::flash('success', 'You cannot delete your account!');
            return redirect()->back();
        }
        $user = Sentinel::findById($id);
        $user->delete();
        Session::flash('success', 'User deleted successed!');
        Pharma::activities("Delete", "Users", "Delete a user");
        return redirect('users');
    }

    private function formValidate($request)
    {
        $request->validate([
            'email'         => 'sometimes|nullable|email|unique:users,email',
            'first_name'    => 'required',
            'last_name'     => 'required',
            'password'      => 'sometimes|nullable|min:6',
        ]);
    }

    public function indexRole()
    {
        if (!Sentinel::hasAccess('role-index')) {
            Session::flash('error', 'Permission Denied!');
            return redirect()->back();
        }
        $roles = EloquentRole::all();
        return view('users.role.index', compact('roles'));
    }

    public function createRole()
    {
        if (!Sentinel::hasAccess('role-add')) {
            Session::flash('error', 'Permission Denied!');
            return redirect()->back();
        }
        $data = array();
        $permissions = Permission::where('parent_id', 0)->get();
        return view('users.role.create', compact('permissions'));
    }

    public function storeRole(Request $request)
    {
        if (!Sentinel::hasAccess('role-store')) {
            Session::flash('error', 'Permission Denied!');
            return redirect()->back();
        }
        $role = new EloquentRole();
        $role->name = $request->name;
        $role->slug = Pharma::getUniqueSlug($role, $request->name);
        $role->save();
        if (!empty($request->permission)) {
            foreach ($request->permission as $key) {
                $role->updatePermission($key, true, true)->save();
            }
        }
        Session::flash('success', 'Role added succeed!');
        Pharma::activities("store", "Role", "Store a Role");
        return redirect('users/roles');
    }

    public function editRole($id)
    {
        if (!Sentinel::hasAccess('role-edit')) {
            Session::flash('error', 'Permission Denied!');
            return redirect()->back();
        }
        $data = array();
        $permissions = Permission::where('parent_id', 0)->get();

        $role = EloquentRole::find($id);
        return view('users.role.edit', compact('permissions', 'role'));
    }

    public function updateRole(Request $request, $id)
    {
        if (!Sentinel::hasAccess('role-update')) {
            Session::flash('error', 'Permission Denied!');
            return redirect()->back();
        }
        $role = EloquentRole::find($id);
        $role->name = $request->name;
        $role->permissions = array();
        $role->save();
        //remove permissions which have not been ticked
        //create and/or update permissions
        if (!empty($request->permission)) {
            foreach ($request->permission as $key) {
                $role->updatePermission($key, true, true)->save();
            }
        }
        Session::flash('success', 'Succeed!');
        Pharma::activities("Update", "Role", "Update a Role");
        return redirect('users/role/' . $id . '/edit');
    }

    public function deleteRole($id)
    {
        if (!Sentinel::hasAccess('role-delete')) {
            Session::flash('error', 'Permission Denied!');
            return redirect()->back();
        }
        if (Pharma::countUserinRole($id) == 0) {
            EloquentRole::destroy($id);
            Session::flash('success', 'Role deleted succeed!');
            return redirect('users/roles');
        } else {
            Session::flash('danger', 'Some user is already assign on this role!');
            return redirect()->back();
        }
    }
}
