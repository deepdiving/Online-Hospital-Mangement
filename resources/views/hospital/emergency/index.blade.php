@extends('layout.app',['pageTitle' => 'Emergency'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Emergency
@endslot
@endcomponent

@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body p-b-0">
                <div class="table-responsive">
                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr class="themeThead">
                                <th width="80"> {{ __('messages.sl')}}</th>
                                <th width="200">Patient Name</th>
                                <th width="200">Invoice No</th>
                                <th class="text-right" width="200">{{ __('messages.paid_amount')}}</th>
                                <th class="text-right" width="200">Due</th>
                                <th width="200">Referral Name</th> 
                                <th width='150'>{{ __('messages.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                             @php $i = 0; @endphp
                            @foreach($emergency_data as $emr)
                            <tr>
                                <td>{{ sprintf("%02s",++$i) }}</td> 
                                <td>{{ $emr->patient->patient_name }}</td>
                                <td>{{ $emr->invoice }}</td>
                                <td class="text-right">{{ Pharma::amountFormatWithCurrency($emr->paid_amount) }}</td>
                                <td class="text-right">{{ Pharma::amountFormatWithCurrency($emr->due) }}</td> 
                                <td>{{ $emr->referral->name }}</td> 
                                <td style="display: flex; justify-content: space-evenly;">
                                    <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/emergency/invoice/a4/'.$emr->invoice)}}"><i class="mdi mdi-format-align-justify"></i> A4</a> 
                                    <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/emergency/invoice/pos/'.$emr->invoice)}}"><i class="mdi mdi-format-align-justify"></i> Pos</a> 
                                    @if(Sentinel::getUser()->id == $emr->user_id || Sentinel::getUser()->inRole('admin'))
                                        <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{url('hospital/emergency/'.$emr->invoice.'/edit')}}"><i class="fa fa-edit"></i> Edit</a> 
                                        <form action="{{url('hospital/emergency/void/'.$emr->slug)}}" method="post" style="margin-top:-2px" id="deleteButton{{$emr->id}}">
                                            @csrf
                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$emr->id}})"><i class="mdi mdi-backup-restore"></i> Void</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody> 
                    </table>
                </div>
                       
            </div>
        </div>
    </div>
</div>
@include('elements.dataTableOne')
@endsection