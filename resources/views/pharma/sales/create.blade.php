@extends('layout.app',['pageTitle' => __('Sale Management')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ __('messages.sales') }}
@endslot
@endcomponent
@include('elements.alert')
<style>
    .form-group {
        padding: 10px;
    }
    .form-group {
        margin-bottom: 0px;
    }

    #newcustomer {
        line-height: 0;
        font-size: 37px;
    }
    .suggesstion-box-ul{
        padding: 0px;
        list-style: none;
        margin-bottom:0px;
    }
    
    #suggesstion-box{
        position: absolute;
        z-index: 3;
        width: 96%;
        background: #fff;
        max-height: 300px;
        overflow-y: scroll;
        margin-top: 8px;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card p-2">
            <div class="card-body">
                <div class="">
                    <div class="form-material">
                        <input type="text" name="barcode" min="11" required class="form-control" autocomplete="off" id="barcode_input" placeholder="Scan your barcode or find batch">
                        <br>
                        <div id="suggesstion-box" style="display:none;"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php $i = 1;?>
        <div class="card">
            <div class="card-body">
                <form class="form-material" action="{{ route('sale.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row" id="customer_info">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="customer_id">{{ trans_choice('messages.patient', 1)}} : <i class="text-danger">*</i></label>
                                <div class="d-flex">
                                    <div class="md-form input-group">
                                        <select class="form-control js-example-basic-single" tabindex="-1" name="patient_id" required id="customer_id">
                                            <?php echo Pharma::GetOptions($customers,'patient_name',1)?>
                                        </select>
                                    </div>
                                    <div id="newcustomer"><i class="mdi mdi-plus-box text-success"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="date">{{ __('messages.date')}} :<i class="text-danger">*</i></label>
                                <input type="text" class="form-control datepickers" tabindex="-1" name="date" value="{{date('d-m-Y')}}" id="date" required="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="invoice_no">{{ __('messages.invoice_no')}} :<i class="text-danger">*</i></label>
                                <input type="text" class="form-control" name="invoice" tabindex="-1" placeholder="Invoice No" value="{{$invoice}}" id="invoice_no" required="" readonly autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="row" id="new_customer" style="display:none">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="patient_name">{{ __('messages.name')}} :<i class="text-danger">*</i></label>
                                <input type="text" class="form-control" name="patient_name" placeholder="Customer Name" value="" id="patient_name" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="customer_address">{{ __('messages.address')}} :<i class="text-danger">*</i></label>
                                <input type="text" class="form-control" name="customer_address" placeholder="Customer Address" value="" id="customer_address" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="customer_phone">{{ __('messages.phone')}} :<i class="text-danger">*</i></label>
                                <input type="text" class="form-control" name="customer_phone" placeholder="Customer Phone" id="customer_phone" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive" style="margin-top: 10px">
                        <table class="table table-bordered table-hover purchaseTable" id="purchaseTable">
                            <thead>
                                <tr class="themeThead">
                                    <th class="text-left" width="16%">{{ __('messages.item_info')}}<i class="text-white">*</i></th>
                                    <th class="text-left" width="15%">{{ __('messages.batch_number')}} <i class="text-white">*</i></th>
                                    <th class="text-left">{{ __('messages.ex_date')}} <i class="text-white">*</i></th>
                                    <th class="text-right">{{ __('messages.stock')}}</th>
                                    <th class="text-right">{{ __('messages.quentity')}} <i class="text-white">*</i></th>
                                    <th class="text-right">{{ __('messages.mrp')}}<i class="text-white">*</i></th>
                                    <th class="text-right">{{ __('messages.discount')}} %</th>
                                    <th class="text-right">{{ __('messages.discount')}} {{Pharma::getCurrency()}}</th>
                                    <th class="text-right">{{ __('messages.total')}}</th>
                                    <th class="text-right">{{ __('messages.action')}}</th>
                                </tr>
                            </thead>
                            <tbody id="addSalesItem">
                                <?php for($i=0;$i<1;$i++){ ?>
                                    <tr id="row{{$i}}">
                                        <td>
                                            <select class="form-control js-example-basic-single productoption" tabindex="-1" name="product_id[]" data-id="{{$i}}" id="productId{{$i}}" onchange="productInfo({{$i}})" required>
                                                <option value="" selected>--Select One--</option>
                                                <?php echo Pharma::GetOptions($products,'title')?>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control" tabindex="-1" name="batch_id[]" id="batch_id{{$i}}" onchange="batchInfo({{$i}})" data-id="{{$i}}" required>
                                                <option value="">Please select the product first.</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text"  name="expiry_date[]" id="expeire_date{{$i}}" tabindex="-1" class="form-control mdate" placeholder="Expiry date" required="" readonly autocomplete="off">
                                        </td>
                                        <td class="wt">
                                            <input type="number" name="current_stock[]" id="current_stock{{$i}}" tabindex="-1" class="form-control text-right" placeholder="0.00" readonly autocomplete="off">
                                        </td>
                                        <td class="text-right">
                                            <input type="number" step="any" name="sale_qty[]" id="sale_qty{{$i}}" tabindex="-1" class="form-control text-right sale_qty" value="1" data-id="{{$i}}" placeholder="0.00" min="0" required="required" autocomplete="off">
                                        </td>
                                        <td>
                                            <input type="number" step="any" name="unit_price[]" id="unit_price{{$i}}" tabindex="-1" class="form-control unit_price text-right" data-id="{{$i}}" placeholder="0.00" value="" min="1" required="required" autocomplete="off">
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" step="any" name="discount_percent[]" id="discount_percent{{$i}}" tabindex="-1" class="form-control discount_percent text-right" data-id="{{$i}}" placeholder="0.00" value="" min="0" autocomplete="off">
                                                <div class="input-group-append"><span class="input-group-text md-addon">%</span></div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" step="any" name="discount_amount[]" id="discount_amount{{$i}}" tabindex="-1" class="form-control discount_amount text-right" data-id="{{$i}}" placeholder="0.00" value="0.00" min="0" required="required" readonly autocomplete="off">
                                        </td>
                                        <td class="text-right">
                                            <input class="form-control total_price text-right" type="number" step="any" name="total_price[]" tabindex="-1" id="total_price{{$i}}" value="0.00" readonly>
                                        </td>
                                        <td>
                                            @if($i!=0)
                                            <span class="btn-sm btn-danger" onClick="deleteRow({{$i}})"> <i class="fa fa-trash-o"></i></span> @else
                                            <span class="btn-sm btn-success btn add-row" data-row="{{$i}}"> <i class="fa fa-plus-square"></i></span> @endif
                                        </td>
                                    </tr>
                                <?php }?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td rowspan="4" colspan="7">
                                        <div class="form-group" style="padding:0">
                                            <textarea name="description" id="note" class="form-control" rows="12" tabindex="-1" placeholder="Write a shot note here..."></textarea>
                                        </div>
                                    </td>
                                    <td style="text-align:right;"><b>{{ __('messages.sub_total')}}:</b></td>
                                    <td class="text-right">
                                        <input type="number" step="any" id="sub_total" class="text-right form-control" tabindex="-1" name="sub_total" readonly value="0.00">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:right;"><b>{{ __('messages.invoice_dis')}}.:</b></td>
                                    <td class="text-right">
                                        <input type="number" step="any" id="invoice_discount" class="text-right form-control" tabindex="-1" min="0" name="invoice_discount" placeholder="0.00" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:right;"><b>{{ __('messages.total_discount')}}:</b></td>
                                    <td class="text-right">
                                        <input type="number" step="any" id="total_discount" class="text-right form-control" tabindex="-1" name="total_discount" value="0.00" readonly="readonly">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:right;"><b>{{ __('messages.tax')}}:</b></td>
                                    <td class="text-right">
                                        <div class="input-group">
                                            <input type="number" step="any" id="tax_percent" class="text-right form-control" min="0" tabindex="-1" name="tax_percent" value="{{session()->get('settings')[0]['sale_tax']}}" placeholder="0.00" autocomplete="off">
                                            <div class="input-group-append"><span class="input-group-text md-addon">%</span></div>
                                        </div>
                                    </td>
                                </tr>

                                <tr id="grand-total-field">
                                    <td style="text-align:right;" colspan="8"><b>{{ __('messages.grand_total')}}:</b></td>
                                    <td class="text-right">
                                        <input type="number" step="any" id="grand_total" class="text-right form-control" tabindex="-1" name="grand_total" value="0.00" autocomplete="off" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:right;" colspan="8"><b>{{ __('messages.paid_amount')}}:</b></td>
                                    <td class="text-right">
                                        <input type="number" step="any" id="paid_amount" class="text-right form-control" min="0" name="paid_amount" placeholder="0.00" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:right;" colspan="8"><b>{{ __('messages.due')}}:</b></td>
                                    <td class="text-right">
                                        <input type="number" step="any" id="new_balance" tabindex="-1" class="text-right form-control" name="new_balance" value="0.00" readonly="readonly">
                                    </td>
                                </tr>
                                <tr id="change-field" style="display:none">
                                    <td style="text-align:right;" colspan="8"><b>{{ __('messages.Change')}}:</b></td>
                                    <td class="text-right">
                                        <input type="number" step="any" id="change" tabindex="-1" class="text-right form-control" name="change" value="0.00" readonly="readonly">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <button type="submit" name="save" value ="savePrint" class="btn waves-effect waves-light btn-lg btn-themecolor float-right formSave" style="margin-right:75px"> <i class="mdi mdi-printer"></i> {{ __('messages.save_print')}}</button>
                    <button type="submit" name="save" value="saveMore" class="btn waves-effect waves-light btn-lg btn-success float-right formSave mr-3"> <i class="mdi mdi-open-in-new"></i> {{ __('messages.save_more')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@include('elements.sale')