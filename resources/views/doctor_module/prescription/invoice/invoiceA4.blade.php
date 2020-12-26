@extends('layout.app',['pageTitle' => 'Prescription'])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        prescription 
    @endslot
@endcomponent
<style>
    .per30{
        width: 30px; !important;
    }
    .per50{
        width: 50px; !important;
    }
    .per80{
        width: 80px; !important;
    }
    .per120{
        width: 120px; !important;
    }
    .prescriptionBody{
        min-height:395px;
    }
    .customFont{
        font-family: cursive;
        font-style: oblique;
        text-align: justify;
    }
    @media print {
        @page {
            size: a4;
        }
        .row{
            width: 100%;
        }
        .col-md-4{
            width: 30% !important; 
        }
        .col-md-8{
            width: 70% !important; 
        }
        .prescriptionBody{
            min-height:200px !important;
        }
        .per30{
            width: 30px; !important;
        }
        .per50{
            width: 50px; !important;
        }
        .per80{
            width: 80px; !important;
        }
        .per120{
            width: 120px; !important;
        }
    }

</style>
@include('elements.alert')

<div class="row posInvoice"> 
     <div class="col-md-12"> 
         <div class="card">  
             <div class="card-body m-t-0">
                @if(Sentinel::getUser()->inRole('doctor'))
                    <a class="btn btn-info" href="{{url('prescription')}}"><i class="mdi mdi-plus-circle"></i>   New Prescription</a>
                @endif
                <span class="btn btn-success" onclick="invoiceprint()"><i class="mdi mdi-printer"></i>  Print</span>
            <div id="printArea">
                <div class="pre-head d-flex justify-content-between">
                    <div class="patient m-l-20 m-t-20">
                        <h3> <small>Patient #{{ $invoicePrint->patient->slug }} </small> <br> {{ $invoicePrint->patient->patient_name}}</h3>
                        <p>{{ $invoicePrint->patient->age }} years <br> {{ $invoicePrint->patient->phone }}</p>
                    </div>
                    <div class="doctor m-r-20 m-t-20">
                        <h3> <small>Prescription #{{$invoicePrint->invoice}}</small><br>
                        {{ $invoicePrint->doctor->full_name }}</h3>
                        <p>{{$invoicePrint->doctor->designation}} <br> {{$invoicePrint->doctor->phone_no}}</p>
                    </div>
                </div>
                <div class="row m-t-20 b-t-2">
                    <div class="col-md-4 pb-4 b-r-2 pt-2">
                        <p class="font-weight-bold mb-2">Symptoms :</p>
                            <p class="customFont ml-4">{!! $invoicePrint->symptoms !!}</p>
                        <p class="font-weight-bold mb-2">Diagnosis :</p>
                            <p class="customFont ml-4">{{ $invoicePrint->diagnosis }}</p>
                        <hr>
                        
                        <p class="font-weight-bold mb-2">Tests :</p>

                        <ul class="customFont">
                            @foreach($invoicePrint->pretest as $row) 
                                <li>{{$row->test}}</li>
                            @endforeach
                        </ul>
                        <br>
                        <p class="font-weight-bold mb-2">Next Appontment :</p>
                        <p class="ml-4">{{Pharma::dateFormat($invoicePrint->next_appointment)}}<p>
                        
                    </div>
                    <div class="col-md-8 pb-4 pt-2">
                        <img src="{{asset('rx.png')}}" alt="" height="50" width="50">
                        <br>
                        <br>
                        <div class="prescriptionBody">
                        <table class="table table-borderd customFont">
                            <tr>
                                <th class="per30">SL</th>
                                <th>Medicine</th>
                                <th class="per50">Routine</th>
                                <th class="per30">Days</th>
                                <th class="per120">When/where</th> 
                            </tr>
                            <?php $i = 0;?>
                            @foreach($invoicePrint->premedicineitem as $row)
                            <tr>
                                <td>{{sprintf('%02d',++$i)}}</td>
                                <td>{{$row->medicine}}</td>
                                <td>{{$row->dose}}</td> 
                                <td>{{$row->days}}</td>
                                <td>{{$row->use_time}} </td> 
                            </tr> 
                            @endforeach
                    </table> 
                    </div>
                    <p class="font-weight-bold mb-2">Advices :</p>
                     <p class="customFont ml-4">{{ $invoicePrint->advices }}</p>
                </div>
            </div>
            </div>
         </div>
     </div>   
</div>
@include('elements.dataTableOne')
@endsection 
@push('js')
<script src='{{ asset('js') }}/print.js'></script>
<script>
    function invoiceprint(){
        $("#printArea").print();
    }   
</script>
@endpush


@if(isset($_GET['print']))
@push('js')
<script>
    $(document).ready(function(){
        setTimeout(function(){
            invoiceprint();
        },500);
    });
</script>
@endpush
@endif