@extends('layout.app',['pageTitle' => __('Sale Void List')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ __('messages.sale_voided') }}
@endslot
@endcomponent

@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('messages.sale_list')}}</h4>
                <h6 class="card-subtitle">{{ __('messages.all_sale_list')}}..</h6>
                <hr class="hr-borderd">
                <div class="col-lg-12">
                    <div class="Content">
                        <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr class="themeThead">
                                    <th width="80">{{ __('messages.sl')}}</th>
                                    <th>{{ __('messages.date')}}</th>
                                    <th>{{ __('messages.invoice')}}</th>
                                    <th>{{ trans_choice('messages.customer',1)}}</th>
                                    <th>{{ __('messages.description')}}</th>
                                    <th class="text-right">{{ __('messages.amount')}}</th>
                                    <th width='150'>{{ __('messages.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0;?>
                                @foreach($voided as $sale)
                                <tr>
                                    <td>{{sprintf("%02s",++$i) }}</td>
                                    <td>{{Pharma::dateFormat($sale->date)}}</td>
                                    <td>{{$sale->invoice}}</td>
                                    <td>{{$sale->patient->patient_name}}</td>
                                    <td>{{Pharma::limit_text($sale->description,15)}}</td>
                                    <td class="text-right">{{Pharma::amountFormatWithCurrency($sale->grand_total)}}</td>
                                    <td style="display: flex; justify-content: space-evenly;">
                                        {{-- <button type="button" class="btn waves-effect waves-light btn-xs btn-info" data-toggle="modal" data-target="#MyModal""><i class="fa fa-print" aria-hidden="true"></i></button> --}}
                                        <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{ url('sale/invoice/a4/'.$sale->invoice) }}"><i class="mdi mdi-format-align-justify"></i> Invoice</a>
                                        <form action="{{url('sale/restore/'.$sale->slug)}}" method="post" style="margin-top:-2px" id="deleteButton{{$sale->id}}">
                                            @csrf
                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-success" onclick="sweetalertDelete({{$sale->id}})"><i class="mdi mdi-backup-restore"></i> Restore</button>
                                        </form
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
</div>
@include('elements.dataTableOne')
@endsection