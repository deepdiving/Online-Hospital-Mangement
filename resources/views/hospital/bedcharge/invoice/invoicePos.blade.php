
@extends('layout.app',['pageTitle' => 'Bed Charge'])
@section('content')

@push('css')
<style>
.posInvoice{
    width: 500px;
    margin: auto;
}
    
@page {
    size: 90mm 300mm;
    margin: 0;
}
@media print {
    html, body {
        width: 88mm;
        height: auto;  
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
                    <h4 class="text-center font-weight-bold">Hospital {{session()->get('settings')[0]['site_name']}}</h4>
                    <p class="text-center">{{session()->get('settings')[0]['address']}} <br> {{session()->get('settings')[0]['phone_number']}}</p>
                    <p class="d-inline-block">
                        {{ $invoicePrint->patient->patient_name }} <br>
                        {{ $invoicePrint->patient->address }} <br>
                        {{ $invoicePrint->patient->phone }}<br>
                        Bed No : {{ $invoicePrint->patient->admission->bed->bed_no}}
                    </p>
                    <p class="float-right">
                         #{{ $invoicePrint->invoice }} <br>
                         {{ date('d-M-Y', strtotime($invoicePrint->date)) }} <br>
                         {{Pharma::dateFormat($invoicePrint->date) }}<br>
                         Update At: {{Pharma::dateFormat($invoicePrint->updated_at) }}
                    </p>    
                    <h5 class="text-center  font-weight-bold">Office Copy</h5>
                    <table class="table table-borderd">
                        <thead>
                            <tr>
                                <th width="50" class="text-center">SL</th>
                                <th>Collection Date</th>
                                <th width="100" class="text-right">Price</th>
                            </tr>
                        </thead>
                        <tbody class="borderhade">
                             <?php $sl = 0; ?> 
                            @foreach($invoicePrint->bed_charge_item as $row)
                                <tr class="">
                                    <td class="text-center">{{ sprintf('%02d',++$sl) }}</td>
                                    <td>{{Pharma::dateFormat ($row->collection_date) }}</td>
                                    <td class="text-right"> {{ Pharma::amountFormatWithCurrency($row->amount) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <table class="table font-weight-bold borderdobul">
                        <tr>
                            <td class="text-right">Sub Total</td>
                            <td width="5">:</td>
                            <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->sub_total) }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">Total Discount</td>
                            <td width="5">:</td>
                            <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->discount) }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">Grand Total</td>
                            <td width="5">:</td>
                            <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->sub_total-$invoicePrint->discount_total) }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">Paid Amount</td>
                            <td width="5">:</td>
                            <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->paid_amount) }}</td>
                        </tr>
                        @if($invoicePrint->due > 0)
                        <tr>
                            <td class="text-right">Due Amount</td>
                            <td width="5">:</td>
                            <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->due) }}</td>
                        </tr>
                        @endif
                        @if($invoicePrint->advance > 0)
                        <tr>
                            <td class="text-right">Advance Amount</td>
                            <td width="5">:</td>
                            <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->advance) }}</td>
                        </tr>
                        @endif
                        @if($invoicePrint->due_collection > 0)
                        <tr>
                            <td class="text-right">Due Collection</td>
                            <td width="5">:</td>
                            <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->due_collection) }}</td>
                        </tr>
                        @endif
                    </table> 
                    <div class="row">
                        <div class="col">
                            <p class="d-inline-block m-l-20">
                                    Thank you
                            </p> 
                            <p class="float-right text-right m-l-20">
                                    Receive: {{ $invoicePrint->user->name }}
                            </p> 
                        </div> 
                    </div> 


                    <hr>


                    <h4 class="text-center font-weight-bold">Hospital {{session()->get('settings')[0]['site_name']}}</h4>
                    <p class="text-center">{{session()->get('settings')[0]['address']}} <br> {{session()->get('settings')[0]['phone_number']}}</p>
                    <p class="d-inline-block ">
                        {{ $invoicePrint->patient->patient_name }} <br>
                        {{ $invoicePrint->patient->address }} <br>
                        {{ $invoicePrint->patient->phone }}<br>
                        Bed No : {{ $invoicePrint->patient->admission->bed->bed_no}}
                    </p>
                    <p class="float-right">
                         #{{ $invoicePrint->invoice }} <br>
                         {{ date('d-M-Y', strtotime($invoicePrint->date)) }} <br>
                         {{Pharma::dateFormat($invoicePrint->date) }}<br>
                         Update At: {{Pharma::dateFormat($invoicePrint->updated_at) }}
                    </p>    
                    <h5 class="text-center font-weight-bold">Patient Copy</h5>
                    <table class="table">
                        <thead class="">
                            <tr>
                                <th width="50" class="text-center">SL</th>
                                <th>Collection Date</th>
                                <th width="100" class="text-right">Price</th>
                            </tr>
                        </thead>
                       <tbody class="borderhade">
                             <?php $sl = 0; ?> 
                            @foreach($invoicePrint->bed_charge_item as $row)
                                <tr class="">
                                    <td class="text-center">{{ sprintf('%02d',++$sl) }}</td>
                                    <td>{{Pharma::dateFormat ($row->collection_date) }}</td>
                                    <td class="text-right"> {{ Pharma::amountFormatWithCurrency($row->amount) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <table class="table font-weight-bold borderdobul">
                        <tr>
                            <td class="text-right">Sub Total</td>
                            <td width="5">:</td>
                            <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->sub_total) }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">Total Discount</td>
                            <td width="5">:</td>
                            <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->discount) }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">Grand Total</td>
                            <td width="5">:</td>
                            <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->sub_total-$invoicePrint->discount_total) }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">Paid Amount</td>
                            <td width="5">:</td>
                            <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->paid_amount) }}</td>
                        </tr>
                        @if($invoicePrint->due > 0)
                        <tr>
                            <td class="text-right">Due Amount</td>
                            <td width="5">:</td>
                            <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->due) }}</td>
                        </tr>
                        @endif
                        @if($invoicePrint->advance > 0)
                        <tr>
                            <td class="text-right">Advance Amount</td>
                            <td width="5">:</td>
                            <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->advance) }}</td>
                        </tr>
                        @endif
                        @if($invoicePrint->due_collection > 0)
                        <tr>
                            <td class="text-right">Due Collection</td>
                            <td width="5">:</td>
                            <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->due_collection) }}</td>
                        </tr>
                        @endif
                    </table> 
                     <div class="row">
                        <div class="col">
                            <p class="d-inline-block m-l-20">
                                    Thank you
                            </p> 
                            <p class="float-right text-right m-l-20">
                                    Receive: {{ $invoicePrint->user->name }}
                            </p> 
                        </div> 
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