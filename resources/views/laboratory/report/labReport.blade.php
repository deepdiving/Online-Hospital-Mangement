@extends('layout.app',['pageTitle' => 'Report List'])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        Report 
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row"> 
        <div class="col-lg-5 col-md-5">
           <div class="card">
                <div class="card-body">
                        <div class="Content">
                            <div class="patientInfo d-flex justify-content-between">
                                <p>
                                    #{{ $invoicePrint->patient->slug }} <br>
                                    {{ $invoicePrint->patient->patient_name }} <br>
                                    {{ $invoicePrint->patient->address }} <br>
                                    {{ $invoicePrint->patient->phone }}
                                </p>
                                <p>
                                    #{{ $invoicePrint->invoice }} <br>
                                    {{ date('d-M-Y', strtotime($invoicePrint->date)) }} <br>
                                    {{Pharma::dateFormat($invoicePrint->delivary_date) }} {{ date('g:i a', strtotime($invoicePrint->delivary_time)) }}
                                </p>
                            </div>
                            <table class="table table-bordered table-hover Content" id="myTable">
                                <thead>
                                    <tr class="">
                                        <th width="50">{{__('messages.sl')}}</th> 
                                        <th>Test Name</th>  
                                    </tr>
                                </thead>
        
                                    <tbody>
                                    <?php $i = 0;?>
                                    @foreach($invoicePrint->billItem as $row) 
                                        <tr>
                                            <td>{{ sprintf('%02d',++$i) }}</td>
                                                <td>{{ $row->test->name }}</td> 
                                        </tr> 
                                    @endforeach
                                </tbody> 
                            </table>
                        </div>

                </div> 
            </div>
        </div> 
        <div class="col-lg-7 col-md-7">  
            <div class="card"> 
                    <div class="card-body">   
                        <div class="patientInfo d-flex justify-content-between">
                            <p>
                                #{{ $invoicePrint->patient->slug }} <br>
                                {{ $invoicePrint->patient->patient_name }} <br>
                                {{ $invoicePrint->patient->address }} <br>
                                {{ $invoicePrint->patient->phone }}
                            </p>
                            <p>
                                #{{ $invoicePrint->invoice }} <br>
                                {{ date('d-M-Y', strtotime($invoicePrint->date)) }} <br>
                                {{Pharma::dateFormat($invoicePrint->delivary_date) }} {{ date('g:i a', strtotime($invoicePrint->delivary_time)) }} <br>
                                mohoaisdflk 
                            </p>
                        </div>
                        <hr>
                        <br>
                        <form action="{{ route('laboratory.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <textarea id="summernote" name="content"> 
                                <h4 class="font-weight-bold">Report Name :&nbsp;</h4> <br>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Test Name</th>
                                            <th width="100">Result</th>
                                            <th width="150">Normal Value</th>
                                            <th width="180">Comments</th>
                                        </tr> 
                                    </thead>

                                    <tbody>
                                        @foreach($invoicePrint->billItem as $row) 
                                            <tr>
                                                <td>{{$row->test->name}}</td>
                                                <td class="text-center"></td>
                                                <td class="text-center">-</td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <p>
                                    Remarks:
                                </p>
                            </textarea>
                        </div>
                        <input type="hidden" name="diagon_bill_id" value="{{$invoicePrint->id}}">
                        <input type="hidden" name="patient_id" value="{{$invoicePrint->patient->id}}">
                        <div class="card-footer">
                            <button class="float-right btn btn-success btn-lg" type="submit"><i class="fa fa-floppy-o"></i> Save & Print</button>
                        </div>
                </form>    
             </div>
         </div>  
    </div>
</div>
{{-- @include('elements.dataTableOne') --}}
@endsection
@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
  
@endpush
@push('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>
<script>
    $('#summernote').summernote({
     airMode: true
    });
</script>
@endpush
