@extends('layout.app',['pageTitle' => 'Edit Emergency','sidebarStyle' => 'mini-sidebar','noFooter' => 'true'])
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

    .calculator {
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .calculator-screen {
      width: 100%;
      height: 80px;
      border: none;
      background-color: #252525;
      color: #fff;
      text-align: right;
      padding-right: 20px;
      padding-left: 10px;
      font-size: 4rem;
    }

    .calculator-keys button {
      height: 60px;
      font-size: 2rem!important;
    }

    .equal-sign {
        height: 100% !important;
        grid-area: 3 / 4 / 6 / 5;
    }
    .calculator-keys {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      grid-gap: 20px;
      padding: 20px;
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
<form action="{{ route('emergency.update',$emergency) }}" method="post" class="form-material form">
    @csrf
    @method('put')
    <div class="row">
        <div class="m-t-30 col-lg-4 col-md-4">
            <div class="card card-outline-inverse">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa fa-user-o"> </i> &nbsp;Patient Infromation</h4>
                </div>
                <div class="card-body">
                    <div class="row">
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
                                <input type="text"  class="form-control form-control-line" disabled  value="{{ $emergency->patient->patient_name }}">
                            </div>
                            <div class="form-group col-md-4">
                                <input type="number" class="form-control  form-control-line" disabled value="{{$emergency->patient->age}}">
                            </div>
                            <div class="form-group col-md-8">
                                <input type="number" class="form-control  form-control-line" disabled value="{{$emergency->patient->phone}}">
                            </div>
                            <div class="form-group col-md-4">
                               <input type="text" class="form-control form-control-line" disabled value="{{$emergency->patient->blood_group}}">
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control form-control-line" disabled value="{{$emergency->patient->address}}">
                            </div>
                            <div class="form-group col-md-7">
                                <input type="text" class="form-control form-control-line" disabled value="{{$emergency->patient->gender}}">
                            </div>
                            <div class="form-group col-md-5">
                                <input type="text" class="form-control form-control-line" disabled value="{{$emergency->patient->marital_status}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Column -->
                {{-- <div class="col-md-4"> --}}
                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-sm align-self-center round-info"><i class="mdi mdi-scale-balance"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0 font-light">{{Pharma::amountFormatWithCurrency($TotalBillAmount)}}</h3>
                                <h5 class="text-muted m-b-0">{{__('messages.total_bill')}} Amount</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-sm align-self-center round-warning"><i class="mdi mdi-cart-outline"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0 font-lgiht">{{Pharma::amountFormatWithCurrency($TotalDue)}}</h3>
                                    <h5 class="text-muted m-b-0">{{__('messages.total_due')}} Amount</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-sm align-self-center round-primary"><i class="mdi mdi-bullseye"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0 font-lgiht">{{Pharma::amountFormatWithCurrency($TotalExpense)}}</h3>
                                    <h5 class="text-muted m-b-0">{{__('messages.expense')}} Amount</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-sm align-self-center round-danger"><i class="mdi mdi-library-books"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0 font-lgiht">{{$TodayBillCount}}</h3>
                                    <h5 class="text-muted m-b-0"># {{__('messages.invoice')}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- </div>  --}}
            </div>

        </div>

        <div class="m-t-30 col-lg-8 col-md-8" id="CheckoutModule">
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
                                            @php $i =0 @endphp
                                            @foreach ($emergency->given_emergency_services as $item)
                                              <tr width="30" id="CartRowId{{$item->service->id}}">
                                                    <td class="text-center sl">{{++$i}}</td>
                                                    <td>{{$item->service->name}}</td>
                                                    <td class="text-right unit_price">{{$item->service->price}}</td>
                                                    <td align="center"><span class="btn btn-warning" onclick="removeCart({{$item->service->id}})"><i class="mdi mdi-close-box-outline"></i></span>
                                                        <input type="hiden" class="display_none" name="test_items[]" value="{{$item->service->id}}">
                                                        <input type="hiden" class="display_none" name="test_item_price[]" value="{{$item->service->price}}">
                                                    </td>
                                               </tr>
                                            @endforeach
                                        </tbody>

                                        <tr class="font-weight-bold">
                                            <td colspan="2" class="text-right">{{__('messages.total')}}</td>
                                        <td class="text-right" id="cartTotal">{{Pharma::amountFormatWithCurrency($emergency->sub_total)}}</td>
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
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Sub Total<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="sub_total" value="{{$emergency->sub_total}}" readonly tabindex="-1" class="form-control" id="sub_total" required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="designation" class="col-sm-3 text-right control-label col-form-label">Discount<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <div class="md-form input-group">
                                                <input type="text" name="discountPercent" value="{{$emergency->discount_percent}}" class="form-control form-control-line" id="discountPercent" placeholder="discountPercent" autocomplete="off">
                                                <div class="input-group-append"><span class="input-group-text md-addon">%</span></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input type="text" name="percentAmount" value="{{number_format($emergency->sub_total * $emergency->discount_percent / 100,2)}}" readonly tabindex="-1" class="form-control" id="percentAmount" placeholder="0.000" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <div class="md-form input-group">
                                                <input type="text" name="discountOverall" value="{{$emergency->discount_overall}}" class="form-control" id="discountOverall" placeholder="0.000" autocomplete="off">
                                                <div class="input-group-append"><span class="input-group-text md-addon">{{Pharma::getCurrency()}}</span></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input type="text" name="TotalDiscount" value="{{$emergency->discount_total}}" readonly tabindex="-1" class="form-control" id="TotalDiscount" placeholder="0.000" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Grand Total<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="grandTotal" value="{{$emergency->grand_total}}" readonly tabindex="-1" class="form-control" id="grandTotal" placeholder="0.00" required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Paid Amount<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="paidAmount" value="{{$emergency->paid_amount}}" class="form-control" id="paidAmount" placeholder="0.00" required autocomplete="off">
                                </div>
                            </div>
                            {{-- <div class="form-group row" id="due-field" style="display:none">
                                <label for="due" class="col-sm-3 text-right control-label col-form-label">Due <sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="due" value="0.00" class="form-control" id="due" placeholder="0.00" required autocomplete="off">
                                </div>
                            </div> --}}
                            <div class="form-group row" id="due-field" style="display:none">
                                <label for="due" class="col-sm-3 text-right control-label col-form-label">Due <sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    @if($emergency->due_collection > 0)
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <input type="text" readonly value="{{ $was_due =  $emergency->grand_total - $emergency->paid_amount}}" class="form-control" placeholder="0.00" required autocomplete="off">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" name="due_collection" readonly value="{{$emergency->due_collection}}" class="form-control" id="due_collection" placeholder="0.00" required autocomplete="off">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" name="due" value="{{$was_due - $emergency->due_collection}}" class="form-control" id="due" placeholder="0.00" required autocomplete="off">
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
                                    <input type="text" name="change" value="{{$emergency->change}}" class="form-control" id="change" placeholder="0.00" required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="remark" class="col-sm-3 text-right control-label col-form-label">Note <sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <textarea name="remark" class="form-control" rows="3">{{$emergency->remark}}</textarea>
                                </div>
                            </div>
                            <input type="hidden" value="{{$emergency->invoice}}" name="invoice">
                            <input type="hidden" value="{{$emergency->id}}" name="id">
                            <input type="hidden" value="{{$emergency->patient->id}}" name="patient_id">
                            <input type="hidden" value="{{$emergency->trans_id}}" name="trans_id">

                            <div class="form-group m-b-0 float-right">
                            <a href="{{url('/hospital/emergency')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                            <button type="submit" class="btn bg-theme text-white" disabled id="finalCheckOUT"><i class="fa fa-paper-plane-o"></i> &nbsp;Update</button>
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
                                                <tr style="cursor:pointer; {{$row->id == 1? 'display: none;':''}}" id="rowId{{$row->id}}" onclick="addToCart({{$row->id}},'{{$row->name}}','{{$row->price}}')">
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
        </div>
    </div>
</form>
@endsection
@push('css')
<link href="{{ asset('material') }}/css/select2.min.css" rel="stylesheet" />
@endpush

@push('js')
@include('elements.hms-emergency-edit');
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
</script>
@endpush
