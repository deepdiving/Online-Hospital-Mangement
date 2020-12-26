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
<form action="{{ route('bill.update',$bill) }}" method="post" class="form-material form">
    @csrf
    @method('put')
    <div class="row">
        <div class="m-t-30 col-lg-4 col-md-4">
            <div class="card card-outline-inverse">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa fa-user-o"> </i> &nbsp;{{__('messages.patient_info')}}</h4>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-8">
                                <input type="text" class="form-control form-control-line" disabled value="{{$bill->patient->patient_name}}">
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" class="form-control form-control-line" disabled value="{{$bill->patient->age}}">
                            </div>
                            <div class="form-group col-md-8">
                                <input type="text" class="form-control form-control-line" disabled value="{{$bill->patient->phone}}">
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" class="form-control form-control-line" disabled value="{{$bill->patient->blood_group}}">
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control form-control-line" disabled value="{{$bill->patient->address}}">
                            </div>
                            <div class="form-group col-md-7">
                                <input type="text" class="form-control form-control-line" disabled value="{{$bill->patient->gender}}">
                            </div>
                            <div class="form-group col-md-5">
                                <input type="text" class="form-control form-control-line" disabled value="{{$bill->patient->marital_status}}">
                            </div>
                        </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <input type="text" disabled value="asdf" class="form-control  form-control-line">
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
                                    <h5 class="text-muted m-b-0">Total Bill</h5>
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
                                    <h5 class="text-muted m-b-0">Total Due</h5>
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
                                    <h5 class="text-muted m-b-0">Expense</h5>
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
                                    <h5 class="text-muted m-b-0">#Invoice</h5>
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
                            <h4 class="m-b-0 text-white"><i class="fa fa-shopping-cart"></i> &nbsp;Carts</h4>
                        </div>
                        <div class="card-body">
                            <div id="invoice">
                                <div class="invoice-box">
                                    <table cellpadding="0" cellspacing="0" class="table-bordered">
                                        <tr class="heading">
                                            <td class="text-center">SL</td>
                                            <td>Test Item</td>
                                            <td class="text-right">Price</td>
                                            <td class="text-center">Action</td>
                                        </tr>
                                        <tbody id="cartBody">
                                            @foreach($bill->billItem as $item)
                                            <tr width="30" id="CartRowId{{$item->test->id}}">
                                                <td class="text-center sl">1</td>
                                                <td>{{$item->test->name}}</td>
                                                <td class="text-right unit_price">{{$item->test->price}}</td>
                                                <td align="center"><span class="btn btn-warning" onclick="removeCart({{$item->test->id}})"><i class="mdi mdi-close-box-outline"></i></span>
                                                    <input type="hiden" class="display_none" name="test_items[]" value="{{$item->test->id}}">
                                                    <input type="hiden" class="display_none" name="test_item_price[]" value="{{$item->test->price}}">
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                        <tr class="font-weight-bold">
                                            <td colspan="2" class="text-right">Total</td>
                                            <td class="text-right" id="cartTotal">{{Pharma::amountFormatWithCurrency($bill->sub_total)}}</td>
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
                                            <input type="text" name="delivary_date" value="{{$bill->date}}" class="form-control datepickerDB" id="delivary_date" placeholder="delivary_date" required autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                                <input type="text" name="delivary_time" required class="form-control" value="{{$bill->delivary_time}}"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Sub Total<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="sub_total" value="{{$bill->sub_total}}" readonly tabindex="-1" class="form-control" id="sub_total" required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="designation" class="col-sm-3 text-right control-label col-form-label">Discount<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <div class="md-form input-group">
                                                <input type="text" name="discountPercent" value="{{$bill->discount_percent}}" class="form-control form-control-line" id="discountPercent" placeholder="discountPercent" autocomplete="off">
                                                <div class="input-group-append"><span class="input-group-text md-addon">%</span></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input type="text" name="percentAmount" value="{{number_format($bill->sub_total * $bill->discount_percent / 100,2)}}" readonly tabindex="-1" class="form-control" id="percentAmount" placeholder="0.000" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <div class="md-form input-group">
                                                <input type="text" name="discountOverall" value="{{$bill->discount_overall}}" class="form-control" id="discountOverall" placeholder="0.000" autocomplete="off">
                                                <div class="input-group-append"><span class="input-group-text md-addon">{{Pharma::getCurrency()}}</span></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input type="text" name="TotalDiscount" value="{{$bill->discount_total}}" readonly tabindex="-1" class="form-control" id="TotalDiscount" placeholder="0.000" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Grand Total<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="grandTotal" value="{{$bill->grand_total}}" readonly tabindex="-1" class="form-control" id="grandTotal" placeholder="0.00" required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Paid Amount<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="paidAmount" value="{{$bill->paid_amount}}" class="form-control" id="paidAmount" placeholder="0.00" required autocomplete="off">
                                </div>
                            </div>
                            {{-- <div class="form-group row" id="due-field" style="display:none">
                                <label for="due" class="col-sm-3 text-right control-label col-form-label">Due <sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="due" value="{{$bill->due}}" class="form-control" id="due" placeholder="0.00" required autocomplete="off">
                                </div>
                            </div> --}}
                            <div class="form-group row" id="due-field" style="display:none">
                                <label for="due" class="col-sm-3 text-right control-label col-form-label">Due <sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    @if($bill->due_collection > 0)
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <input type="text" readonly value="{{ $was_due =  $bill->grand_total - $bill->paid_amount}}" class="form-control" placeholder="0.00" required autocomplete="off">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" name="due_collection" readonly value="{{$bill->due_collection}}" class="form-control" id="due_collection" placeholder="0.00" required autocomplete="off">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" name="due" value="{{$was_due - $bill->due_collection}}" class="form-control" id="due" placeholder="0.00" required autocomplete="off">
                                            </div>
                                        </div>
                                    @else
                                        <input type="text" name="due" value="0.00" class="form-control" id="due" placeholder="0.00" required autocomplete="off">
                                        <input type="hidden" value="0" id="due_collection">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row" id="change-field"  style="display:none">
                                <label for="change" class="col-sm-3 text-right control-label col-form-label">Changes<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="change" value="{{$bill->change}}" class="form-control" id="change" placeholder="0.00" required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-3 text-right control-label col-form-label">Note <sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <textarea name="description" class="form-control" rows="3">{{$bill->description}}</textarea>
                                </div>
                            </div>
                            <input type="hidden" value="{{$bill->invoice}}" name="invoice">
                            <input type="hidden" value="{{$bill->id}}" name="id">
                            <input type="hidden" value="{{$bill->patient->id}}" name="patient_id">
                            <input type="hidden" value="{{$bill->trans_id}}" name="trans_id">
                            <button type="submit" class="btn btn-md bg-theme text-white float-right" disabled id="finalCheckOUT"><i class="fa fa-paper-plane-o"></i> &nbsp;Update</button>
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
@include('elements.diagnostic-bill-edit');
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

    $(document).ready(function(){
        const paid_amount       = parseFloat($('#paidAmount').val())||0;
        const grand_total       = parseFloat($('#grandTotal').val())||0;
        findDueandChange(grand_total,paid_amount);
    });
</script>
@endpush