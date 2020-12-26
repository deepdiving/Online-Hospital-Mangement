@extends('layout.app',['pageTitle' => __('Add Purchase')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ __('messages.purchase') }}
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

    .purchaseTable {
        opacity: .5;
        pointer-events: none;
    }
</style>
<div class="row">
    <?php $i = 1;?>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material" action="{{ route('purchase.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row" id="manufacturer_info">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="manufacturer_id">{{ __('messages.manufacturer')}} : <i class="text-danger">*</i></label>
                                <select class="form-control basic-single" name="manufacturer_id" required id="manufacturer_id">
                                    <option value="" selected>--Select One--</option>
                                    <?php echo Pharma::GetOptions($manufacturer,'manufacturer_name')?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="date">{{ __('messages.purch_date')}} :<i class="text-danger">*</i></label>
                                <input type="text" class="form-control datepickers" name="date" value="{{date('d-m-Y')}}" id="date" required="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="invoice_no">{{ __('messages.invoice_no')}} :<i class="text-danger">*</i></label>
                                <input type="text" class="form-control" name="invoice" placeholder="Invoice No" id="invoice_no" value="{{$invoice}}" required="" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive" style="margin-top: 10px">
                        <table class="table table-bordered table-hover purchaseTable" id="purchaseTable">
                            <thead>
                                <tr class="themeThead">
                                    <th class="text-left" width="30%">{{ __('messages.item_info')}}<i class="text-white">*</i></th>
                                    <th class="text-left">{{ __('messages.ex_date')}} <i class="text-white">*</i></th>
                                    <th class="text-right">{{ __('messages.current_stock')}}</th>
                                    <th class="text-right">{{ __('messages.quentity')}} <i class="text-white">*</i></th>
                                    <th class="text-right">{{ __('messages.purch_price')}}<i class="text-white">*</i></th>
                                    <th class="text-right">{{ __('messages.total_amount')}}</th>
                                    <th class="text-left">{{ __('messages.action')}}</th>
                                </tr>
                            </thead>
                            <tbody id="addPurchaseItem">
                                <?php
                                    for($i=0;$i<2;$i++){
                                    ?>
                                <tr>
                                    <td>
                                        <select class="form-control js-example-basic-single" name="product_id[]" data-id="{{$i}}" required>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="expiry_date[]" id="expeire_date{{$i}}" class="form-control datepicker" placeholder="Expiry date" required="" autocomplete="off">
                                    </td>
                                    <td class="wt">
                                        <input type="number" tabindex="-1" name="was_stock[]" id="was_stock{{$i}}" class="form-control text-right" placeholder="0.00" readonly autocomplete="off">
                                    </td>
                                    <td class="text-right">
                                        <input type="number" step="any" name="qty[]" id="quantity{{$i}}" class="form-control text-right stock_qty" value="" data-id="{{$i}}" placeholder="0.00" min="0" required="required" autocomplete="off">
                                    </td>
                                    <td>
                                        <input type="number" step="any" name="unit_price[]" id="unit_price{{$i}}" class="form-control product_rate text-right" data-id="{{$i}}" placeholder="0.00" value="0" min="0" required="required" autocomplete="off">
                                    </td>
                                    <td class="text-right">
                                        <input class="form-control total_price text-right" type="number" step="any" tabindex="-1" name="total_price" id="total_price{{$i}}" value="0.00" readonly>
                                    </td>
                                    <td>
                                        @if($i!=0)<span class="btn-sm btn-danger btn"> <i class="fa fa-trash-o"></i>
                                        </span>@endif
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>
                                        <input type="button" id="add_invoice_item" class="btn bg-theme text-light add-row" data-row="5" name="add-invoice-item" value="Add New">
                                        <input type="hidden" name="baseUrl" class="baseUrl" value="">
                                    </td>
                                    <td style="text-align:right;" colspan="4"><b>{{ __('messages.total_amount')}}:</b></td>
                                    <td class="text-right">
                                        <input type="number" step="any" tabindex="-1" id="totalAmount" class="text-right form-control" name="purchase_amount" value="0.00" readonly="readonly">
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="5" colspan="4">
                                        <div class="form-group" style="padding:0">
                                            <textarea name="description" id="note" class="form-control" rows="12" placeholder="Write a shot note here..."></textarea>
                                        </div>
                                    </td>
                                    <td style="text-align:right;"><b>{{ __('messages.tax')}}:</b></td>
                                    <td class="text-right">
                                        <div class="input-group">
                                            <input type="number" step="any" id="taxPercent" class="text-right form-control" name="tax_percent" value="{{session()->get('settings')[0]['purchase_tax']}}" autocomplete="off">
                                            <div class="input-group-append"><span class="input-group-text md-addon">%</span></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:right;"><b>{{ __('messages.grand_total')}}:</b></td>
                                    <td class="text-right">
                                        <input type="number" step="any" id="grandTotal" tabindex="-1" class="text-right form-control" name="grand_total" readonly value="0.00" autocomplete="off">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:right;"><b>{{ __('messages.discount') }}:</b></td>
                                    <td class="text-right">
                                        <input type="number" step="any" id="discount" class="text-right form-control" name="discount" value="0.00" autocomplete="off">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:right;"><b>{{ __('messages.payable_amount')}}:</b></td>
                                    <td class="text-right">
                                        <input type="number" step="any" tabindex="-1" id="payableAmount" class="text-right form-control" name="payable_amount" value="0.00" readonly="readonly">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:right;"><b>{{ __('Payment')}}:</b></td>
                                    <td class="text-left">
                                        <input type="checkbox" id="md_checkbox_21" class="filled-in chk-col-success" name="isPayment" value="yes">
                                        <label for="md_checkbox_21">{{ __('messages.make_payment')}}</label>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <button type="submit" class="btn waves-effect waves-light btn-lg bg-theme text-light float-right" style="margin-right:75px">{{ __('messages.save_purch')}}</button>
                </div>
            </form>

        </div>
    </div>
</div>

</div>
@endsection
@push('css')
<link href="{{ asset('material') }}/css/select2.min.css" rel="stylesheet" />
@endpush

@push('js')
<script src="{{ asset('material') }}/js/select2.min.js"></script>
<script src="{{ asset('material') }}/assets/plugins/moment/moment.js"></script>
<script>
    $(document).ready(function () {
        $('#manufacturer_id').on('change',function(){
            var id = $(this).val();
            console.log(id);
            $.ajax({
                type: "GET",
                url: "manufacturersProduct/"+id,
                data: "data",
                dataType: "text",
                success: function (response) {
                    if(response != ""){
                        $("tr td select.js-example-basic-single").html('<option value="" selected>--Select One--</option>'+response);
                        $("#purchaseTable").removeClass('purchaseTable');
                    }else{
                        $("#purchaseTable").addClass('purchaseTable');
                        $("tr td select.js-example-basic-single").html('<option value="" selected>--Select One--</option>');
                        alert('No Data Found');
                    }
                }
            });
        });

        $(".add-row").click(function(){
            var rowNo = $(this).data("row");
            var options = $("tr td select.js-example-basic-single").html();
            console.log(options);
            var markup = '';
                markup +='<tr>';
                markup +='<td>';
                markup +='<select class="form-control js-example-basic-single" name="product_id[]" required data-id="'+rowNo+'">';
                markup += options;
                markup +='</select>';
                markup +='</td>';
                markup +='<td>';
                markup +='<input type="text" name="expiry_date[]" id="expeire_date'+rowNo+'" class="form-control datepicker" placeholder="Expiry date" required="true" autocomplete="off">';
                markup +='</td>';
                markup +='<td class="wt">';
                markup +='<input type="number" name="was_stock[]" tabindex="-1" id="was_stock'+rowNo+'" class="form-control text-right" placeholder="0.00" readonly autocomplete="off">';
                markup +='</td>';
                markup +='<td class="text-right">';
                markup +='<input type="number" step="any" name="qty[]" id="quantity'+rowNo+'" class="form-control text-right stock_qty" value="" data-id="'+rowNo+'" placeholder="0.00" min="0" required="required" autocomplete="off">';
                markup +='</td>';
                markup +='<td>';
                markup +='<input type="number" step="any" name="unit_price[]" id="unit_price'+rowNo+'" class="form-control product_rate text-right" data-id="'+rowNo+'" placeholder="0.00" value="" min="0" required="required" autocomplete="off">';
                markup +='</td>';
                markup +='<td class="text-right">';
                markup +='<input class="form-control total_price text-right" type="number" step="any" tabindex="-1" name="total_price" id="total_price'+rowNo+'" value="0.00" readonly>';
                markup +='</td>';
                markup +='<td>';
                markup +='<span class="btn-sm btn-danger btn" > <i class="fa fa-trash-o"></i></span>';
                markup +='</td>';
                markup +='</tr>';

            $("table tbody").append(markup);
            $(".add-row").data("row",rowNo+1);
            $('.datepicker').datepicker({
                startDate: '-0d',
                autoclose: true,
                todayHighlight: true,
                format:"dd-mm-yyyy"
            });

            $('.js-example-basic-single').select2();

        });
        function deleteRow(rowNo){
            swal({
                title: "Are you sure?",
                text: "Delete this row!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Row has been deleted!", {
                        icon: "success",
                        buttons: false,
                        timer: 1000
                    });
                    $('#row'+rowNo).remove()
                    // $('#row'+rowNo).hide("slow", function() { $('#row'+rowNo).remove();});
                    const invoice_discount = parseFloat($("#invoice_discount").val())||0;
                    const tax_percent = parseFloat($("#tax_percent").val())||0;
                    const paid_amount = parseFloat($("#paid_amount").val())||0;
                    finalCalculation(invoice_discount,tax_percent,paid_amount);
                }
            });
        }

        $('.table tbody').on('click','.btn', function () {
            swal({
                title: "Are you sure?",
                text: "Delete this row!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Row has been deleted!", {
                        icon: "success",
                        buttons: false,
                        timer: 1000
                    });
                    $(this).closest('tr').remove();
                    var sum=0;
                    const discount = $('#discount').val();
                    $(".total_price").each(function(){
                        sum = parseFloat(sum) + parseFloat($(this).val());
                    });
                    const payable = parseFloat(sum) - parseFloat(discount);
                    $('#totalAmount').val(parseFloat(sum).toFixed(2));
                    $('#payableAmount').val(parseFloat(payable).toFixed(2));
                }
            });
            
        });
    });

    $('.basic-single').select2();

    $('.js-example-basic-single').select2();

    $('tbody#addPurchaseItem').on('change','tr td select.js-example-basic-single',function(){
        const rowNo = $(this).data("id");
        const slug = $(this).val();
        var qty = $("#quantity"+rowNo).val();
        if(qty == ""){qty = 0;}
        product_info(rowNo,slug,qty);

    });

    $('tbody#addPurchaseItem').on('change keyup','tr td input.stock_qty',function(){
        const rowNo = $(this).data("id");
        const qty = $(this).val();
        const rate = $("#unit_price"+rowNo).val();
        calculate(rowNo,qty,rate);
    });
    $('#discount').on('change keyup',function(){
        const grandTotal = $('#grandTotal').val();
        const payable = parseFloat(grandTotal) - parseFloat($(this).val());
        $('#payableAmount').val(parseFloat(payable).toFixed(2));
    });
    $('#taxPercent').on('change keyup',function(){
        const discount = $('#discount').val();
        const sum = $('#totalAmount').val();
        const taxAmount = (parseFloat(sum) * parseFloat($(this).val()))/100;
        const GrandTotal = parseFloat(sum) + parseFloat(taxAmount);
        const payable = parseFloat(GrandTotal) - parseFloat(discount);
        $('#grandTotal').val(parseFloat(GrandTotal).toFixed(2));
        $('#payableAmount').val(parseFloat(payable).toFixed(2));
    });

    $('tbody#addPurchaseItem').on('change  keyup','tr td input.product_rate',function(){
        const rowNo = $(this).data("id");
        const rate = $(this).val();
        var qty = $("#quantity"+rowNo).val();
        if(qty == ""){qty = 0;}
        calculate(rowNo,qty,rate);
    });


    function product_info(rowNo,slug,qty){
        $.ajax({
            type: "GET",
            url: "product/"+slug,
            data: "data",
            dataType: "json",
            success: function (response) {
                $("#was_stock"+rowNo).val(response.stock);
                $("#unit_price"+rowNo).val(response.purchase_price);
                calculate(rowNo,qty,response.purchase_price);
            }
        });
    }

    function calculate(rowNo=0,qty=0,rate=0){
        const total = parseFloat(qty)*parseFloat(rate);
        $("#total_price"+rowNo).val(parseFloat(total).toFixed(2));
        const taxPercent = $("#taxPercent").val();
        var sum = 0;
        const discount = $('#discount').val();
        $(".total_price").each(function(){
            sum = parseFloat(sum) + parseFloat($(this).val());
        });
        const taxAmount = (parseFloat(sum) * parseFloat(taxPercent))/100;
        const GrandTotal = parseFloat(sum) + parseFloat(taxAmount);
        const payable = parseFloat(GrandTotal) - parseFloat(discount);
        $('#grandTotal').val(parseFloat(GrandTotal).toFixed(2));
        $('#totalAmount').val(parseFloat(sum).toFixed(2));
        $('#payableAmount').val(parseFloat(payable).toFixed()+'.00');
    }

</script>

@endpush