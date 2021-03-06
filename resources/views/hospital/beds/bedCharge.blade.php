@extends('layout.app',['pageTitle' => 'Bed Charge'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Bed Charge Collection
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
                                <th>Admission No</th>
                                <th>Bed Name</th>
                                <th>Invoice No</th>
                                <th class="text-right">{{ __('messages.paid_amount')}}</th>
                                <th class="text-right">Due</th>    
                                <th width='150'>{{ __('messages.action')}}</th>
                            </tr>
                        </thead>
                            <tbody> 
                            <?php $i = 0;?>
                            @foreach($bedCollection as $row)
                            <tr>
                                <td>{{ sprintf("%02s",++$i) }}</td> 
                                <td>{{ $row->patient->patient_name }}</td>
                                <td>{{ $row->patient->admission->invoice }}</td>
                                <td>{{ $row->patient->admission->bed->bed_no }}</td>
                                <td>{{ $row->invoice }}</td>
                                <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->paid_amount) }}</td>
                                <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->due) }}</td>
                                <td style="display: flex; justify-content: space-evenly;">
                                    <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/bedcharge/invoice/a4/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> A4</a> 
                                    <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/bedcharge/invoice/pos/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> Pos</a>
                                    {{-- <a class="btn waves-effect waves-light text-light btn-xs btn-info" href="{{url('hospital/admission/'.$admission->invoice.'/edit')}}"><i class="fa fa-info"></i> Service</a> 
                                    <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{url('hospital/admission/discharge/'.$admission->slug)}}"><i class="fa fa-edit"></i> Discharge</a> 
                                    <form action="{{url('hospital/admission/void/'.$admission->slug)}}" method="post" style="margin-top:-2px" id="deleteButton{{$admission->id}}">
                                        @csrf
                                        <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$admission->id}})"><i class="mdi mdi-backup-restore"></i> Void</button>
                                    </form> --}}
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