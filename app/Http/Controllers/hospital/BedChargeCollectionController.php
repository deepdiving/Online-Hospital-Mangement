<?php

namespace App\Http\Controllers\hospital;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\hospital\BedChargeCollection;
use App\Models\hospital\BedChargeCollectionItem;
use App\Transation;

use App\Expense;
use Sentinel;
use Session;
use Pharma;
use DB;

class BedChargeCollectionController extends Controller
{

    public function __construct(){
        $this->middleware(['authorized','hospital']);
    }

    public function index(){
        $bedCollection = BedChargeCollection::all();
        return view('hospital.beds.bedCharge',compact('bedCollection'));
    }
    
    public function store(Request $request,BedChargeCollection $bedcharge){


        // dd($request->all());
        // $invoice    = Pharma::GenarateInvoiceNumber('hms_admissions',session()->get('settings')[0]['prefix_hms_emergency']);
        $invoice    = Pharma::GenarateInvoiceNumber('bed_charge_collections','BCHARGE');
        $result     = $this->dataCalculation($request);

        $data = [
            'slug'          => $invoice,
            'date'          => date('Y-m-d'),
            'invoice'       => $invoice,
            'sub_total'     => $request->sub_total,
            'discount'      => $request->discount,
            'grand_total'   => $result['grand_total'],
            'paid_amount'   => $result['paid_amount'],
            'due'           => $result['due'],
            'advance'       => $result['change'],
            'remark'        => $request->remark,
            'bed_id'        => $request->bed_id,
            'patient_id'    => $request->patient_id,
            'admission_id'  => $request->admission_id,
            'user_id'       =>  Sentinel::getUser()->id,
            'created_at'    =>  now()
        ];

        // dd($data);
        $bedchargecollection = BedChargeCollection::where('bed_id',$request->bed_id)->where('admission_id',$request->admission_id)->where('patient_id',$request->patient_id)->first();
        if(!empty($bedchargecollection)){

            $NetAmount = $request->collection + $request->paid_amount;
            // die($NetAmount);
            if($NetAmount > $request->grand_total){
                $bedchargecollection->advance = $NetAmount-$request->grand_total;
                $bedchargecollection->due = 0;
            }else if($NetAmount < $request->grand_total){
                $bedchargecollection->advance = 0;
                $bedchargecollection->due = $request->grand_total - $NetAmount;
            }else if($NetAmount == $request->grand_total){
                $bedchargecollection->advance = 0;
                $bedchargecollection->due = 0;
            }
            $bedchargecollection->paid_amount = $bedchargecollection->paid_amount + $request->paid_amount;
            $bedchargecollection->sub_total = $request->sub_total;
            $bedchargecollection->discount = $request->discount;
            $bedchargecollection->grand_total = $request->sub_total - $request->discount;
            $bedchargecollection->updated_at = now();
            
            $bedchargecollection->save();
            BedChargeCollectionItem::where('bed_charge_collection_id',$bedchargecollection->id)->delete();
            
        }else{
            $bedchargecollection = BedChargeCollection::create($data);
        }

        $this->addItems($bedchargecollection->id,$request);

        if($result['paid_amount'] > 0){
            $transId = $this->makeTransaction($invoice,$result,$request->patient_id);
            $bedchargecollection->trans_id = $transId;
            $bedchargecollection->save();
        }

        Session::flash('success', 'Hospiral Bed Charge Collected');
        Pharma::activities("Collected", "Bed Charge", "Collected Bed Charge with ".$result['paid_amount']);
        return redirect()->back();
        // if(session()->get('settings')[0]['voucher_type'] == 'A4'){
            
        //     //A4 size print
        //     return redirect()->back();
        //      //return redirect('hospital/bedcharge/invoice/a4/' . $invoice);
        // }else if(session()->get('settings')[0]['voucher_type'] == 'POS'){
        //    // echo 'done';
        // //pos size print
        //      //return redirect('hospital/bedcharge/invoice/pos/'.$invoice);
        // }
    }

    private function addItems($cId,$request){
        $service_items = new BedChargeCollectionItem;
        for ($i = 0; $i < count($request->collection_dates); $i++) {
            $dates = [
                'collection_date'           => $request->collection_dates[$i],
                'amount'                    =>  $request->bed_charge,
                'bed_charge_collection_id'  => $cId,
            ];
            $service_items->create($dates);
        }
    }

    private function makeTransaction($invoice,$result,$patientId){
        $transaction = New Transation;
        $url = url('hospital/bedcharge/invoice/a4/'.$invoice);
        $trans = $transaction->create([
            'date'                  => date('Y-m-d'),
            'trans_id'              => Pharma::GenarateInvoiceNumber('transations',session()->get('settings')[0]['transaction_prefix']),
            'amount'                => $result['paid_amount'],
            'description'           => "Received from Bed Charge. <a target='_blank' href='{$url}'>{$invoice}</a>",
            'vendor_id'             => $patientId,
            'user_id'               => Sentinel::getUser()->id,
            'module'                => 'Hospital',
            'sub_module'            => 'Hospital-BedChargeCollection',
            'created_at'            => now(),
        ]);
        return $trans->id;
    }

    private function dataCalculation($request){
        $result = [];
        $result['sub_total']            = $request->sub_total;
        $result['discount']             = $request->discount;
        $result['grand_total']          = $result['sub_total'] - $result['discount'];

        if ($result['grand_total'] <= $request->paid_amount) {
            $result['due']          = 0;
            $result['change']       = $request->paid_amount - $result['grand_total'];
            $result['paid_amount']   = $request->paid_amount;
            $result['actualPaidAmount']   = $result['grand_total'];
        } else {
            $result['due']          = $result['grand_total'] - $request->paid_amount;
            $result['change']       = 0;
            $result['paid_amount']   = $request->paid_amount;
            $result['actualPaidAmount']   = $request->paid_amount;
        }
        return $result;
    }

    public function invoiceA4($invoice){
       $invoicePrint =  BedChargeCollection::with(['patient','bed_charge_item'])->where('invoice',$invoice)->first();
       //dd($invoicePrint);
       return view('hospital.bedcharge.invoice.invoiceA4',compact('invoicePrint'));
    }
    public function invoicePos($invoice){
        $invoicePrint =  BedChargeCollection::with(['patient','bed_charge_item'])->where('invoice',$invoice)->first();
        return view('hospital.bedcharge.invoice.invoicePos',compact('invoicePrint'));
    }
}
