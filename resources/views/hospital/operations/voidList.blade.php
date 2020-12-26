@extends('layout.app',['pageTitle' => 'Operation Voide list'])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
       Void list
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline">Void list</h4><br>
                    <h6 class="card-subtitle d-inline">{{__('messages.see_all')}} Void list</h6> 
                    <hr class="hr-borderd">
                    <div class="col-lg-12">
                        <div class="Content">
                                <table class="table table-bordered table-hover Content" id="myTable">
                                    <thead>
                                    <tr class="themeThead">
                                        <th width="80"> {{ __('messages.sl')}}</th>
                                        <th width="300">Operation date</th>
                                        <th>Paitent Name</th>
                                        <th>Invoice No</th> 
                                        <th>Operation Name</th>
                                        <th class="text-right">{{ __('messages.paid_amount')}}</th>
                                        <th class="text-right">Due</th>  
                                        <th width='150'>{{ __('messages.action')}}</th>
                                  </tr>
                                    </thead>

                                    <tbody> 
                                        @php $i = 0; @endphp
                                        @foreach($operations as $row)
                                            <tr>
                                                <td>{{sprintf('%02d',++$i)}}</td>
                                                <td>{{Pharma::dateFormat($row->date) }} {{ date('g:i a', strtotime($row->time)) }}</td>
                                                <td>{{ $row->patient->patient_name }}</td> 
                                                <td>{{ $row->invoice }}</td>
                                                <td>{{ $row->operation_service_name }}</td> 
                                                <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->operation_service_price) }}</td> 
                                                <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->due)}}</td>  
                                                <td style="display: flex; justify-content: space-evenly;">  
                                                <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/operation/invoice/a4/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> A4</a> 
                                                <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/operation/invoice/pos/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> Pos</a>  
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
