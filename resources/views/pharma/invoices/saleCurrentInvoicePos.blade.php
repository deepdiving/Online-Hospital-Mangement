@extends('layout.app',['pageTitle' => $sale->invoice])
@section('content')

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
.font{
   font-size:12px; 
   margin-bottom: 0px 
}  
</style>
@endpush
<div class="row posInvoice">
    <div class="col-lg-12 col-md-12 m-t-40">
        <div class="card">
            <div class="card-body">
                <button class="btn btn-success" onclick="invoiceprint()">Print</button>
                <div id="printArea">
                    <h4 class="text-center font-weight-bold m-t-40">Diagnostic {{session()->get('settings')[0]['site_name']}}</h4>
                    <p class="text-center">{{session()->get('settings')[0]['address']}} <br> {{session()->get('settings')[0]['phone_number']}}</p>
                    <p class="d-inline-block">
                        {{ $sale->patient->patient_name }} <br> 
                        {{ $sale->patient->address }} <br>
                        {{ $sale->patient->phone }} 
                    </p>
                    <p class="float-right">
                        #{{ $sale->invoice }} <br>
                        {{Pharma::dateFormat($sale->date) }}
                    </p>  
                   
                    <table class="table table-borderd">
                        <thead>
                            <tr>
                                <th width="50" class="text-center">SL</th>
                                <th>Item</th>
                                <th class="text-right">Price</th>
                            </tr>
                        </thead>
                        <tbody class="borderhade">
                            @php $sl = 0; @endphp
                            @foreach($sale->saleItems as $item)
                           <tr>
                               <td class="text-center">{{ sprintf('%02s',++$sl) }}</td>
                               <td>
                                   {{$item->product->title}} <br>
                                   <small>
                                       <i>
                                            Exp: {{Pharma::dateFormat($item->expiry_date)}} <br>
                                            {{$item->sale_qty}} {{$item->product->unit->unit_name}} x {{($item->unit_price)}} Dis: {{($item->unit_price*$item->sale_qty - $item->total_price)}} <small>({{($item->discount_percent)}}%)</small>
                                        </i>
                                    </small>
                               </td>
                               <td class="text-right"> 
                                  {{Pharma::amountFormatWithCurrency($item->total_price)}} 
                                </td>
                           </tr>
                           @endforeach
                           <table class="table font-weight-bold borderdobul">
                        <tr>
                            <td class="text-right">Sub Total</td>
                            <td width="5">:</td>
                            <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($sale->sub_total) }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">Grand Total</td>
                            <td width="5">:</td>
                            <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($sale->grand_total) }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">Paid Amount</td>
                            <td width="5">:</td>
                            <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($sale->paid_amount) }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">Due Amount</td>
                            <td width="5">:</td>
                            <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($sale->grand_total - $sale->paid_amount) }}</td>
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
@push('js')
<script src='{{ asset('js') }}/print.js'></script>
<script>
    function invoiceprint(){
        $("#printArea").print({
            addGlobalStyles : true,
            // stylesheet : "{{ asset('css') }}/print.css",
            // rejectWindow : true,
            noPrintSelector : "#printSection,#footer",
            // iframe : false,
            append : null,
            prepend : "#footer"
        });
    }   
</script>
@endpush