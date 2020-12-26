@extends('layout.app',['pageTitle' => __('Purchase Management')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.purchase') }}
    @endslot
@endcomponent

@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body p-b-0">
                <div class="mb-3">
                    <h4 class="card-title d-inline">{{ __('messages.purchase')}}</h4>
                    <h6 class="card-subtitle d-inline">{{ __('messages.all_purchase')}}</h6> @if(Sentinel::hasAccess('purchase-create'))
                    <a class="btn float-right bg-theme text-light" href="{{route('purchase.create')}}">{{ __('messages.new_purchase') }}</a> @endif
                </div>
                <hr class="hr-borderd">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs customtab2" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home7" role="tab" aria-expanded="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">{{ __('messages.active')}}</span></a> </li>
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
                                            <th width="80">{{ __('messages.sl')}}</th>
                                            <th>{{ __('messages.date')}}</th>
                                            <th width="200px">{{ __('messages.invoice')}}</th>
                                            <th>{{ __('messages.manufacturer')}}</th>
                                            <th>{{ __('messages.description')}}</th>
                                            <th class="text-right">{{ __('messages.amount')}}</th>
                                            <th width='150'>{{ __('messages.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0;?>
                                            @foreach($purchase as $pur)
                                            <tr>
                                                <td>{{sprintf("%02s",++$i) }}</td>
                                                <td>{{Pharma::dateFormat($pur->date)}}</td>
                                                <td>
                                                    {{$pur->invoice}}
                                                </td>
                                                <td>{{$pur->manufacturer->manufacturer_name}}</td>
                                                <td>{{Pharma::limit_text($pur->description,15)}}</td>
                                                <td class="text-right">{{Pharma::amountFormatWithCurrency($pur->payable_amount)}}</td>
                                                <td style="display: flex; justify-content: space-evenly;">
                                                    <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{ url('purchase/invoice/a4/' .$pur->invoice) }}"><i class="mdi mdi-format-align-justify"></i> A4</a> 
                                                    <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{ url('purchase/invoice/pos/' .$pur->invoice) }}"><i class="mdi mdi-format-align-justify"></i> Pos</a> 
                                                    {{-- <button disabled class="btn waves-effect waves-light btn-xs btn-danger"><i class="mdi mdi-backup-restore"></i> Void</button> --}}
                                                    <form action="{{url('purchase/void/'.$pur->slug)}}" method="post" style="margin-top:-2px" id="deleteButton{{$pur->id}}">
                                                        @csrf
                                                        <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$pur->id}})"><i class="mdi mdi-backup-restore"></i> Void</button>
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
                                <table id="myTable2" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="80">{{ __('messages.sl')}}</th>
                                            <th>{{ __('messages.date')}}</th>
                                            <th width="200px">{{ __('messages.invoice')}}</th>
                                            <th>{{ __('messages.manufacturer')}}</th>
                                            <th>{{ __('messages.dscription')}}</th>
                                            <th class="text-right">{{ __('messages.amount')}}</th>
                                            <th width='150'>{{ __('messages.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0;?>
                                            @foreach($voided as $purchase)
                                            <tr>
                                                <td>{{sprintf("%02s",++$i) }}</td>
                                                <td>{{Pharma::dateFormat($purchase->date)}}</td>
                                                <td>{{$purchase->invoice}}</td>
                                                <td>{{$purchase->manufacturer->manufacturer_name}}</td>
                                                <td>{{Pharma::limit_text($purchase->description,15)}}</td>
                                                <td class="text-right">{{ Pharma::amountFormatWithCurrency($purchase->grand_total)}}</td>
                                                <td style="display: flex; justify-content: space-evenly;">
                                                    {{--<button type="button" class="btn waves-effect waves-light btn-xs btn-info" data-toggle="modal" data-target="#MyModal" "><i class="fa fa-print " aria-hidden="true "></i></button> --}}
                                                    <a class="btn waves-effect waves-light text-light btn-xs btn-primary " href="{{ url( 'purchase/invoice', [$purchase->invoice]) }}"><i class="mdi mdi-format-align-justify"></i> {{ __('messages.invoice')}}</a>
                                                    @if(Sentinel::hasAccess('category-destroy'))
                                                        <form action="{{url('purchase/restore/'.$purchase->slug)}}" method="post" style="margin-top:-2px" id="deleteButton{{$purchase->id}}">
                                                            @csrf
                                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-success" onclick="sweetalertDelete({{$purchase->id}})"><i class="mdi mdi-backup-restore"></i> {{ __('messages.restore')}}</button>
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
