@extends('layout.app',['pageTitle' => $patient->patient_name])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{trans_choice('messages.patient',1)}}
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Dues</h4>
                <h6 class="card-subtitle">Show Dues</h6>
                <hr class="hr-borderd">
                @include('elements.duecollect',['patient_id'=>$patient->id])
            </div>    
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{trans_choice('messages.patient',1)}}</h4>
                <h6 class="card-subtitle">{{__('messages.show_customer')}}</h6>
                <hr class="hr-borderd">
                <div class="row pt-3">
                    <div class="col-md-4 text-right">
                        <img src="{{ !empty($patient->picture) ? asset($patient->picture) : asset('user-default.png')}}" class="img-thumbnail" alt="">
                    </div>
                    <div class="col-md-8 text-left">
                        <h3 class="display-5 pt-1">{{ucfirst($patient->patient_name)}} <sub class="text-muted sub">{{$patient->slug}}</sub></h3>
                        <table class="table table-striped m-t-40">
                            <tr>
                                <td width='200'>Registration Date</td>
                                <td  width='5'>:</td>
                                <td>{{Pharma::dateFormat($patient->created_at)}}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{$patient->email}}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>:</td>
                                <td>{{$patient->phone}}</td>
                            </tr>
                            <tr>
                                <td>Age</td>
                                <td>:</td>
                                <td>{{$patient->age}}</td>
                            </tr>
                            <tr>
                                <td>Blood Group</td>
                                <td>:</td>
                                <td>{{$patient->blood_group}}</td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>:</td>
                                <td>{{$patient->gender}}</td>
                            </tr>
                            <tr>
                                <td>Marital Status</td>
                                <td>:</td>
                                <td>{{$patient->marital_status}}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td>{{$patient->address}}</td>
                            </tr>
                            <tr>
                                <td>Guardian</td>
                                <td>:</td>
                                <td>{{$patient->guardian}}</td>
                            </tr>
                            <tr>
                                <td>Guardian Phone</td>
                                <td>:</td>
                                <td>{{$patient->guardian_phone}}</td>
                            </tr>
                            <tr>
                                <td>Guardian Relations</td>
                                <td>:</td>
                                <td>{{$patient->relationship}}</td>
                            </tr>
                        </table>
                        <a href="{{url('patient/'.$patient->slug.'/edit')}}" class="btn bg-theme text-white">Edit</a>
                        <a href="{{route('patient.index')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    <div class="col-lg-12 col-md-12">
        @if(count($patient->sales) > 0)
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Medicine Sale History</h4>
                <table class="table table-bordered">
                    <thead class="bg-theme text-light font-weight-bold">
                        <tr class="themeThead">
                            <th width="80"> {{ __('messages.sl')}}</th>
                            <th>{{ __('messages.date')}}</th>
                            <th width="150">{{ __('messages.invoice')}}</th>
                            <th class="text-right">{{ __('messages.grand_total')}}</th>
                            <th class="text-right">{{ __('messages.paid_amount')}}</th>
                            <th class="text-right">{{ __('messages.due')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = $grandTotal = $paidTotal = $dueTotal = 0 @endphp
                        @forelse($patient->sales as $sale)
                        @php 
                            $grandTotal += $sale->grand_total;
                            $paidTotal += $sale->paid_amount;
                            $dueTotal += $sale->new_balance;
                        @endphp
                        <tr>
                            <tr>
                                <td>{{sprintf("%02s",++$i) }}</td>
                                <td>{{Pharma::dateFormat($sale->date)}}</td>
                                <td><a href="{{url('sale/invoice/'.$sale->invoice)}}" target="_blank">{{$sale->invoice}}</a></td>
                                <td class="text-right">{{ Pharma::amountFormatWithCurrency($sale->grand_total)}}</td>
                                <td class="text-right">{{ Pharma::amountFormatWithCurrency($sale->paid_amount)}}</td>
                                <td class="text-right">{{ Pharma::amountFormatWithCurrency($sale->new_balance)}}</td>
                            </tr>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">No Sale Yet!</td>
                        </tr>
                        @endforelse
                        <tr class="font-weight-bold">
                            <td colspan="3" class="text-right">Total</td>
                            <td class="text-right">{{Pharma::amountFormatWithCurrency($grandTotal)}}</td>
                            <td class="text-right">{{Pharma::amountFormatWithCurrency($paidTotal)}}</td>
                            <td class="text-right">{{Pharma::amountFormatWithCurrency($dueTotal)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        @if(count($dueCollections) > 0)
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Due Collection</h4>
                <table class="table table-bordered">
                    <thead class="bg-theme text-light font-weight-bold">
                        <tr class="themeThead">
                            <th width="80"> {{ __('messages.sl')}}</th>
                            <th>{{ __('messages.date')}}</th>
                            <th width="150">{{ __('messages.invoice')}}</th>
                            <th class="text-right">{{ __('messages.amount')}}</th>
                            <th class="">Collected By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = $amountTotal = 0 @endphp
                        
                        @forelse($dueCollections as $trans)
                        @php 
                            $amountTotal += $trans->amount;
                        @endphp
                        <tr>
                            <tr>
                                <td>{{sprintf("%02s",++$i) }}</td>
                                <td>{{Pharma::dateFormat($trans->date)}}</td>
                                <td>{{$trans->trans_id}}</td>
                                <td class="text-right">{{ Pharma::amountFormatWithCurrency($trans->amount)}}</td>
                                <td>{{ Pharma::getUserName($trans->user_id)}}</td>
                            </tr>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">No Collection Yet!</td>
                        </tr>
                        @endforelse
                        <tr class="font-weight-bold">
                            <td colspan="3" class="text-right">Total</td>
                            <td class="text-right">{{Pharma::amountFormatWithCurrency($amountTotal)}}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        @if(count($patient->bill) > 0)
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Diagnostic History</h4>   
                <table class="table table-bordered">
                    <thead>
                        <tr class="themeThead">
                            <th width="80"> {{ __('messages.sl')}}</th>
                            <th width="300">Report Delivary</th> 
                            <th>Invoice No</th>
                            <th class="text-right">{{ __('messages.paid_amount')}}</th>
                            <th class="text-right">Due</th>
                            <th>Referral Name</th> 
                            <th width='150'>{{ __('messages.action')}}</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php $i = 0;?>
                        @foreach($patient->bill as $row)
                        <tr>
                            <td>{{ sprintf("%02s",++$i) }}</td> 
                            <td> {{Pharma::dateFormat($row->delivary_date) }} {{ date('g:i a', strtotime($row->delivary_time)) }} </td> 
                            <td>{{ $row->invoice }}</td>
                            <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->grand_total) }}</td>
                            <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->due) }}</td> 
                            <td>{{ $row->referral->name }}</td> 
                            <td style="display: flex; justify-content: space-evenly;">
                                <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('diagnostic/bill/invoice/a4/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> A4</a> 
                                <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('diagnostic/bill/invoice/pos/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> Pos</a>  
                            </td>
                        </tr>
                        @endforeach
                    </tbody> 
                </table>    
            </div>
        </div>
        @endif
        @if(count($admissionHistory) > 0)
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Admission & Service History</h4>   
                <table class="table table-bordered">
                    <thead>
                        <tr class="themeThead">
                            <th width="80"> {{ __('messages.sl')}}</th>
                            <th width="300">Admited Date</th> 
                            <th>Invoice No</th>
                            <th class="text-right">{{ __('messages.paid_amount')}}</th>
                            <th class="text-right">Due</th>
                            <th>Referral Name</th> 
                            <th width='150'>{{ __('messages.action')}}</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php $i = 0;?>
                        @foreach($admissionHistory as $row)
                        <tr>
                            <td>{{ sprintf("%02s",++$i) }}</td> 
                            <td> {{Pharma::dateFormat($row->admit_date) }} {{ date('g:i a', strtotime($row->admit_time)) }} </td> 
                            <td>{{ $row->invoice }}</td>
                            <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->actual_paid_amount) }}</td>
                            <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->due) }}</td> 
                            <td>{{ $row->referral->name }}</td> 
                            <td style="display: flex; justify-content: space-evenly;">
                                <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/admission/invoice/a4/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> A4</a> 
                                <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/admission/invoice/pos/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> Pos</a>  
                            </td>
                        </tr>
                        @endforeach
                    </tbody> 
                </table>    
            </div>
        </div>
        @endif
        @if(count($emergencyHistory) > 0)
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Emergency & Service History</h4>   
                <table class="table table-bordered">
                    <thead>
                        <tr class="themeThead">
                            <th width="80"> {{ __('messages.sl')}}</th>
                            <th width="300">Emergency Date</th> 
                            <th>Invoice No</th>
                            <th class="text-right">{{ __('messages.paid_amount')}}</th>
                            <th class="text-right">Due</th>
                            <th>Referral Name</th> 
                            <th width='150'>{{ __('messages.action')}}</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php $i = 0;?>
                        @foreach($emergencyHistory as $row)
                        <tr>
                            <td>{{ sprintf("%02s",++$i) }}</td> 
                            <td> {{Pharma::dateFormat($row->date) }} {{ date('g:i a', strtotime($row->time)) }} </td> 
                            <td>{{ $row->invoice }}</td>
                            <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->actual_paid_amount) }}</td>
                            <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->due) }}</td> 
                            <td>{{ $row->referral->name }}</td> 
                            <td style="display: flex; justify-content: space-evenly;">
                                <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/emergency/invoice/a4/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> A4</a> 
                                <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/emergency/invoice/pos/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> Pos</a>  
                            </td>
                        </tr>
                        @endforeach
                    </tbody> 
                </table>    
            </div>
        </div>
        @endif
        @if(count($operationHistory) > 0)
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Operations History</h4>   
                <table class="table table-bordered">
                    <thead>
                        <tr class="themeThead">
                            <th width="80"> {{ __('messages.sl')}}</th>
                            <th width="300">Operation Date</th> 
                            <th>Invoice No</th>
                            <th class="text-right">{{ __('messages.paid_amount')}}</th>
                            <th class="text-right">Due</th> 
                            <th width='150'>{{ __('messages.action')}}</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php $i = 0;?>
                        @foreach($operationHistory as $row)
                        <tr>
                            <td>{{ sprintf("%02s",++$i) }}</td> 
                            <td> {{Pharma::dateFormat($row->date) }} {{ date('g:i a', strtotime($row->time)) }} </td> 
                            <td>{{ $row->invoice }}</td>
                            <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->actual_amount) }}</td>
                            <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->due) }}</td>  
                            <td style="display: flex; justify-content: space-evenly;">
                                <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/operation/invoice/a4/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> A4</a> 
                                <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/operation/invoice/pos/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> Pos</a>  
                            </td>
                        </tr>
                        @endforeach
                    </tbody> 
                </table>    
            </div>
        </div>
        @endif 
        @if(count($bedHistory) > 0)
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bed Charge History</h4>   
                <table class="table table-bordered">
                    <thead>
                        <tr class="themeThead">
                            <th width="80"> {{ __('messages.sl')}}</th>
                            <th width="300">Patient Name</th> 
                            <th>Invoice No</th>
                            <th class="text-right">{{ __('messages.paid_amount')}}</th>
                            <th class="text-right">Due</th> 
                            <th width='150'>{{ __('messages.action')}}</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php $i = 0;?>
                        @foreach($bedHistory as $row)
                        <tr>
                            <td>{{ sprintf("%02s",++$i) }}</td> 
                            <td>{{ $row->patient->patient_name }}</td>
                            <td>{{ $row->invoice }}</td>
                            <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->paid_amount) }}</td>
                            <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->due) }}</td>  
                            <td style="display: flex; justify-content: space-evenly;">
                                <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/bedcharge/invoice/a4/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> A4</a> 
                                <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/bedcharge/invoice/pos/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> Pos</a>  
                            </td>
                        </tr>
                        @endforeach
                    </tbody> 
                </table>    
            </div>
        </div>
        @endif 
    </div>
</div>
</div>
@endsection
