@extends('layout.app',['pageTitle' => 'Test List'])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        Test 
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-5 col-md-5">
           <div class="card card-outline-inverse">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa fa-user-o"> </i> Pending List</h4>
                </div>

                <div class="card-body pt-0">
                        <table class="table table-stripted table-bordered" id="dataTableNoPaging">
                            <thead>
                                <tr class="">
                                    <th width="80"> {{ __('messages.sl')}}</th>
                                    <th>#Id</th>
                                    <th  width="200">Paitent</th> 
                                    <th>Delivery</th>
                                </tr>
                            </thead>
                                <tbody>
                                <?php $i = 0;?>
                                @foreach($bills as $bill)
                                @if(count($bill->labReports) <= 0)
                                    <tr>
                                        <td>{{ sprintf("%02s",++$i) }}</td>
                                        <td><a  href="{{url('lab/make/report/'.$bill->invoice)}}">#{{ $bill->invoice }}</a> </td>
                                        <td>{{ $bill->patient->patient_name }}</td>  
                                        <td> {{date('d M',strtotime($bill->delivary_date)) }} {{ date('g:i A', strtotime($bill->delivary_time)) }} </td> 
                                    </tr>
                                @endif
                                @endforeach
                            </tbody>  
                        </table>
                </div>
            </div>   
        </div>
        <div class="col-lg-7 col-md-7">
           <div class="card card-outline-inverse">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Done list</h4>
                </div>
                <div class="card-body pt-0">
                        <table class="table table-bordered table-striped" id="example22">
                            <thead>
                                <tr class="">
                                    <th width="80"> {{ __('messages.sl')}}</th>
                                    <th>#id</th>
                                    <th  width="200">Paitent</th>  
                                    <th>Report Delivery</th>
                                    <th>Reports</th>
                                </tr>
                            </thead>
                                <tbody>
                                <?php $i = 0;?>
                                @foreach($bills as $bill)
                                @if(count($bill->labReports) > 0)
                                        <tr>
                                            <td>{{ sprintf("%02s",++$i) }}</td>
                                            <td><a  href="{{url('lab/make/report/'.$bill->invoice)}}">#{{ $bill->invoice }}</a> </td>
                                            <td>{{ $bill->patient->patient_name }}</td>  
                                            <td> {{date('d M',strtotime($bill->delivary_date)) }} {{ date('g:i A', strtotime($bill->delivary_time)) }} </td> 
                                            <td>
                                                @foreach($bill->labReports as $report)
                                                    @if($report->status == 'Active')
                                                        <a target="_blank" class="btn btn-primary btn-sm" href="{{url('laboratory/invoice/a4/'.$report->invoice)}}">#{{$report->invoice}}</a>
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>   
        </div>
    </div>
@include('elements.dataTableOne')
@endsection