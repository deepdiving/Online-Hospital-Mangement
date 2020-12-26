@extends('layout.app',['pageTitle' => __('All Transactions')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.transaction') }}
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12"> 
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="Content">
                                <table class="table table-bordered table-hover Content" id="dataTableNoPaging">
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
                                        @foreach($bills as $bill)
                                        <tr>
                                            <td>{{ sprintf("%02s",++$i) }}</td>
                                            <td> {{date('d M',strtotime($bill->delivary_date)) }} {{ date('g:i A', strtotime($bill->delivary_time)) }} </td> 
                                            <td>{{ $bill->invoice }}</td>
                                            <td>{{ $bill->patient->patient_name }}</td>
                                            <td class="text-right">{{ Pharma::amountFormatWithCurrency($bill->actual_paid_amount) }}</td>
                                            <td class="text-right">{{ Pharma::amountFormatWithCurrency($bill->due) }}</td>
                                            <td>{{ $bill->referral->name }}</td> 
                                            <td style="display: flex; justify-content: space-evenly;">
                                                <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('diagnostic/bill/invoice/a4/'.$bill->invoice)}}"><i class="mdi mdi-format-align-justify"></i> A4</a> 
                                                <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('diagnostic/bill/invoice/pos/'.$bill->invoice)}}"><i class="mdi mdi-format-align-justify"></i> Pos</a> 
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        
                                    </tfoot>
                            </table>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    @include('elements.dataTableOne')
@endsection
