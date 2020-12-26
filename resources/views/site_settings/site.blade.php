@extends('layout.app',['pageTitle' => __('Site Settings')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.site_setting') }}
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card bg-warning">
                <div class="card-body">
                   <h4 class="text-light">{{ __('messages.importent') }} :</h4>
                   <p class="lead text-light">If you change your prefix it will affected farther/new invoice or vouchers NOT CHANGES WHICH VOUCHER/INVOICE IS ALREADY GENERATED.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline">{{ __('messages.site_setting') }}</h4>
                    <h6 class="card-subtitle d-inline">{{ __('messages.all_setting_li') }}..</h6>
                <hr class="hr-borderd">
                <form class="form-material m-t-40 form" action="{{ url('settings/system-setting/site') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- @method('put') --}}
                    <div class="form-group row {{ $errors->has('language') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.language') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <select name="language" id="" class="form-control">
                                @php echo Pharma::getOptionArray(['bn' => 'Bangla','en'=>'English','hi' => 'Hindi'],$siteSetting->language); @endphp
                            </select>
                            @include('elements.feedback',['field' => 'language'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('timezone') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.time_zone') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <select name="timezone" id="" class="form-control">
                                @php echo Pharma::getTimezones($siteSetting->timezone); @endphp
                            </select>
                            @include('elements.feedback',['field' => 'timezone'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('currency') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.currency') }} <sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <select name="currency" id="" class="form-control">
                                @php echo Pharma::getCurrencies($siteSetting->currency); @endphp
                            </select>
                            @include('elements.feedback',['field' => 'currency'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('cur_position') ? ' has-danger' : '' }}">
                        <label for="cur_position" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.currency_possi') }} <sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <select name="cur_position" id="cur_position" class="form-control">
                                @php echo Pharma::getOptionArray(['before' => 'Before Amount','after'=>'After Amount'],$siteSetting->cur_position); @endphp
                            </select>
                            @include('elements.feedback',['field' => 'cur_position'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('date_format') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.date_format') }} <sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <select name="date_format" id="" class="form-control">
                                @php echo Pharma::getOptionArray([
                                    'M d, Y'=> 'Jan 01, 2020',
                                    'd M, Y'=>'01 Jan, 2020',
                                    'd M'=>'01 Jan',
                                    'M d'=>'Jan 01',
                                    'Y M d'=>'2020 Jan 01',
                                    'Y M, d'=>'2020 Jan, 01',
                                    ],$siteSetting->date_format); @endphp
                            </select>
                            @include('elements.feedback',['field' => 'date_format'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('sale_tax') ? ' has-danger' : '' }}">
                        <label for="sale_tax" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.default_sa_tax') }} <sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10 input-group">
                            <input type="number" name="sale_tax" value="{{old('sale_tax',$siteSetting->sale_tax)}}" class="form-control" id="sale_tax" placeholder="Set default sale tax percent" required autocomplete="off">
                            <div class="input-group-append"><span class="input-group-text md-addon">%</span></div>
                            @include('elements.feedback',['field' => 'sale_tax'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('purchase_tax') ? ' has-danger' : '' }}">
                        <label for="purchase_tax" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.default_pur_tax') }} <sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10 input-group">
                            <input type="number" name="purchase_tax" value="{{old('purchase_tax',$siteSetting->purchase_tax)}}" class="form-control" id="purchase_tax" placeholder="Set default purchase tax percent" required autocomplete="off">
                            <div class="input-group-append"><span class="input-group-text md-addon">%</span></div>
                            @include('elements.feedback',['field' => 'purchase_tax'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('sale_prefix') ? ' has-danger' : '' }}">
                        <label for="sale_prefix" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.sale_prefix') }} <sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="sale_prefix" value="{{old('sale_prefix',$siteSetting->sale_prefix)}}" class="form-control" id="sale_prefix" placeholder="Sale Prefix" required autocomplete="off">
                            @include('elements.feedback',['field' => 'sale_prefix'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('purchase_prefix') ? ' has-danger' : '' }}">
                        <label for="purchase_prefix" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.purch_Prefix') }} <sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="purchase_prefix" id="purchase_prefix" value="{{old('purchase_prefix',$siteSetting->purchase_prefix)}}" class="form-control" placeholder="Purchase Prefix" required autocomplete="off">
                            @include('elements.feedback',['field' => 'purchase_prefix'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('transaction_prefix') ? ' has-danger' : '' }}">
                        <label for="transaction_prefix" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.trans_prefix') }} <sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="transaction_prefix" id="transaction_prefix" value="{{old('transaction_prefix',$siteSetting->transaction_prefix)}}" class="form-control" placeholder="Transaction Prefix" required autocomplete="off">
                            @include('elements.feedback',['field' => 'transaction_prefix'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('bank_transaction_prefix') ? ' has-danger' : '' }}">
                        <label for="bank_transaction_prefix" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.bank_tra_prefix') }} <sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="bank_transaction_prefix" id="bank_transaction_prefix" value="{{old('bank_transaction_prefix',$siteSetting->bank_transaction_prefix)}}" class="form-control" placeholder="Bank Transaction Prefix" required autocomplete="off">
                            @include('elements.feedback',['field' => 'bank_transaction_prefix'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('sale_return_prefix') ? ' has-danger' : '' }}">
                        <label for="sale_return_prefix" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.sa_return_pre')}} <sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="sale_return_prefix" id="sale_return_prefix" value="{{old('sale_return_prefix',$siteSetting->sale_return_prefix)}}" class="form-control" placeholder="Sale Return Prefix" required autocomplete="off">
                            @include('elements.feedback',['field' => 'sale_return_prefix'])
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('purchase_return_prefix') ? ' has-danger' : '' }}">
                        <label for="purchase_return_prefix" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.purc_return_pre') }} <sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="purchase_return_prefix" id="purchase_return_prefix" value="{{old('purchase_return_prefix',$siteSetting->purchase_return_prefix)}}" class="form-control" placeholder="Purchase Return Prefix" required autocomplete="off">
                            @include('elements.feedback',['field' => 'purchase_return_prefix'])
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('batch_prefix') ? ' has-danger' : '' }}">
                        <label for="batch_prefix" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.batch_prefix') }} <sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="batch_prefix" id="batch_prefix" value="{{old('batch_prefix',$siteSetting->batch_prefix)}}" class="form-control" placeholder="Batch/Lot Prefix" required autocomplete="off">
                            @include('elements.feedback',['field' => 'batch_prefix'])
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('prefix_diagnostic_bill') ? ' has-danger' : '' }}">
                        <label for="prefix_diagnostic_bill" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.prefix_diagnostic_bill') }} <sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="prefix_diagnostic_bill" id="prefix_diagnostic_bill" value="{{old('prefix_diagnostic_bill',$siteSetting->prefix_diagnostic_bill)}}" class="form-control" placeholder="Batch/Lot Prefix" required autocomplete="off">
                            @include('elements.feedback',['field' => 'prefix_diagnostic_bill'])
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('prefix_hms_admission') ? ' has-danger' : '' }}">
                        <label for="prefix_hms_admission" class="col-sm-2 text-right control-label col-form-label">Hospital Admission Prefix  <sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="prefix_hms_admission" id="prefix_hms_admission" value="{{old('prefix_hms_admission',$siteSetting->prefix_hms_admission)}}" class="form-control" placeholder="Batch/Lot Prefix" required autocomplete="off">
                            @include('elements.feedback',['field' => 'prefix_hms_admission'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('prefix_asset') ? ' has-danger' : '' }}">
                        <label for="prefix_asset" class="col-sm-2 text-right control-label col-form-label">Hospital Admission Prefix  <sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="prefix_asset" id="prefix_asset" value="{{old('prefix_asset',$siteSetting->prefix_asset)}}" class="form-control" placeholder="hms/assets/" required autocomplete="off">
                            @include('elements.feedback',['field' => 'prefix_asset'])
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('voucher_type') ? ' has-danger' : '' }}">
                        <label for="voucher_type" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.voucher_type') }} <sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <select name="voucher_type" id="" class="form-control">
                                @php echo Pharma::getOptionArray([
                                    'A4'=> 'A4',
                                    'POS'=> 'POS',
                                    ],$siteSetting->voucher_type); @endphp
                            </select>
                            @include('elements.feedback',['field' => 'voucher_type'])
                        </div>
                    </div>

                    <div class="form-group m-b-0">
                        <button siteSetting="submit" class="btn bg-theme text-light waves-effect float-right waves-light m-t-10">{{ __('messages.update') }}</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
