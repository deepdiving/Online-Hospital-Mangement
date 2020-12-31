
@extends('layout.app',['pageTitle' => 'New Service Category'])
@section('content')

@push('css')
<style>

@media print {
    @page {
        size: landscape;
    }
    .row{
        width: 100%;
    }
    .col-md-6{
        width: 50% !important; 
    }
}
tbody.borderhade tr {
    border-top: 2px dashed #d4d2d2;
}
.borderdobul{
    border-top: double;
    margin-top: -15px !important;
}
.b-r{
    border-right: 2px dashed #ddd !important;
}
.table td{
    padding: 0px !important;
}
.m-l{
    margin-left:160px;
}

</style>
@endpush  
<button class="btn btn-success m-t-40 buttonstyle" onclick="invoiceprint()">Print</button>
<div class="row posInvoice m-t-40"> 
    <div class="col-lg-12 col-md-12">
        
            <div class="card">
                <div class="card-body"> 
                    <div id="printArea">
                        <div class="row">
                            <div class="col-md-6 b-r">
                                <h4 class="text-center font-weight-bold">{{session()->get('settings')[0]['site_name']}}</h4>
                                <p class="text-center">{{session()->get('settings')[0]['address']}} <br> {{session()->get('settings')[0]['phone_number']}}</p>
                                <p class="d-inline-block">
                                  ID: #{{ $invoicePrint->patient->slug }} <br>
                                    {{ $invoicePrint->patient->patient_name }} <br>
                                    {{ $invoicePrint->patient->address }} <br>
                                    {{ $invoicePrint->patient->phone }}
                                </p>
                                <p class="float-right mt-1">
                                   INV: #{{ $invoicePrint->invoice }} <br>
                                    {{ date('d-M-Y', strtotime($invoicePrint->date)) }} <br>
                                    {{Pharma::dateFormat($invoicePrint->admit_date) }} {{ date('g:i a', strtotime($invoicePrint->admit_time)) }}<br>
                                    Update At: {{Pharma::dateFormat($invoicePrint->updated_at) }}
                                </p>    
                                <h5 class="text-center  font-weight-bold m-l">Office Copy</h5>
                                <table class="table table-borderd">
                                    <thead class="">
                                        <tr>
                                            <th width="50" class="text-center">SL</th>
                                            <th>Service Name</th>
                                            <th width="100" class="text-right">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="borderhade">
                                       <?php $sl = 0; ?> 
                                        @foreach($invoicePrint->given_services as $row)
                                            <tr class="">
                                                <td class="text-center">{{ sprintf('%02d',++$sl) }}</td>
                                                <td>{{ $row->service_name }}. ({{Pharma::dateFormat ($row->service_date) }})</td>
                                                <td class="text-right"> {{ Pharma::amountFormatWithCurrency($row->service_price) }}</td>
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
                                        <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->discount_total) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Grand Total</td>
                                        <td width="5">:</td>
                                        <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->grand_total) }}</td>
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
                                    @if($invoicePrint->change > 0)
                                    <tr>
                                        <td class="text-right">Advance Amount</td>
                                        <td width="5">:</td>
                                        <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->change) }}</td>
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
                                    </p> <p class="float-right text-right m-l-20">
                                            Receive: {{ $invoicePrint->user->name }}
                                    </p> 
                                    </div> 
                                </div> 
                            </div>

                            <div class="col-md-6">
                                <h4 class="text-center font-weight-bold">Hospital {{session()->get('settings')[0]['site_name']}}</h4>
                                    <p class="text-center">{{session()->get('settings')[0]['address']}} <br> {{session()->get('settings')[0]['phone_number']}}</p>
                                    <p class="d-inline-block">
                                      ID: #{{ $invoicePrint->patient->slug }} <br>
                                        {{ $invoicePrint->patient->patient_name }} <br>
                                        {{ $invoicePrint->patient->address }} <br>
                                        {{ $invoicePrint->patient->phone }}
                                    </p>
                                    <p class="float-right mt-1">
                                     INV: #{{ $invoicePrint->invoice }} <br>
                                        {{ date('d-M-Y', strtotime($invoicePrint->date)) }} <br>
                                        {{Pharma::dateFormat($invoicePrint->admit_date) }} {{ date('g:i a', strtotime($invoicePrint->admit_time)) }}<br>
                                        Update At: {{Pharma::dateFormat($invoicePrint->updated_at) }}
                                    </p>    
                                <h5 class="text-center font-weight-bold m-l">Paitent Copy</h5>
                                <table class="table table-borderd">
                                    <thead class="">
                                        <tr>
                                            <th width="50">SL</th>
                                            <th>Service Name</th> 
                                            <th width="100" class="text-right">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="borderhade">
                                       <?php $sl = 0; ?> 
                                        @foreach($invoicePrint->given_services as $row)
                                            <tr class="">
                                                <td class="text-center">{{ sprintf('%02d',++$sl) }}</td>
                                                <td>{{ $row->service_name }}. ({{Pharma::dateFormat ($row->service_date) }})</td>
                                                <td></td>
                                                <td class="text-right"> {{ Pharma::amountFormatWithCurrency($row->service_price) }}</td>
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
                                        <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->discount_total) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Grand Total</td>
                                        <td width="5">:</td>
                                        <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->grand_total) }}</td>
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
                                    @if($invoicePrint->change > 0)
                                    <tr>
                                        <td class="text-right">Advance Amount</td>
                                        <td width="5">:</td>
                                        <td wdth="100" class="text-right">{{ Pharma::amountFormatWithCurrency($invoicePrint->change) }}</td>
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
                                    </p> <p class="float-right text-right m-l-20">
                                            Receive: {{ $invoicePrint->user->name }}
                                    </p> 
                                    </div> 
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
        $("#printArea").print();
    }   
</script>
@endpush