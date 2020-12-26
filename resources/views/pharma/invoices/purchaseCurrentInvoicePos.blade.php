@extends('layout.app',['pageTitle' => $purchase->invoice])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        {{  __('messages.sale')  }}
    @endslot
@endcomponent


@push('css') 
<style>
.posInvoice{
    width: 500px;
    margin: auto;
}
    
@page {
    size: A4;
    margin: 0;
}
@media print {
    html, body {
        width: 95mm;
        height: 297mm;  
        margin: 0 auto;      
    }
   
}
tbody.borderhade tr {
    border-top: 2px dashed #d4d2d2;
}
.borderdobul{
    border-top: double;
    margin-top: -15px !important;
} 
.table td{
    padding: 0px !important;
}  
</style>
@endpush
<div class="row posInvoice">
    <div class="col-lg-12 col-md-12 m-t-40">
        <div id="invoice">
           <div class="card">
            <div class="card-body"> 
                <button id="printInvoice" class="btn btn-info print-window"><i class="fa fa-print"></i> {{ __('messages.print') }}</button>
                   <h4 class="text-center font-weight-bold">Diagnostic {{session()->get('settings')[0]['site_name']}}</h4>
                    <p class="text-center">{{session()->get('settings')[0]['address']}} <br> {{session()->get('settings')[0]['phone_number']}}</p>
                    <p class="d-inline-block">
                        {{$purchase->manufacturer->manufacturer_name}} <br> 
                        {{$purchase->manufacturer->address}} <br> 
                        {{$purchase->manufacturer->phone}}
                    </p>
                    <p class="float-right">  
                       #{{$purchase->invoice}} <br>
                        {{Pharma::dateFormat($purchase->date)}}  
                    </p>  
                   
                    <table class="table table-borderd">
                        <thead>
                            <tr>
                                <th width="50" class="text-center">{{ __('messages.sl') }}</th>
                                <th>{{ __('messages.item') }}</th>
                                <th class="text-right">Price</th>
                            </tr>
                        </thead>
                        <tbody class="borderhade">
                            @php $sl = 0; @endphp
                            @foreach($purchase->purchaseItems as $productList)
                            <tr>
                                <td class="text-center">{{ sprintf('%02s',++$sl) }}</td>
                                <td>
                                    {{$productList->product->title}} <br>
                                    <small>
                                        <i>
                                                Exp: {{Pharma::dateFormat($productList->batch->expiry_date)}} <br>
                                                Batch No: {{$productList->batch->batch_number}}<br>
                                                {{$productList->qty}} {{$productList->product->unit->unit_name}} x {{($productList->unit_price)}} 
                                            </i>
                                        </small>
                                </td>
                                <td class="text-right"> 
                                    {{Pharma::amountFormatWithCurrency($productList->total_price)}} 
                                    </td>
                            </tr>
                           @endforeach
                           <table class="table font-weight-bold borderdobul">
                                <tr>
                                    <td class="text-right">Sub Total</td>
                                    <td width="5">:</td>
                                    <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($purchase->purchase_amount) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right">Grand Total</td>
                                    <td width="5">:</td>
                                    <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($purchase->grand_total) }}</td>
                                </tr>
                                <tr>
                                   <td class="text-right">Discount</td>
                                    <td width="5">:</td>
                                    <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($purchase->discount) }}</td> 
                                </tr>
                                <tr>
                                    <td class="text-right">Paid Amount</td>
                                    <td width="5">:</td>
                                    <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($purchase->payable_amount) }}</td>
                                </tr> 
                        </table> 
                            
                        </tbody>
                    </table> 

                    <div class="text-center">
                        Thank You
                    </div>    
            </div>
        </div> 
        </div> 
    </div>
</div>  
@endsection
@include('elements.print')
@if(isset($_GET['print']))
@push('js')
<script>
    $(document).ready(function(){
        setTimeout(function(){
            $('#printInvoice').click()
        },1000);
    });
</script>
@endpush
@endif