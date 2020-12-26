@extends('layout.app',['pageTitle' => 'Report List'])
@section('content')

@push('css')
<style>

@media print {
    @page {
        size: A4;
    }
    .row{
        width: 100%;
    }
    .col-md-6{
        width: 50% !important; 
    }
}

.table td{
    padding: 0px !important;
}
.invoice-box table td {
    padding: 5px !important;
    vertical-align: top;
}
</style>
@endpush  

@component('layout.inc.breadcrumb')
    @slot('title')
        Report 
    @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div id="invoice">
                <div class="toolbar hidden-print" id="printSection">
                    <div class="text-right" id="buttontPlace">
                        <button id="printInvoice" class="btn btn-info print-window"><i class="fa fa-print"></i> {{ __('messages.print') }}</button>
                        <a href="{{ URL::previous() }}" class="btn btn-info aa"><i class="fa fa-angle-left"></i> {{ __('messages.back') }}</a>
                    </div>
                    <hr>
                </div>

                <div class="invoice-box">
                    <div class="d-flex justify-content-between">
                        <p>
                            #{{ $reports->patient->slug }} <br>
                            {{ $reports->patient->patient_name }} <br> 
                            {{ $reports->patient->address }} <br>
                            {{ $reports->patient->phone }}
                        </p>
                        <p>
                            #{{ $reports->invoice }} <br>
                            {{ date('d-M-Y', strtotime($reports->date)) }} <br>
                            {{Pharma::dateFormat($reports->date) }}
                        </p>
                    </div> 
                    <hr>
                    <div class="mt-4 pt-3 mb-4 pb-4">
                        {!!$reports->content!!} 
                    </div>

                    <div class="d-flex justify-content-between">
                        <p class="d-inline-block m-l8">Thank you</p>                                  
                        <p class="float-right text-right m-l-20">Receive: {{$reports->user->name}} </p>
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