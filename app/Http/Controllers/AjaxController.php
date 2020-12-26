<?php

namespace App\Http\Controllers;
use App\Notification;
use Illuminate\Http\Request;
use App\User;
use App\Models\Pharma\Product;
use App\Models\Pharma\Manufacturer;
use App\Models\diagnostic\DiagonTestList;
use App\ReferralPayment;
use App\Models\hospital\HmsOperationType;
use App\Models\hospital\HmsAdmission;
use App\Models\hospital\HmsOperationService;
use App\Models\doctor\PreMedicine;
use App\Patient;
use App\Transation;
use App\SiteSetting;
use Session;
use Sentinel;
use Pharma;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Support\Facades\DB;
use App\Models\hospital\HmsService;
use App\DoctorPayment;
class AjaxController extends Controller
{
    public function __construct(){
        $this->middleware('authorized');
    }

    public function updateNotification($id){
        $notify = Notification::find($id);
        $notify->is_read = 1;
        $notify->save();
    }

    public function purchaseProduct($slug){
        $product = Product::where('id',$slug)->first();
        return $product->toJson();
    }

    public function changeProductStatus($id,$status){
        DB::table('pharma_products')->where('id',$id)->update(['status'=>$status]);
        echo 'OK';
    }

    public function manufacturersProduct($id){
        $manufacturer = Manufacturer::where('id',$id)->first();
        $options = Pharma::GetOptions($manufacturer->porduct,'title');
        // dd($options);
        echo $options;
    }

    public function showParmission($id){
        $roles = EloquentRole::find($id);
        $data = '';
        $i = 1;
        $data .="<table class='table table-strip'>
        <tr>
            <th width='20'>SL</th>
            <th>Name</th>
        </tr>";
        foreach($roles->permissions as $key => $val){
            $sl = sprintf('%02d',$i++);
            $data .= "<tr>";
            $data .= "<td>{$sl}</td>";
            $data .= "<td>{$key}</td>";
            $data .= "</tr>";
        }
        $data .= " </tr>
        </table>";
        $json = [
            'role_name' => $roles->name,
            'permission' => $data,
        ];
        echo json_encode($json);
    }

    public function getCustomerInfo($id){
        $customerinfo = Patient::find($id);
        return $customerinfo->toJson();
    }


    //UI
     public function uiToggleSidebar(){
        $siteSetting = SiteSetting::first();
        if(!empty($siteSetting->mini_sidebar)){
            $siteSetting->mini_sidebar = '';
        }else{
            $siteSetting->mini_sidebar = 'mini-sidebar';
        }
        $siteSetting->save();

        session()->forget('settings');
        $settings = SiteSetting::first()->toArray();
        Session::push('settings', $settings);
        echo 'sidebar toggled';
     }

     public function uiColorSwitcher($color){
        $siteSetting = SiteSetting::first();
        $siteSetting->theme = $color;
        $siteSetting->save();

        session()->forget('settings');
        $settings = SiteSetting::first()->toArray();
        Session::push('settings', $settings);
        echo 'Change Color';
     }


     //Diagnostic Module

     public function findPatient($id){
        $json = Patient::find($id);
        if(!empty($json)){
            $data = [
                'status'    => 'OK',
                'data'      => $json
            ];
            echo json_encode($data);
        }else{
            $data = [
                'status'    => 'NOT OK',
                'data'      => ''
            ];
            echo json_encode($data);
        }
     }
     public function findAdmissionPatient($id){
        $admission = HmsAdmission::where('patient_id',$id)->where('status','Active')->first();
        $json = Patient::find($id);

        if(!empty($json)){
            $data = [
                'status'    => !empty($admission) ? 'Exists':'OK',
                'data'      => $json
            ];
            echo json_encode($data);
        }else{
            $data = [
                'status'    => 'NOT OK',
                'data'      => ''
            ];
            echo json_encode($data);
        }
     }

     public function testCountIncrement($id){
        DiagonTestList::where('id', $id)->increment('count', 1);
     }
     public function testCountDecrement($id){
        DiagonTestList::where('id', $id)->decrement('count', 1);
     }

     public function SearchbyCat($cat_id){
        if($cat_id == 0){
            $tests = DiagonTestList::orderBy('count','DESC')->get();
        }else{
            $tests = DiagonTestList::where('test_category_id',$cat_id)->orderBy('count','DESC')->get();
        }
        $html = '';
        if(!empty($tests)){
            foreach($tests as $test){
                $html .= "<tr style='cursor:pointer' id='rowId{$test->id}' onclick=\"addToCart({$test->id},'{$test->name}','{$test->price}')\">";
                $html .= "<td>{$test->name}</td>";
                $html .= "<td>{$test->price}</td>";
                $html .= "</tr>";
            }
        }else{
            $html .= "<tr style='cursor:pointer'>";
            $html .= "<td colspan='2'>No data</td>";
            $html .= "</tr>";
        }
        echo $html;

     }

     public function SearchbyServiceCat($ser_id){
        if($ser_id == 0){
            $services = HmsService::orderBy('name','DESC')->get();
        }else{
            $services = HmsService::where('service_category_id',$ser_id)->orderBy('name','DESC')->get();
        }
        $html = '';
        if(!empty($services)){
            foreach($services as $service){
                $html .= "<tr style='cursor:pointer' id='rowId{$service->id}' onclick=\"addToCart({$service->id},'{$service->name}','{$service->price}')\">";
                $html .= "<td>{$service->name}</td>";
                $html .= "<td>{$service->price}</td>";
                $html .= "</tr>";
            }
        }else{
            $html .= "<tr style='cursor:pointer'>";
            $html .= "<td colspan='2'>No data</td>";
            $html .= "</tr>";
        }
        echo $html;

     }


     public function referralPayment(Request $request){
        $referral = new ReferralPayment;
        $ref = $referral->create([
            'date'  => date('Y-m-d',strtotime($request->date)),
            'referral_id'  => $request->id,
            'amount'  => $request->amount,
            'module'  => $request->module,
            'description'  => $request->description,
        ]);
        $transaction = new Transation;

        $url = url('referral/'.$request->id);
        $trans = $transaction->create([
                'date'  => date('Y-m-d',strtotime($request->date)),
                'trans_id'  => Pharma::GenarateInvoiceNumber('transations',session()->get('settings')[0]['transaction_prefix']),
                'amount'  => $request->amount,
                'description'   => "Make Payment on Referral <a target='_blank' href='{$url}'>{$request->name}</a>",
                'vendor_id' => $request->id,
                'vendor'        => 'Referral',
                'transaction_type'  => 'Payment',
                'module'    => $request->module,
                'user_id'   => Sentinel::getUser()->id,
            ]);

        $ref->trans_id = $trans->id;
        $flag = $ref->save();

        $html = '';
        $i = 0;
        $total = 0;
        $allPayments = ReferralPayment::with('transation')->where('referral_id',$request->id)->orderBy('date','Asc')->get();
        foreach($allPayments as $payment){
            $total += $payment->amount;
            $html .= "<tr>";
            $html .= "<td class='text-center'>".sprintf('%02d',++$i)."</td>";
            $html .= "<td>".Pharma::dateFormat($payment->date)."</td>";
            $html .= "<td>{$payment->transation->trans_id}</td>";
            $html .= "<td class='text-right'>".Pharma::amountFormatWithCurrency($payment->amount)."</td>";
            $html .= "<td>{$payment->description}</td>";
            $html .= "</tr>";
        }
        if($flag == TRUE){
            $data = [
                'status'    => 'OK',
                'paymentData'   => $html,
                'total'   => Pharma::amountFormatWithCurrency($total),
            ];
            echo json_encode($data);
        }else{
            echo json_encode(['status'=> 'NOT OK']);
        }

     }

     public function doctorPayment(Request $request){ 
        $doctor = new DoctorPayment;
        $doc = $doctor->create([
            'date'        => date('Y-m-d',strtotime($request->date)),
            'doctor_id'   => $request->id,
            'amount'      => $request->amount,
            'module'      => $request->module,
            'description' => $request->description,
        ]);
        $transaction = new Transation;

        $url = url('doctor/'.$request->id);
        $trans = $transaction->create([
                'date'              => date('Y-m-d',strtotime($request->date)),
                'trans_id'          => Pharma::GenarateInvoiceNumber('transations',session()->get('settings')[0]['transaction_prefix']),
                'amount'            => $request->amount,
                'description'       => "Make Payment on Doctor <a target='_blank' href='{$url}'>{$request->full_name}</a>",
                'vendor_id'         => $request->id,
                'vendor'            => 'Doctor',
                'transaction_type'  => 'Payment',
                'module'            => $request->module,
                'sub_module'        => 'Diagnostic-Appointment',
                'user_id'           => Sentinel::getUser()->id,
            ]);

        $doc->trans_id = $trans->id;
        $flag = $doc->save();

        $html = '';
        $i = 0;
        $total = 0;
        $allPayments = DoctorPayment::with('transation')->where('doctor_id',$request->id)->orderBy('date','Asc')->get();
        foreach($allPayments as $payment){
            $total += $payment->amount;
            $html .= "<tr>";
            $html .= "<td class='text-center'>".sprintf('%02d',++$i)."</td>";
            $html .= "<td>".Pharma::dateFormat($payment->date)."</td>";
            $html .= "<td>{$payment->transation->trans_id}</td>";
            $html .= "<td class='text-right'>".Pharma::amountFormatWithCurrency($payment->amount)."</td>";
            $html .= "<td>{$payment->description}</td>";
            $html .= "</tr>";
        }
        
        if($flag == TRUE){
            $data = [
                'status'    => 'OK',
                'paymentData'   => $html,
                'total'   => Pharma::amountFormatWithCurrency($total),
            ];
            echo json_encode($data);
        }else{
            echo json_encode(['status'=> 'NOT OK']);
        }
     }



     //hms Module

     public function hmsTypeService($type_id){
        $type       = HmsOperationType::find($type_id);
        $options    = '<option value="" selected disabled>Select Operation Service</option>';
        $options    .= Pharma::GetOptions($type->type,'name');
        echo $options;
     }
     public function hmsOperationServicePrice($service_id){
        echo HmsOperationService::find($service_id)->price;
     }
}
