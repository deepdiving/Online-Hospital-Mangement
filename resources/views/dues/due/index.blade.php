@extends('layout.app',['pageTitle' => 'Due List'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Due List
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
                                <th> {{ __('messages.sl')}}</th>
                                <th>Patient Name</th>
                                <th>Invoice No</th>  
                                <th>Collected Amount</th> 
                                <th width='150'>{{ __('messages.action')}}</th>
                            </tr>
                        </thead>
                            <tbody>
                            <?php $i = 0;?>
                            @foreach($deuCollections as $deuCollection)
                            <tr>
                                <td>{{ sprintf("%02s",++$i) }}</td> 
                                <td>{{ $deuCollection->patient->patient_name }}</td>
                                <td>{{ $deuCollection->invoice }}</td>
                                <td>{{ Pharma::amountFormatWithCurrency($deuCollection->amount) }}</td>                                             
                                <td style="display: flex; justify-content: space-evenly;">
                                    <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('accounts/due/invoice/a4/'.$deuCollection->invoice)}}"><i class="mdi mdi-format-align-justify"></i> A4</a> 
                                    <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('accounts/due/invoice/pos/'.$deuCollection->invoice)}}"><i class="mdi mdi-format-align-justify"></i> Pos</a>
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