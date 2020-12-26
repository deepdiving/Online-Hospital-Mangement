@extends('layout.app',['pageTitle' => 'New Addmission','sidebarStyle' => 'mini-sidebar','noFooter' => 'true'])
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
    /* .fade{
        opacity: .5;
        pointer-events: none;
    } */
    .table-hover tbody tr:hover {
        background: #f62d51;
        color: #fff;
    }
    .unselectable{
        background-color: #ddd;
        cursor: not-allowed;
    }
    span.select2.select2-container.select2-container--default{
        width: 100% !important;
    }
</style>

@push('css')
<link href="{{ asset('material') }}/assets/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
@endpush

@include('elements.alert')

<div class="row">
    <div class="m-t-30 col-lg-4 col-md-4">
        <div class="card card-outline-inverse">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><i class="fa fa fa-user-o"> </i> &nbsp;Admission Infromation</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <input type="text" disabled class="form-control" value="{{$admission->bed->bed_no}}">
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" disabled class="form-control" value="{{$admission->date}}">
                    </div>

                    <div class="form-group col-md-8">
                        <input type="text" class="form-control form-control-line" disabled value="{{$admission->patient->patient_name}}">
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control form-control-line" disabled value="{{$admission->patient->age}}">
                    </div>
                    <div class="form-group col-md-8">
                        <input type="text" class="form-control form-control-line" disabled value="{{$admission->patient->phone}}">
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control form-control-line" disabled value="{{$admission->patient->blood_group}}">
                    </div>
                    <div class="form-group col-md-12">
                        <input type="text" class="form-control form-control-line" disabled value="{{$admission->patient->address}}">
                    </div>
                    <div class="form-group col-md-7">
                        <input type="text" class="form-control form-control-line" disabled value="{{$admission->patient->gender}}">
                    </div>
                    <div class="form-group col-md-5">
                        <input type="text" class="form-control form-control-line" disabled value="{{$admission->patient->marital_status}}">
                    </div>
                    <div class="form-group col-md-12">
                        <textarea disabled class="form-control"rows="5">{{$admission->patient->description}}</textarea>
                    </div>


                </div>

        </div>

        </div>

        @include('elements.duecollect',['patient_id'=>$admission->patient->id])
        <!-- Button trigger modal -->


    </div>

    <div class="m-t-30 col-lg-8 col-md-8" id="CheckoutModule">
    <form action="{{ url('hospital/admission/discharge/'.$admission->slug) }}" method="post" class="form-material form" id="deleteButton{{$admission->id}}">
        @csrf
        <div class="row">
            <div class="col-md-7">
                <div class="card card-outline-inverse">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><i class="fa fa-address-card"></i> &nbsp;Given Searvices List</h4>
                    </div>
                    <div class="card-body">
                        <div id="invoice">
                            <div class="invoice-box">
                                <table cellpadding="0" cellspacing="0" class="table-bordered">
                                    <tr class="heading">
                                        <td class="text-center">{{__('messages.sl')}}</td>
                                        <td>Service Name</td>
                                        <td class="text-right">{{__('messages.price_in')}}</td>
                                        <td class="text-center">{{__('messages.action')}}</td>
                                    </tr>
                                    <tbody id="cartBody">
                                        @php $i = 1; @endphp
                                        @foreach($admission->given_services as $item)
                                        <tr width="30" id="CartRowId{{$item->service->id}}">
                                            <td class="text-center sl">{{$i}}</td>
                                            <td>{{$item->service->name}}</td>
                                            <td class="text-right unit_price">{{$item->service->price}}</td>
                                            <td align="center">
                                                    <span class="btn btn-warning" onclick="removeCart({{$item->service->id}})"><i class="mdi mdi-close-box-outline"></i></span>
                                                <input type="hiden" class="display_none" name="test_items[]" value="{{$item->service->id}}">
                                                <input type="hiden" class="display_none" name="test_item_price[]" value="{{$item->service->price}}">
                                            </td>
                                        </tr>
                                        @php $i++; @endphp
                                        @endforeach
                                        {{-- <tr width="30">
                                            <td class="text-center sl">{{$i}}</td>
                                            <td>Bed Service {{$admission->bed->bed_no}} <i>({{$admission->bed->price}} X <span id="stayDays">{{$stayDay}}</span> Days)</i></td>
                                            <td class="text-right unit_price bedserviceprice">{{$admission->bed->price*$stayDay}}.00</td>
                                            <td align="center">
                                                {{-- <input type="hiden" class="display_none" name="test_items[]" value="0">
                                                <input type="hiden" class="display_none" id="bed_service_price_val" name="test_item_price[]" value="{{$admission->bed->price*$stayDay}}">
                                            </td>
                                        </tr> --}}

                                    </tbody>

                                    <tr class="font-weight-bold">
                                        <td colspan="2" class="text-right">{{__('messages.total')}}</td>
                                        <td class="text-right" id="cartTotal">{{Pharma::amountFormatWithCurrency($admission->sub_total)}}</td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-outline-inverse">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> <i class="fa fa-paper-plane-o"></i> &nbsp;Payment Status</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 text-right control-label col-form-label">Discharge<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-6">
                                <input type="text" name="discharge_date" value="{{date('Y-m-d')}}" class="form-control datepickerdischarge" data-date-end-date="0d" id="discharge_date" placeholder="Discharge date" required autocomplete="off">
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                    <input type="text" name="discharge_time" required class="form-control" value="9:00"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                                    </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 text-right control-label col-form-label">Sub Total<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="sub_total" value="{{$admission->sub_total}}" readonly tabindex="-1" class="form-control" id="sub_total" placeholder="0.00" required autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="designation" class="col-sm-3 text-right control-label col-form-label">Discount<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <div class="md-form input-group">
                                            <input type="text" name="discountPercent" value="{{$admission->discount_percent}}" class="form-control form-control-line" id="discountPercent" placeholder="discountPercent" autocomplete="off">
                                            <div class="input-group-append"><span class="input-group-text md-addon">%</span></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <input type="text" name="percentAmount" value="{{number_format($admission->sub_total * $admission->discount_percent / 100,2)}}" readonly tabindex="-1" class="form-control" id="percentAmount" placeholder="0.000" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="md-form input-group">
                                            <input type="text" name="discountOverall" value="{{$admission->discount_overall}}" class="form-control" id="discountOverall" placeholder="0.000" autocomplete="off">
                                            <div class="input-group-append"><span class="input-group-text md-addon">{{Pharma::getCurrency()}}</span></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <input type="text" name="TotalDiscount" value="{{$admission->discount_total}}" readonly tabindex="-1" class="form-control" id="TotalDiscount" placeholder="0.000" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 text-right control-label col-form-label">Grand Total<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="grandTotal" value="{{$grand_total = $admission->grand_total}}" readonly tabindex="-1" class="form-control" id="grandTotal" placeholder="0.00" required autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 text-right control-label col-form-label">Paid Amount<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="paidAmount" value="{{$admission->paid_amount}}" class="form-control" id="paidAmount" placeholder="0.00" required autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row" id="due-field" style="display:none">
                            <label for="due" class="col-sm-3 text-right control-label col-form-label">Due <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-9">
                                @if($admission->due_collection > 0)
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <input type="text" readonly value="{{ $was_due =  $grand_total - $admission->paid_amount}}" class="form-control" placeholder="0.00" required autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input type="text" name="due_collection" readonly value="{{$admission->due_collection}}" class="form-control" id="due_collection" placeholder="0.00" required autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input type="text" name="due" value="{{$was_due - $admission->due_collection}}" class="form-control" id="due" placeholder="0.00" required autocomplete="off">
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
                                <input type="text" name="change" value="0.00" class="form-control" id="change" placeholder="0.00" required autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="remark" class="col-sm-3 text-right control-label col-form-label">Note <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-9">
                                <textarea name="remark" class="form-control" rows="3">{{$admission->remark}}</textarea>
                            </div>
                        </div>
                        <input type="hidden" value="{{$admission->invoice}}" name="invoice">
                        <input type="hidden" value="{{$admission->id}}" name="id">
                        <input type="hidden" value="{{$admission->patient->id}}" name="patient_id">
                        <input type="hidden" value="{{$admission->trans_id}}" name="trans_id">
                        <div class="form-group m-b-0 float-right">
                          <a href="{{url('/hospital/admission')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                          <button type="submit" class="btn bg-theme text-white" id="finalCheckOUT" disabled  onclick="sweetalertDelete({{$admission->id}})"><i class="mdi mdi-eraser"></i> &nbsp;Discharge</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-5">
                <div class="card card-outline-inverse">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><i class="fa fa-list-alt"></i> &nbsp;Service Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" name="search" class="form-control form-control-line" id="search" placeholder="Search here" autocomplete="off">
                            </div>
                            <div class="form-group col-md-6">
                                <select class="form-control form-control-line" required name="service_category_id" id="service_category_id">
                                    <option value="0" selected>All Services</option>
                                    @foreach ($servicecategory as $row)
                                        <option value="{{ $row->id}}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                                @include('elements.feedback',['field' => 'bed_id'])
                            </div>
                            <div class="test-list-scroll">
                                <table class="table table-striped table-hover" id="example23">
                                    <thead>
                                        <tr>
                                            <th>Service Name</th>
                                            <th width="150">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listBody">
                                        @foreach($service as $row)
                                            <tr style="cursor:pointer; {{in_array($row->id,$given_service)?'display:none;':''}}" id="rowId{{$row->id}}" onclick="addToCart({{$row->id}},'{{$row->name}}','{{$row->price}}')">
                                                <td>{{$row->name}}</td>
                                                <td>{{$row->price}}</td>
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
    </form>
    </div>
</div>
@endsection
@push('css')
<link href="{{ asset('material') }}/css/select2.min.css" rel="stylesheet" />
@endpush

@push('js')
@include('elements.hms-admission-discharge');
<script src="{{ asset('material') }}/js/select2.min.js"></script>
<script src="{{ asset('material') }}/assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>
<script src="{{ asset('js') }}/sweetalert.min.js"></script>
<script>
    $('.js-example-basic-single').select2();
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

    $('#discharge_date').change(function(){
        var dischargeDate = $(this).val();
        var start=  new Date("{{$admission->date}}");
    	var end=  new Date(dischargeDate);
        days = (end- start) / (1000 * 60 * 60 * 24);
        days = days+1;
        $('#stayDays').text(days);
        var amount = {{$admission->bed->price}}*days;
        $('#bed_service_price_val').val(parseFloat(amount).toFixed(0));
        $('.bedserviceprice').text(parseFloat(amount).toFixed(2));
        CheckOutCalculation();

    });

    $('.datepickerdischarge').datepicker({
        startDate: '-{{$stayDay-1}}d',
        format:"yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true,
  });
</script>
@endpush
