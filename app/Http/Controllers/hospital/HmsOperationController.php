<?php

namespace App\Http\Controllers\hospital;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hospital\HmsOperationService;
use App\Models\hospital\HmsOperationType;
use App\Models\hospital\HmsAdmission;
use App\Models\hospital\HmsOperation;
use App\Transation;
use Pharma;
use Sentinel;
use Session; 

class HmsOperationController extends Controller
{
    public function __construct(){
        $this->middleware(['authorized','hospital']);
    }

    public function index(){
        $types      = HmsOperationType::all();
        $services   = HmsOperationService::with('category')->get();
        $patient_id = DB::table('hms_admissions')->where('status','Active')->select('patient_id')->get();
        $opertions  = HmsOperation::with('patient')->where('status','Active')->get();
        return view('hospital.operations.index',compact('types','services','patient_id','opertions'));
    }

    public function create(){

    }

    public function store(Request $request){
        $invoice    = Pharma::GenarateInvoiceNumber('hms_operations','OPA');
        $service = HmsOperationService::find($request->operation_service_id);
        $result = $this->dataCalculation($request,$service->price);
        $data = [
            'invoice'                   => $invoice,
            'slug'                      => $invoice,
            'date'                      => $request->date,
            'time'                      => $request->time,
            'operation_service_id'      => $service->id,
            'operation_service_name'    => $service->name,
            'operation_service_price'   => $service->price,
            'discount'                  => $request->discount,
            'grand_total'               => $result['grand_total'],
            'paid_amount'               => $request->paid_amount,
            'due'                       => $result['due'],
            'change'                    => $result['change'],
            'actual_amount'             => $result['actualPaidAmount'],
            'remark'                    => $request->remark,
            'patient_id'                => $request->patient_id,
            // 'admission_id'              => $request->admission_id,
            'user_id'                   => Sentinel::getUser()->id,
            'created_at'                => now()
        ];

        $operation = HmsOperation::create($data);
        if($result['actualPaidAmount'] > 0){
            $transId = $this->makeTransaction($invoice,$result,$request->patient_id);
            $operation->trans_id = $transId;
            $operation->save();
        }

        Session::flash('success', 'Operation Bill inserted!');
        Pharma::activities("Added", "New Operation", "Added a New Operation Bill with ".$result['actualPaidAmount']);
        if(session()->get('settings')[0]['voucher_type'] == 'A4'){
            //A4 size print
            // return redirect('hospital/operation/invoice/a4/' . $invoice);
            return redirect('hospital/operation');
        }else if(session()->get('settings')[0]['voucher_type'] == 'POS'){
            // return redirect('hospital/operation');
        //pos size print
            return redirect('hospital/operation/invoice/pos/'.$invoice);
        }
        // dd($data);
    }

    private function makeTransaction($invoice,$result,$patientId){
        $transaction = New Transation;
        $url = url('hospital/operation/invoice/a4/'.$invoice);
        $trans = $transaction->create([
            'date'                  => date('Y-m-d'),
            'trans_id'              => Pharma::GenarateInvoiceNumber('transations',session()->get('settings')[0]['transaction_prefix']),
            'amount'                => $result['actualPaidAmount'],
            'description'           => "Received from Operation bill. <a target='_blank' href='{$url}'>{$invoice}</a>",
            'vendor_id'             => $patientId,
            'user_id'               => Sentinel::getUser()->id,
            'module'                => 'Hospital',
            'sub_module'            => 'Hospital-Operation',
            'created_at'            => now(),
        ]);
        return $trans->id;
    }

    private function dataCalculation($request,$price){
        $result = [];
        $result['grand_total']          = $price - $request->discount;
        if ($result['grand_total'] <= $request->paid_amount) {
            $result['due']              = 0;
            $result['change']           = $request->paid_amount - $result['grand_total'];
            $result['paid_amount']      = $request->paid_amount;
            $result['actualPaidAmount'] = $result['grand_total'];
        } else {
            $result['due']              = $result['grand_total'] - $request->paid_amount;
            $result['change']           = 0;
            $result['paid_amount']      = $request->paid_amount;
            $result['actualPaidAmount'] = $request->paid_amount;
        }
        return $result;
    }

    public function edit(HmsOperation $operation){
        return view('hospital.operations.edit',compact('operation'));
    }

    public function update(Request $request,HmsOperation $operation){
        $result = $this->dataCalculation($request,$operation->operation_service_price);
        $data = [
            'date'                      => $request->date,
            'time'                      => $request->time,
            'discount'                  => $request->discount,
            'grand_total'               => $result['grand_total'],
            'paid_amount'               => $request->paid_amount,
            'due'                       => $result['due'],
            'change'                    => $result['change'],
            'actual_amount'             => $result['actualPaidAmount'],
            'remark'                    => $request->remark,
            'updated_at'                => now()
        ];

        $operation->update($data);
        if($result['actualPaidAmount'] > 0){
            $trans = Transation::find($operation->trans_id);
            $trans->amount = $result['actualPaidAmount'];
            $trans->updated_at  = now();
            $trans->save();
        }

        Session::flash('success', 'Operation Bill updated!');
        Pharma::activities("Updated", "Operation", "Updated Operation Bill".$result['actualPaidAmount']);
        if(session()->get('settings')[0]['voucher_type'] == 'A4'){
            //A4 size print
            // return redirect('hospital/operation/invoice/a4/' . $invoice);
            return redirect('hospital/operation');
        }else if(session()->get('settings')[0]['voucher_type'] == 'POS'){
            // return redirect('hospital/operation');
        //pos size print
            return redirect('hospital/operation/invoice/pos/'.$invoice);
        }
    }
    public function invoiceA4($invoice){
        $invoicePrint = HmsOperation::with('patient')->where('invoice',$invoice)->first();
        return view('hospital.operations.invoice.invoiceA4',compact('invoicePrint'));
    }

    public function invoicePos($invoice){
        $invoicePrint = HmsOperation::with('patient')->where('invoice',$invoice)->first();
        return view('hospital.operations.invoice.invoicePos',compact('invoicePrint'));
    }


    public function void($slug){
        $operations = HmsOperation::where('slug',$slug)->first();
        $operations->update(['status' => 'void']);

        Pharma::activities("Voided", "Hospital operation", "Voided a Hospital operation with ".$operations['paidAmount']);
        Session::flash('success', 'Operation Void Succeed!'); 
        return redirect('hospital/operation');
    }

    public function Voided(){
        $operations = HmsOperation::where('status','void')->get();
        return view('hospital.operations.voidList',compact('operations'));
    }





}