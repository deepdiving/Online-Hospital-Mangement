@extends('layout.app',['pageTitle' => __('messages.new_bank_account')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ trans_choice('messages.bank_account',10) }}
@endslot
@endcomponent

@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{trans_choice('messages.bank_account',1)}}</h4>
                <h6 class="card-subtitle">{{__('messages.create_new')}} {{trans_choice('messages.bank_account',1)}}</h6>
                <hr class="hr-borderd">
                <form class="form-material m-t-40 form" action="{{ route('bankaccount.store') }}" method="post">
                    @csrf
                    <div class="form-group row {{ $errors->has('bank_name') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.bank_name')}}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="bank_name" value="{{old('bank_name')}}" class="form-control" id="bank" placeholder="Bank name" required autocomplete="off">
                            @include('elements.feedback',['field' => 'bank_name'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('account_no') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.account_number')}}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="number" name="account_no" value="{{old('account_no')}}" class="form-control" id="bank" placeholder="Bank Number" required autocomplete="off">
                            @include('elements.feedback',['field' => 'account_no'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('account_name') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.account_name')}}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="account_name" value="{{old('account_name')}}" class="form-control" id="bank" placeholder="Account Name" required autocomplete="off">
                            @include('elements.feedback',['field' => 'account_name'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('branch_name') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.branch_name')}}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="branch_name" value="{{old('branch_name')}}" class="form-control" id="bank" placeholder="Branch Name" required autocomplete="off">
                            @include('elements.feedback',['field' => 'branch_name'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('balance') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.balance')}}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="number" name="balance" value="{{old('balance')}}" class="form-control" id="bank" placeholder="Balance" required autocomplete="off">
                            @include('elements.feedback',['field' => 'balance'])
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <button type="submit" class="btn bg-theme text-light waves-effect float-right waves-light m-t-10">{{__('messages.save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection