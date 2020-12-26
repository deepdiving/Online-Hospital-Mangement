@extends('layout.app',['pageTitle' => trans_choice('messages.bank_transaction',10)])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{trans_choice('messages.bank_transaction',10)}}
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline">{{trans_choice('messages.bank_transaction',10)}}</h4><br>
                <h6 class="card-subtitle d-inline">{{__('messages.see_all')}} {{trans_choice('messages.bank_transaction',10)}}.</h6>
                <hr class="hr-borderd">
                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="myTable2">
                            <thead>
                                <tr class="themeThead">
                                    <th width="50">{{__('messages.sl')}}</th>
                                    <th>{{__('messages.date')}}</th>
                                    <th>{{__('messages.transaction_id')}}</th>
                                    <th>{{__('messages.account_name')}}</th>
                                    <th width="250px">{{__('messages.checkOrSlip')}}</th>
                                    <th class="text-right">{{__('messages.debit')}}</th>
                                    <th class="text-right">{{__('messages.credit')}}</th>
                                    <th>{{__('messages.description')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0;$cashIn=0;$cashOut=0?>
                                @foreach($bankTransaction as $bank)
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>
                                    <td>{{ Pharma::dateFormat($bank->date)}}</td>
                                    <td>{{ $bank->trnsactionId}}</td>
                                    <td>{{App\BankAccount::where('id',$bank->bank_account_id)->first()->bank_name}}</td>
                                    <td>{{ $bank->checkOrslip_no}}</td>
                                    @if ($bank->transection_type=='debit')
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($bank->amount)}}</td>
                                        <td class="text-right">-</td>
                                    @elseif($bank->transection_type=='credit')
                                        <td class="text-right">-</td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($bank->amount)}}</td>
                                    @endif
                                    <td>{{ Pharma::limit_text($bank->description,15)}}</td>
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