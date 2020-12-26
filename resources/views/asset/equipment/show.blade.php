@extends('layout.app',['pageTitle' =>'Asset Equipment' ])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
HMS Asset Equipment
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
 <div class="col-md-2"></div>
    <div class="col-lg-8 col-md-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Asset Equipment</h4>
                <h6 class="card-subtitle">Asset Equipment</h6>
                <hr class="hr-borderd">
                <div class="row pt-3 ">  
                    <div class="col-md-2"></div>                
                    <div class="col-md-8 ">
                        <h3 diplay-3 pt-1>{{ucfirst($equipment->item_name)}}</h3>
                        <table class="table table-striped m-t-20"> 
                            <tr>
                                <td width='200'>Description</td>
                                <td  width='5'>:</td>
                                <td>{{($equipment->description)}}</td>
                            </tr>
                            <tr>
                                <td width='200'>Model</td>
                                <td  width='5'>:</td>
                                <td>{{($equipment->model)}}</td>
                            </tr>                         
                            <tr>
                                <td>#Identification</td>
                                <td>:</td>
                                <td>{{$equipment->identification_no}}</td>
                            </tr>
                            <tr>
                                <td>Serial Number</td>
                                <td>:</td>
                                <td>{{$equipment->serial_number}}</td>
                            </tr>
                            <tr>
                                <td>Current Status</td>
                                <td>:</td>
                                <td>{{$equipment->current_status}}</td>
                            </tr>
                            <tr>
                                <td>Condition</td>
                                <td>:</td>
                                <td>{{$equipment->condition}}</td>
                            </tr>
                            <tr>
                                <td>Received Date</td>
                                <td>:</td>
                                <td>{{Pharma::dateFormat($equipment->received_date)}}</td>
                            </tr>

                            <tr>
                                <td>Acquisition Cost</td>
                                <td>:</td>
                                <td>{{$equipment->acquisition_cost}}</td>
                            </tr>
                            <tr>
                                <td>Asset Category </td>
                                <td>:</td>
                                <td>{{$equipment->category->name}}</td>
                            </tr>
                            <tr>
                                <td>Asset Location</td>
                                <td>:</td>
                                <td>{{$equipment->location->name}}</td>
                            </tr>                           
                        </table>                       
                        <a href="{{url('asset/equipment/')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>


@endsection

@push('js')
<script src="{{ asset('js') }}/sweetalert.min.js"></script> 
@endpush
