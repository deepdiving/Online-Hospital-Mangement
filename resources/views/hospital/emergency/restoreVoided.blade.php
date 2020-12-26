@extends('layout.app',['pageTitle' => __('Bills')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Bill
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
                                <th width="300">Report Delivary</th>
                                <th>Invoice No</th>
                                <th>Paitent Name</th>
                                <th class="text-right">{{ __('messages.paid_amount')}}</th>
                                <th class="text-right">Due</th> 
                                <th>Referral Name</th> 
                                <th width='150'>{{ __('messages.action')}}</th>
                            </tr>
                        </thead>
                            <tbody>
                            <?php $i = 0;?>
                            @foreach($admissions as $row)
                            <tr>
                                <td>{{ sprintf("%02s",++$i) }}</td>
                                <td> {{date('d M',strtotime($row->date)) }} {{ date('g:i A', strtotime($row->time)) }} </td> 
                                <td>{{ $row->invoice }}</td>
                                <td>{{ $row->patient->patient_name }}</td>
                                <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->paid_amount) }}</td>
                                <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->due) }}</td>  
                                <td>{{ $row->referral->name }}</td> 
                                <td style="display: flex; justify-content: space-evenly;">
                                    <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/emergency/invoice/a4/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> A4</a> 
                                    <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/emergency/invoice/pos/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> Pos</a> 
                                    {{-- <form action="{{url('diagnostic/bill/restore/'.$bill->slug)}}" method="post" style="margin-top:-2px" id="deleteButton{{$bill->id}}">
                                        @csrf
                                        <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$bill->id}})"><i class="mdi mdi-backup-restore"></i> Restore</button>
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