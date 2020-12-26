@extends('layout.app',['pageTitle' => __('messages.update_bank_account')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ __('messages.update_bank_account') }}
@endslot
@endcomponent

@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{trans_choice('messages.bank_account',1)}}</h4>
                <h6 class="card-subtitle">{{__('messages.update')}} {{trans_choice('messages.bank_account',1)}}</h6>
                <hr>
                <form class="form-material m-t-40 form" action="{{ route('bankaccount.update',$bankaccount) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group row {{ $errors->has('bank_name') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.bank_name')}}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="bank_name" value="{{old('bank_name',$bankaccount->bank_name)}}" class="form-control" id="bank" placeholder="Bank name" required autocomplete="off">
                            @include('elements.feedback',['field' => 'bank_name'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('account_number') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.account_number')}}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="number" name="account_no" value="{{old('account_number',$bankaccount->account_number)}}" class="form-control" id="bank" placeholder="Bank account number" required autocomplete="off">
                            @include('elements.feedback',['field' => 'account_number'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('account_name') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.account_name')}}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="account_name" value="{{old('account_name',$bankaccount->account_name)}}" class="form-control" id="bank" placeholder="Account Name" required autocomplete="off">
                            @include('elements.feedback',['field' => 'account_name'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('branch_name') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.branch_name')}}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="branch_name" value="{{old('branch_name',$bankaccount->branch_name)}}" class="form-control" id="bank" placeholder="Branch Name" required autocomplete="off">
                            @include('elements.feedback',['field' => 'branch_name'])
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <button type="submit" class="btn btn-info waves-effect float-right waves-light m-t-10">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection