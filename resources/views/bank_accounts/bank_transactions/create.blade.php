@extends('layout.app',['pageTitle' => __('messages.make_transaction')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{trans_choice('messages.bank_transaction',1)}}
@endslot
@endcomponent
@push('css')
<style>
    .demo-checkbox label,
    .demo-radio-button label {
        min-width: 0px;
        margin-bottom: 0px;
        margin-top: 6px;
    }
</style>
@endpush
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{trans_choice('messages.bank_transaction',1)}}</h4>
                <h6 class="card-subtitle">{{__('messages.create_new')}} {{trans_choice('messages.bank_transaction',1)}}</h6>
                <hr class="hr-borderd">
                <form class="form-material m-t-40 form" action="{{ url('bankaccount/transaction/store') }}" method="post">
                    @csrf
                    <div class="form-group row {{ $errors->has('date') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.date')}}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="date" value="{{old('date',date('d-m-Y'))}}" class="form-control datepickers" placeholder="Bank name" required autocomplete="off"> @include('elements.feedback',['field' => 'date'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('checkOrslip_no') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.checkOrSlip')}}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="checkOrslip_no" value="{{old('checkOrslip_no')}}" class="form-control" placeholder="Type your check or deposit slip number" required autocomplete="off"> @include('elements.feedback',['field' => 'checkOrslip_no'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('bank_account_id') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{trans_choice('messages.select',10)}} {{trans_choice('messages.bank_account',1)}}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <select name="bank_account_id" id="" class="form-control" value="{{old('bank_account_id')}}">
                                @foreach ($bankaccounts as $item)
                                <option value="{{$item->id}}">{{$item->account_name}} -- {{$item->bank_name}}</option>
                                @endforeach
                            </select>
                            @include('elements.feedback',['field' => 'bank_account_id'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('amount') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.amount')}}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="number" name="amount" value="{{old('amount',0)}}" class="form-control" placeholder="Branch Name" required autocomplete="off"> @include('elements.feedback',['field' => 'amount'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('transection_type') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.type')}} <sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <div class="demo-radio-button">
                                <input name="transection_type" type="radio" id="radio_1" value="Debit" checked="checked">
                                <label for="radio_1">Debit</label>
                                <input name="transection_type" type="radio" value="Credit" id="radio_2">
                                <label for="radio_2">Credit</label>
                            </div>
                            @include('elements.feedback',['field' => 'transection_type'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                        <label for="description" class="col-sm-2 text-right control-label col-form-label">{{__('messages.description')}} :</label>
                        <div class="col-sm-10">
                            <textarea name="description" class="form-control" rows="10" placeholder="Tell me about this Transaction."></textarea>
                            <small>{{__('messages.write_a_note')}};</small> @include('elements.feedback',['field' => 'description'])
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <button type="submit" class="btn btn-info waves-effect float-right waves-light m-t-10">{{__('messages.save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
