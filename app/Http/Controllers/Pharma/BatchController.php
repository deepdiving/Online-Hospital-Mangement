<?php

namespace App\Http\Controllers\Pharma;
use App\Http\Controllers\Controller;
use App\Models\Pharma\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sentinel;
use Session;
use Pharma;

class BatchController extends Controller
{
    public function __construct(){
        $this->middleware(['authorized','pharma']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Batch $batch)
    {
        $batch_number = Pharma::GenarateInvoiceNumber('pharma_batches',session()->get('settings')[0]['batch_prefix']);
        $data = [
            'product_id'        => $request->product_id,
            'purchase_id'       => 0,
            'purchase_item_id'  => 0,
            'batch_number'      => $batch_number,
            'in_stock'          => $request->stock,
            'expiry_date'       => date('Y-m-d',strtotime($request->expiry_date)),
            'status'            => 'Active',
            'created_at'        => now(),
        ];
        $data =  $batch->create($request->merge($data)->all());
        DB::table('pharma_products')->where('id',$request->product_id)->increment('stock',$request->stock);
        Pharma::activities("Added", "Batch", "Added a new batch '{$batch_number}'");
        echo json_encode($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Batch $batch)
    {   
        // dd($batch);
        $data = [
            'in_stock' => $batch->in_stock,
            'expiry_date' => $batch->expiry_date,
            'mrp'       => DB::table('pharma_products')->where('id',$batch->product_id)->first()->sale_price
        ];
        echo json_encode($data);
        // $product->load('unit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    public function delete($id)
    {
        $batch = Batch::find($id);
        DB::table('pharma_products')->where('id',$batch->product_id)->decrement('stock',$batch->in_stock);
        Pharma::activities("Deleted", "Batch", "Deleted a batch '{$batch->batch_number}'");
        Batch::destroy($id);
        echo 'OK';
    }

    public function getBatchProduct($product_id){
        $products = Batch::where('product_id',$product_id)->where('expiry_date','>=',date('Y-m-d'))->where('status','Active')->get()->toArray();
        echo json_encode($products);
    }

    public function batchSaggestion($key){
        $batches = DB::table('pharma_batches')->where('expiry_date','>=',date('Y-m-d'))->where('status','Active')->where('batch_number', 'like', '%'.$key.'%')->get();
        // dd($batches);
        $html = '';
        if(count($batches) > 0) {
            $html .= '<ul class="suggesstion-box-ul">';
            foreach($batches as $batche) {
                $html .= '<li class="suggesstion-box-li" onClick="selectBatch(\''.$batche->batch_number.'\')">'.$batche->batch_number.'</li>';                         
            }
            $html .= '</ul>';
        }else{
            $html .= '<ul class="suggesstion-box-ul">';
            $html .= '<li class="suggesstion-box-li">No Result</li>';
            $html .= '</ul>';
        }
        echo $html;//json_encode($products);
    }
}
