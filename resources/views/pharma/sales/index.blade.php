@extends('layout.app',['pageTitle' => __('Add sale')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ __('messages.sales') }}
@endslot
@endcomponent

@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body p-b-0">
                <ul class="nav nav-tabs customtab2" role="tablist">
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home7" role="tab" aria-expanded="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">{{ __('messages.active') }}</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile7" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">{{ __('messages.voided') }}</span></a> </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="home7" role="tabpanel" aria-expanded="true">
                        <div class="pb-4">
                            <div class="table-responsive">
                                <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr class="themeThead">
                                            <th width="80"> {{ __('messages.sl')}}</th>
                                            <th>{{ __('messages.date')}}</th>
                                            <th width="150">{{ __('messages.invoice')}}</th>
                                            <th>{{ __('messages.customer_name')}}</th>
                                            <th>{{ __('messages.description')}}</th>
                                            <th class="text-right">{{ __('messages.grand_total')}}</th>
                                            <th width='150'>{{ __('messages.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0;?>
                                        @foreach($sale as $sale)
                                        <tr>
                                            <td>{{sprintf("%02s",++$i) }}</td>
                                            <td>{{Pharma::dateFormat($sale->date)}}</td>
                                            <td>
                                                {{$sale->invoice}}
                                            </td>
                                            <td>{{$sale->patient->patient_name}}</td>
                                            <td>{{Pharma::limit_text($sale->description,15)}}</td>
                                            <td class="text-right">{{ Pharma::amountFormatWithCurrency($sale->grand_total)}}</td>
                                            <td style="display: flex; justify-content: space-evenly;">
                                                <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{ url('sale/invoice/a4/' . $sale->invoice) }}"><i class="mdi mdi-format-align-justify"></i> A4</a>
                                                <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{ url('sale/invoice/pos/' . $sale->invoice) }}"><i class="mdi mdi-format-align-justify"></i> Pos</a>
                                                 {{-- <button disabled class="btn waves-effect waves-light btn-xs btn-danger"><i class="mdi mdi-backup-restore"></i> Void</button> --}}
                                                <form action="{{url('sale/void/'.$sale->slug)}}" method="post" style="margin-top:-2px" id="deleteButton{{$sale->id}}">
                                                    @csrf
                                                    <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$sale->id}})"><i class="mdi mdi-backup-restore"></i> Void</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="profile7" role="tabpanel" aria-expanded="false">
                        <div class="pb-4">
                            <div class="table-responsive">
                                <table id="myTable2" class="display nowrap table table-hover table-striped table-bordered"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="80">{{ __('messages.sl')}}</th>
                                            <th>{{ __('messages.date')}}</th>
                                            <th>{{ __('messages.invoice')}}</th>
                                            <th>{{ __('messages.customer')}}</th>
                                            <th>{{ __('messages.dscription')}}</th>
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
                                                <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{ url('invoice', [$sale->invoice]) }}"><i class="mdi mdi-format-align-justify"></i> Invoice</a>
                                                @if(Sentinel::hasAccess('sale-voidrestore'))
                                                <form action="{{url('sale/restore/'.$sale->slug)}}" method="post" style="margin-top:-2px" id="deleteButton{{$sale->id}}">
                                                    @csrf
                                                    <button type="submit" class="btn waves-effect waves-light btn-xs btn-success" onclick="sweetalertDelete({{$sale->id}})"><i class="mdi mdi-backup-restore"></i> Restore</button>
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
        </div>
    </div>
</div>
@include('elements.dataTableOne')
@endsection