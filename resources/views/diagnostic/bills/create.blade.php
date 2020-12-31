@extends('layout.app',['pageTitle' => 'New Test Category','sidebarStyle' => 'mini-sidebar','noFooter' => 'true'])
@section('content')
<style>
    .noneState{
        opacity: .5;
        pointer-events: none;
    }
    .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

    .test-list-scroll{
        width: 100%;
        height: 745px;
        overflow: auto
    }
    .invoice-box{
        width: 100%;
        height: 308px;
        overflow: auto
    }
    .form-group {
        margin-bottom: 15px;
    }
    .display_none{
        display: none;
    }
    .fade{
        opacity: .5;
        pointer-events: none;
    }
    .table-hover tbody tr:hover {
        background: #f62d51;
        color: #fff;
    }
</style>

@push('css')
<link href="{{ asset('material') }}/assets/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
@endpush

@include('elements.alert')
<form action="{{ route('bill.store') }}" method="post" class="form-material form">
    @csrf
    <div class="row">
        <div class="m-t-30 col-lg-4 col-md-4">
            <div class="card card-outline-inverse">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa fa-user-o"> </i> &nbsp;{{__('messages.patient_info')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-7">
                            <input name="patient_type" value="new_patient" type="radio" class="with-gap" id="new_patient" checked>
                            <label for="new_patient">{{__('messages.new_patient')}}</label>
                            <input name="patient_type" value="old_patient" type="radio" id="old_patient" class="with-gap">
                            <label for="old_patient">{{__('messages.old_patient')}}</label>
                        </div>
                        <div class="form-group col-md-5 find_user display_none">
                            <input type="text" name="patient_id" id="patient_id" class="form-control form-control-line" placeholder="{{__('messages.type_patient_id')}}" required autocomplete="off" value="{{old('patient_id')}}">
                        </div>
                        {{--
                        <div class="form-group col-md-2 find_user display_none">
                            <span id="findPatient" class="btn bg-theme text-white"><i class="mdi mdi-find-replace"></i></span>
                        </div> --}}
                    </div>

                    <div id="user_area" class="">
                        <div class="row">
                            <div class="form-group col-md-8">
                                <input type="text" name="patient_name" id="patient" class="form-control form-control-line" placeholder="{{__('messages.patient_name')}} (required)" required autocomplete="off" value="{{old('patient_name')}}"> @include('elements.feedback',['field' => 'patient_name'])
                            </div>
                            <div class="form-group col-md-4">
                                <input type="number" name="age" maxlength="2" value="{{old('age')}}" class="form-control  form-control-line" id="age" placeholder="{{__('messages.age')}} (required)" required autocomplete="off">
                            </div>
                            <div class="form-group col-md-8">
                                <input type="number" name="phone" value="{{old('phone')}}" maxlength="11" minlength="11" class="form-control  form-control-line" id="phone" placeholder="{{__('messages.phone_number')}} (required)" required autocomplete="off"> @include('elements.feedback',['field' => 'phone'])
                            </div>
                            <div class="form-group col-md-4">
                                <select class="form-control" required name="blood_group" id="blood_group">
                                <option value="" selected disabled>{{ __('messages.blood_group') }}</option>
                                    <?php echo Pharma::getOptionArray(['A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','O+'=>'O+','O-'=>'O-','AB+'=>'AB+','AB-'=>'AB-'],old('blood_group'))?>
                                </select>
                                @include('elements.feedback',['field' => 'blood_group'])
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" name="address" value="{{old('address')}}" class="form-control  form-control-line" id="address" placeholder="{{__('messages.address')}} (required)" required autocomplete="off"> @include('elements.feedback',['field' => 'address'])
                            </div>
                            <div class="form-group col-md-7">
                                <input name="gender" value="Male" type="radio" class="with-gap" id="Male">
                                <label for="Male">{{__('messages.male')}}</label>
                                <input name="gender" value="Female" type="radio" id="Female" class="with-gap" checked>
                                <label for="Female">{{__('messages.female')}}</label>
                                <input name="gender" value="Other" type="radio" id="Other" class="with-gap">
                                <label for="Other">{{trans_choice('messages.other',1)}}</label>
                            </div>
                            <div class="form-group col-md-5">
                                <input name="marital_status" value="Married" type="radio" class="with-gap" id="Married" checked>
                                <label for="Married">{{__('messages.married')}}</label>
                                <input name="marital_status" value="Single" type="radio" id="Single" class="with-gap">
                                <label for="Single">{{__('messages.single')}}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <select class="form-control" required name="ref_id" id="ref_id">
                                <?php echo Pharma::GetOptions($refarences,'name',1)?>
                            </select>
                        </div>
                        {{-- <div class="form-group col-md-2">
                            <span id="newRefaral" class="btn bg-theme text-white"><i class="fa fa-plus-square"></i></span>
                        </div> --}}
                    </div>

                    <div id="new_refaral" style="display:none">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" name="ref_name" id="ref_name" class="form-control form-control-line" placeholder="Refarel Name (required)">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="ref_contact" id="ref_contact" class="form-control form-control-line" placeholder="Refarel Mobile (required)">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="ref_designation" id="ref_designation" class="form-control form-control-line" placeholder="Designation">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="ref_email" id="ref_email" class="form-control form-control-line" placeholder="Refarel Email">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Column -->
                <div class="col-md-6">

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-sm align-self-center round-info"><i class="mdi mdi-scale-balance"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0 font-light">{{Pharma::amountFormatWithCurrency($TotalBillAmount)}}</h3>
                                <h5 class="text-muted m-b-0">{{__('messages.total_bill')}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-sm align-self-center round-warning"><i class="mdi mdi-cart-outline"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0 font-lgiht">{{Pharma::amountFormatWithCurrency($TotalDue)}}</h3>
                                    <h5 class="text-muted m-b-0">{{__('messages.total_due')}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-sm align-self-center round-primary"><i class="mdi mdi-bullseye"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0 font-lgiht">{{Pharma::amountFormatWithCurrency($TotalExpense)}}</h3>
                                    <h5 class="text-muted m-b-0">{{__('messages.expense')}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-sm align-self-center round-danger"><i class="mdi mdi-library-books"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0 font-lgiht">{{$TodayBillCount}}</h3>
                                    <h5 class="text-muted m-b-0">#{{__('messages.invoice')}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>

        </div>

        <div class="m-t-30 col-lg-8 col-md-8" id="CheckoutModule">
            <div class="row">
                <div class="col-md-7">
                    <div class="card card-outline-inverse">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-shopping-cart"></i> &nbsp;{{__('messages.carts')}}</h4>
                        </div>
                        <div class="card-body">
                            <div id="invoice">
                                <div class="invoice-box">
                                    <table cellpadding="0" cellspacing="0" class="table-bordered">
                                        <tr class="heading">
                                            <td class="text-center">{{__('messages.sl')}}</td>
                                            <td>{{trans_choice('messages.test',1)}} {{__('messages.item')}}</td>
                                            <td class="text-right">{{__('messages.price_in')}}</td>
                                            <td class="text-center">{{__('messages.action')}}</td>
                                        </tr>
                                        <tbody id="cartBody">
                                        </tbody>

                                        <tr class="font-weight-bold">
                                            <td colspan="2" class="text-right">{{__('messages.total')}}</td>
                                            <td class="text-right" id="cartTotal">0.00</td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline-inverse">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"> <i class="fa fa-paper-plane-o"></i> &nbsp;Check Out</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="delivary_date" class="col-sm-3 text-right control-label col-form-label">Delivary<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <input type="text" name="delivary_date" value="{{date('Y-m-d')}}" class="form-control datepickerDB" id="delivary_date" placeholder="delivary_date" required autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                                <input type="text" name="delivary_time" required class="form-control" value="13:14"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                                            </div>
                                            {{--
                                            <input type="time" name="designation" value="{{old('designation')}}" class="form-control" id="designation" placeholder="Designation" required autocomplete="off"> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Sub Total<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="sub_total" value="{{old('sub_total')}}" readonly tabindex="-1" class="form-control" id="sub_total" placeholder="0.00" required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="designation" class="col-sm-3 text-right control-label col-form-label">Discount<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <div class="md-form input-group">
                                                <input type="text" name="discountPercent" value="0.00" class="form-control form-control-line" id="discountPercent" placeholder="discountPercent" autocomplete="off">
                                                <div class="input-group-append"><span class="input-group-text md-addon">%</span></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input type="text" name="percentAmount" value="0.00" readonly tabindex="-1" class="form-control" id="percentAmount" placeholder="0.000" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <div class="md-form input-group">
                                                <input type="text" name="discountOverall" value="0.00" class="form-control" id="discountOverall" placeholder="0.000" autocomplete="off">
                                                <div class="input-group-append"><span class="input-group-text md-addon">{{Pharma::getCurrency()}}</span></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input type="text" name="TotalDiscount" value="0.00" readonly tabindex="-1" class="form-control" id="TotalDiscount" placeholder="0.000" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Grand Total<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="grandTotal" value="{{old('grandTotal')}}" readonly tabindex="-1" class="form-control" id="grandTotal" placeholder="0.00" required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Paid Amount<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="paidAmount" value="{{old('paidAmount')}}" class="form-control" id="paidAmount" placeholder="0.00" required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row" id="due-field" style="display:none">
                                <label for="due" class="col-sm-3 text-right control-label col-form-label">Due <sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="due" value="0.00" class="form-control" id="due" placeholder="0.00" required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row" id="change-field"  style="display:none">
                                <label for="change" class="col-sm-3 text-right control-label col-form-label">Change<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="change" value="0.00" class="form-control" id="change" placeholder="0.00" required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-3 text-right control-label col-form-label">Note <sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <textarea name="description" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-md bg-theme text-white float-right" disabled id="finalCheckOUT"><i class="fa fa-paper-plane-o"></i> &nbsp;Check Out</button>
                        </div>
                    </div>

                </div>
                <div class="col-md-5">
                    <div class="card card-outline-inverse">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa fa-thermometer-2"></i> &nbsp;{{__('messages.test_info')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" name="search" class="form-control form-control-line" id="search" placeholder="Search here" autocomplete="off">
                                </div>
                                <div class="form-group col-md-6">
                                    <select class="form-control form-control-line" required name="categories" id="categories">
                                        <option value="0" selected>All Categories</option>
                                        <?php echo Pharma::GetOptions($testCategories,'category')?>
                                    </select>
                                </div>
                                <div class="test-list-scroll">
                                    <table class="table table-striped table-hover" id="example23">
                                        <thead>
                                            <tr>
                                                <th>Test Name</th>
                                                <th width="150">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listBody">
                                            @foreach($tests as $test)
                                                <tr style="cursor:pointer" id="rowId{{$test->id}}" onclick="addToCart({{$test->id}},'{{$test->name}}','{{$test->price}}')">
                                                    <td>{{$test->name}}</td>
                                                    <td>{{$test->price}}</td>
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
</form>
@endsection


@push('js')
@include('elements.diagnostic-bill');
<script src="{{ asset('js') }}/calculator.js"></script>
<script src="{{ asset('material') }}/assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>
<script src="{{ asset('js') }}/sweetalert.min.js"></script>
<script>
 $('#single-input').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });
    $('.clockpicker').clockpicker({
        donetext: 'Done',
    }).find('input').change(function() {
        console.log(this.value);
    });
    $('#check-minutes').click(function(e) {
        // Have to stop propagation here
        e.stopPropagation();
        input.clockpicker('show').clockpicker('toggleView', 'minutes');
    });
    if (/mobile/i.test(navigator.userAgent)) {
        $('input').prop('readOnly', true);
    }
</script>
@endpush