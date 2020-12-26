@extends('layout.app',['pageTitle' => __('Tax Payments')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.expense') }}
    @endslot
@endcomponent
@push('css')
<style>
    .demo-checkbox label, .demo-radio-button label {
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
                <h4 class="card-title">{{ __('messages.expense') }}</h4>
                <h6 class="card-subtitle">{{ __('messages.tax_payment') }}</h6>
                <hr>
                <form class="form-material m-t-40 form" action="{{ route('expense.store') }}" method="post">
                    @csrf
                    <div class="form-group row {{ $errors->has('date') ? ' has-danger' : '' }}">
                        <label for="date" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.date') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="date" value="{{old('date',date('Y-m-d'))}}" class="form-control datepickerDB" id="date" required autocomplete="off">
                            @include('elements.feedback',['field' => 'date'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('expense_category_id') ? ' has-danger' : '' }}">
                        <label for="expense_category_id" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.select_category') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <select name="expense_category_id" class="form-control" id="expense_category_id" readonly>
                                <option value="1">Tax Payment</option>
                            </select>
                            @include('elements.feedback',['field' => 'expense_category_id'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('amount') ? ' has-danger' : '' }}">
                        <label for="amount" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.amount') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="number" name="amount" value="{{old('amount',$due)}}" class="form-control" id="amount" required autocomplete="off">
                            @include('elements.feedback',['field' => 'amount'])
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                        <label for="description" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.dscription') }} :</label>
                        <div class="col-sm-10">
                            <textarea name="description" class="form-control" rows="10" placeholder="Tell me about this Umit."> Paid to the amount for Tax/Vat;</textarea>
                            <small>Write a short description;</small>
                            @include('elements.feedback',['field' => 'description'])
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('payment_type') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.transation') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <div class="demo-radio-button">
                                <input name="payment_type" type="radio" id="in_cash" value="cash" checked="checked">
                                <label for="in_cash">{{ __('messages.cash') }}</label>
                                <input name="payment_type" type="radio" value="bank" id="in_bank">
                                <label for="in_bank">Bank</label>
                            </div>
                        </div>
                    </div>
                    <div id="inBank" style="display:none">
                        <div class="form-group row {{ $errors->has('checkOrslip_no') ? ' has-danger' : '' }}">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.check_number') }}<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="checkOrslip_no" value="{{old('checkOrslip_no')}}" class="form-control"
                                    placeholder="Type your check or deposit slip number" required autocomplete="off">
                                @include('elements.feedback',['field' => 'checkOrslip_no'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('bank_account_id') ? ' has-danger' : '' }}">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.bank_a_c') }}<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <select name="bank_account_id" id="" class="form-control" value="{{old('bank_account_id')}}">
                                        <?php echo Pharma::getOptions($bankAccounts,'bank_name',old('bank_account_id'));?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group m-b-0">
                        <button type="submit" class="btn btn-themecolor waves-effect float-right waves-light m-t-10">{{ __('messages.save') }}</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $("input[name='payment_type']").change(function(){
            var way = $("input[name='payment_type']:checked").val();
            if(way === 'bank'){
                $('#inBank').slideDown();
            }else{
                $('#inBank').slideUp();
            }
        });
    </script>
@endpush
