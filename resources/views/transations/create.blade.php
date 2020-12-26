@extends('layout.app',['pageTitle' => 'Transaction '.$transaction_type])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.transaction') }}
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
                <h4 class="card-title">{{ __('messages.transaction') }}</h4>
                <h6 class="card-subtitle">{{ __('messages.new_transctcion') }}</h6>
                <hr class="hr-borderd">
                <form class="form-material m-t-40 form" action="{{ route('transaction.store') }}" method="post">
                    @csrf
                    <div class="form-group row {{ $errors->has('date') ? ' has-danger' : '' }}">
                        <label for="date" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.date') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control datepickers" name="date" value="{{date('d-m-Y')}}" id="date" required="" autocomplete="off">
                            {{-- <input type="date" name="date" value="{{old('date',date('Y-m-d'))}}" class="form-control datepickers" id="date" required autocomplete="off"> --}}
                            @include('elements.feedback',['field' => 'date'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('transaction_type') ? ' has-danger' : '' }}">
                        <label for="transaction_type" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.trans_type') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="transaction_type" value="{{$transaction_type}}" class="form-control" id="transaction_type" readonly autocomplete="off">
                            @include('elements.feedback',['field' => 'transaction_type'])
                        </div>
                    </div>
                    @if($vendor == 'Patient')
                    <div class="form-group row {{ $errors->has('vendor_id') ? ' has-danger' : '' }}">
                        <label for="vendor_id" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.select_customer') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <select name="vendor_id" class="form-control" id="vendor_id">
                                @foreach($customers as $val)
                                    <option value="{{$val->id}}">{{$val->patient_name}} ------- {{Pharma::getcustomerBalance($val->id)}}</option>
                                @endforeach
                                <?php //echo Pharma::getOptions($customers,'patient_name',old('vendor_id'));?>
                            </select>
                            @include('elements.feedback',['field' => 'vendor_id'])
                            <input type="hidden" name="vendor" value="{{$vendor}}">
                        </div>
                    </div>
                    @elseif($vendor == 'Manufacturer')
                    <div class="form-group row {{ $errors->has('vendor_id') ? ' has-danger' : '' }}">
                        <label for="vendor_id" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.select_manufac') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <select name="vendor_id" class="form-control" id="vendor_id">
                                @foreach($manufacturers as $val)
                                    <option value="{{$val->id}}">{{$val->manufacturer_name}} ------- {{Pharma::getManufacturerBalance($val->id)}}</option>
                                @endforeach
                            </select>
                            @include('elements.feedback',['field' => 'vendor_id'])
                            <input type="hidden" name="vendor" value="{{$vendor}}">
                        </div>
                    </div>
                    @endif

                    <div class="form-group row {{ $errors->has('amount') ? ' has-danger' : '' }}">
                        <label for="amount" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.trans_amount') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="number" name="amount" value="{{old('amount',0)}}" class="form-control" id="amount" required autocomplete="off">
                            @include('elements.feedback',['field' => 'amount'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                        <label for="description" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.description') }} :</label>
                        <div class="col-sm-10">
                            <textarea name="description" class="form-control" rows="10" placeholder="Tell me about this category."></textarea>
                            <small>Write a short description;</small>
                            @include('elements.feedback',['field' => 'description'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('transaction_way') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.transation') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <div class="demo-radio-button">
                                <input name="transaction_way" type="radio" id="in_cash" value="cash" checked="checked">
                                <label for="in_cash">{{ __('messages.cash') }}</label>
                                <input name="transaction_way" type="radio" value="bank" id="in_bank">
                                <label for="in_bank">{{ trans_choice('messages.bank',1) }}</label>
                            </div>
                        </div>
                    </div>
                    <div id="inBank" style="display:none">
                        <div class="form-group row {{ $errors->has('checkOrslip_no') ? ' has-danger' : '' }}">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.check_slip') }}<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="checkOrslip_no" value="{{old('checkOrslip_no')}}" class="form-control" placeholder="Type your check or deposit slip number" required autocomplete="off">
                                @include('elements.feedback',['field' => 'checkOrslip_no'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('bank_account_id') ? ' has-danger' : '' }}">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ trans_choice('messages.bank_account',1) }}<sup class="text-danger font-bold">*</sup> :</label>
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
        $("input[name='transaction_way']").change(function(){
            var way = $("input[name='transaction_way']:checked").val();
            if(way === 'bank'){
                $('#inBank').slideDown();
            }else{
                $('#inBank').slideUp();
            }
        });
    </script>
@endpush
