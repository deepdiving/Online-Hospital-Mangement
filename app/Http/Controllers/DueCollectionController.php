<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DueCollection;
use App\DueCollectionItem;
use App\Transation;
use App\Models\diagnostic\Bill;
Use Sentinel;
use Pharma;
use Session;
class DueCollectionController extends Controller
{
    public function index(){
        //$module = Pharma::getModule();
        $deuCollections = DueCollection::with('patient')->orderBy('id','DESC')->get();
        return view('dues.due.index',compact('deuCollections'));
    }

    public function create(){
        return view('dues.due.create');
    }
    
    public function store(Request $request){
        $total_amount       = array_sum($request->amount);
        $invoice            = Pharma::GenarateInvoiceNumber('due_collections','DC');
        $data = [
            'date'          => date('Y-m-d'),
            'slug'          => $invoice,
            'invoice'       => $invoice,
            'amount'        => $total_amount,
            'description'   => $request->description,
            'patient_id'    => $request->patient_id,
            'user_id'       => Sentinel::getUser()->id,
            'module'        => $request->module,
            'sub_module'    => $request->sub_module,                
            'created_at'    => now(),
        ];

        $due = DueCollection::create($data);
        $this->DueItems($due->id,$request);
        if($total_amount > 0){
            $transId = $this->makeTransaction($invoice,$request);
            $due->trans_id = $transId;
            $due->save();
        }

        Session::flash('success','Due Collected Succeed!');
        Pharma::activities("Collected", "Due", "Due Collected");
        return redirect()->back();
    }

    private function makeTransaction($invoice,$request){
        $transaction = New Transation;
        $url = url('accounts/due/invoice/a4/'.$invoice);
        $trans = $transaction->create([
            'date'                  => date('Y-m-d'),
            'trans_id'              => Pharma::GenarateInvoiceNumber('transations',session()->get('settings')[0]['transaction_prefix']),
            'amount'                => array_sum($request->amount),
            'description'           => "Received from Due Collection. <a target='_blank' href='{$url}'>{$invoice}</a>",
            'vendor_id'             => $request->patient_id,
            'user_id'               => Sentinel::getUser()->id,
            'transaction_type'      => 'Collection',
            'module'                => $request->module,
            'sub_module'            => $request->sub_module,
            'created_at'            => now(),
        ]);
        return $trans->id;
    }

    public function DueItems($dueId,$request){
        $items = new DueCollectionItem;
        for ($i = 0; $i < count($request->invoice); $i++) {
            $amount = empty($request->amount[$i]) ? 0 : $request->amount[$i];
            $item = [
                'date'              => date('Y-m-d'),
                'amount'            => $amount,
                'patient_id'        => $request->patient_id,
                'due_collection_id' => $dueId,
                'table_id'          => $request->invoice[$i],
                'table'             => $request->table,
                'user_id'           => Sentinel::getUser()->id,
                'created_at'        => now(),
            ];
            $items->create($item);
            Pharma::StockIncrement($request->table,'due_collection',$request->invoice[$i],$amount);
        }        
    }

    public function invoiceA4($invoice){

        $invoicePrint = DueCollection::with(['patient','duecollectionitem'])->where('invoice',$invoice)->first();
        // dd($invoicePrint);
        // $invoicePrint = DueCollection::where('invoice',$invoice)->first();
        return view('dues.invoice.invoiceA4',compact('invoicePrint'));
   }

   public function invoicePos($invoice){ 
    $invoicePrint = DueCollection::with(['patient','duecollectionitem'])->where('invoice',$invoice)->first();
    return view('dues.invoice.invoicePos',compact('invoicePrint'));
    }

}    


