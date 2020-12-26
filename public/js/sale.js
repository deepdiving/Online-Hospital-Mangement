$(document).ready(function(){
    $("#barcode_input").focus();
    $('.js-example-basic-single').select2();
});

function resetEmpty(rowNo){
    $('#expeire_date'+rowNo).val('');
    $('#current_stock'+rowNo).val('0.00');
    $('#sale_qty'+rowNo).val('1');
    $('#unit_price'+rowNo).val('0.00');
    $('#discount_percent'+rowNo).val('');
    $('#total_price'+rowNo).val('0.00');
}

$('tbody#addSalesItem').on('change keyup','tr td input.sale_qty',function(){
    const rowNo = $(this).data("id");
    const qty = parseFloat($(this).val())||0;
    const current_stock = parseFloat($('#current_stock'+rowNo).val())||0;
    const rate = parseFloat($("#unit_price"+rowNo).val())||0;
    const discount_percent = parseFloat($("#discount_percent"+rowNo).val())||0;
    if(parseFloat(current_stock) < parseFloat(qty)){
        alert('Please Check your Purchase Quantity');
        $(this).val(0);
    }
    calculate(rowNo,qty,rate,discount_percent);
});

$('tbody#addSalesItem').on('change  keyup','tr td input.unit_price',function(){
    const rowNo = $(this).data("id");
    const qty = parseFloat($('#sale_qty'+rowNo).val())||0;
    const rate = parseFloat($(this).val())||0;
    const discount_percent = parseFloat($("#discount_percent"+rowNo).val())||0;
    calculate(rowNo,qty,rate,discount_percent);
});
$('tbody#addSalesItem').on('change  keyup','tr td input.discount_percent',function(){
    const rowNo = $(this).data("id");
    const qty = parseFloat($('#sale_qty'+rowNo).val())||0;
    const rate = parseFloat($("#unit_price"+rowNo).val())||0;
    const discount_percent = parseFloat($(this).val())||0;
    calculate(rowNo,qty,rate,discount_percent);
});

function calculate(rowNo=0,qty=0,rate=0,discount_percent=0){
    const total = parseFloat(qty)*parseFloat(rate);
    const discount = parseFloat(total)/100*discount_percent;
    const total_price = parseFloat(total)-parseFloat(discount);
    $("#discount_amount"+rowNo).val(parseFloat(discount).toFixed(2));
    $("#total_price"+rowNo).val(parseFloat(total_price).toFixed(2));

    const invoice_discount  = parseFloat($("#invoice_discount").val())||0;
    const tax_percent       = parseFloat($("#tax_percent").val())||0;
    const paid_amount       = parseFloat($("#paid_amount").val())||0;

    finalCalculation(invoice_discount,tax_percent,paid_amount);
}

$("#invoice_discount").on('change  keyup',function(){
    const invoice_discount  = parseFloat($(this).val())||0;
    const tax_percent       = parseFloat($("#tax_percent").val())||0;
    const paid_amount       = parseFloat($("#paid_amount").val())||0;
    finalCalculation(invoice_discount,tax_percent,paid_amount);
});

$("#tax_percent").on('change  keyup',function(){
    const invoice_discount  = parseFloat($("#invoice_discount").val())||0;
    const tax_percent       = parseFloat($(this).val())||0;
    const paid_amount       = parseFloat($("#paid_amount").val())||0;
    finalCalculation(invoice_discount,tax_percent,paid_amount);
});

$("#paid_amount").on('change  keyup',function(){
    const paid_amount = parseFloat($(this).val())||0;
    const grand_total       = parseFloat($("#grand_total").val())||0;
    findDueandChange(grand_total,paid_amount);
});

function findDueandChange(grand_total,paid_amount){
    const new_balance   = parseFloat(grand_total).toFixed(2) - parseFloat(paid_amount).toFixed(2);
    if(grand_total < paid_amount){
        $('#new_balance').val('0.00');
        $('#change').val(parseFloat(parseFloat(paid_amount)-parseFloat(grand_total)).toFixed(2));
        $('#change-field').show();
    }else{
        $('#change-field').hide();
        $('#new_balance').val(parseFloat(new_balance).toFixed(2));
        $('#change').val('0.00');
    }
}

function finalCalculation(invoice_discount = 0,tax_percent = 0,paid_amount = 0){
    const pre_balance = parseFloat($("#pre_balance").val())||0;
    var sub_total = 0;
    var sum_discount = 0;

    $(".total_price").each(function(){
        sub_total = parseFloat(sub_total) + parseFloat($(this).val());
    });
    $(".discount_amount").each(function(){
        sum_discount = parseFloat(sum_discount) + parseFloat($(this).val());
    });

    sum_discount = parseFloat(invoice_discount)+parseFloat(sum_discount);



    const actual_total  = parseFloat(sub_total)-parseFloat(invoice_discount);
    const tax_amount    = parseFloat(actual_total)*parseFloat(tax_percent)/100;
    const grand_total   = parseFloat(actual_total) + parseFloat(tax_amount);
    // const net_total     = parseFloat(pre_balance) + parseFloat(grand_total);

    $('#sub_total').val(parseFloat(sub_total).toFixed(2));
    $('#total_discount').val(parseFloat(sum_discount).toFixed(2));
    $('#grand_total').val(parseFloat(grand_total).toFixed(2));
    // $('#net_total').val(parseFloat(net_total).toFixed(2));
    $('#paid_amount').val(parseFloat(grand_total).toFixed(2));
    findDueandChange(grand_total,grand_total);

}
$('tbody#addSalesItem').on('click','tr td span.btn-sm.btn-success.btn.add-row',function(){
        var options = $('tbody#addSalesItem tr td select.productoption').html();
        // console.log(options);
        var rowNo = parseFloat($(this).data("row"))||0;
        rowNo = parseFloat(rowNo) + 1;
        // var options = $("tr td select.js-example-basic-single").html();
        var markup = '';
            markup +='<tr id="row'+rowNo+'">';
            markup +='<td>';
            markup +='<select class="form-control js-example-basic-single productoption" tabindex="-1" name="product_id[]"  id="productId'+rowNo+'" onchange="productInfo('+rowNo+')" required data-id='+rowNo+'>';
            markup += options;
            markup +='</select>';
            markup +='</td>';
            markup +='<td>';
            markup +='<select class="form-control" name="batch_id[]" id="batch_id'+rowNo+'" tabindex="-1" onchange="batchInfo('+rowNo+')" data-id="'+rowNo+'" required>';
            markup +='<option value="">Please select the product first.</option>';
            markup +='</select>';
            markup +='</td>';
            markup +='<td>';
            markup +='<input type="text" name="expiry_date[]" id="expeire_date'+rowNo+'" tabindex="-1" class="form-control" placeholder="Expiry date" required="true" readonly autocomplete="off">';
            markup +='</td>';
            markup +='<td class="wt">';
            markup +='<input type="number" name="current_stock[]" id="current_stock'+rowNo+'" tabindex="-1" class="form-control text-right" placeholder="0.00" readonly autocomplete="off">';
            markup +='</td>';
            markup +='<td class="text-right">';
            markup +='<input type="number" step="any" name="sale_qty[]" id="sale_qty'+rowNo+'" tabindex="-1" class="form-control text-right sale_qty" value="1" data-id="'+rowNo+'" placeholder="0.00" min="0" required="required" autocomplete="off">';
            markup +='</td>';
            markup +='<td>';
            markup +='<input type="number" step="any" name="unit_price[]" id="unit_price'+rowNo+'" tabindex="-1" class="form-control product_rate text-right" data-id="'+rowNo+'" placeholder="0.00" value="" min="0" required="required" autocomplete="off">';
            markup +='</td>';
            markup +='<td>';
            markup +='<div class="input-group">';
            markup +='<input type="number" step="any" name="discount_percent[]" id="discount_percent'+rowNo+'" tabindex="-1" class="form-control discount_percent text-right" data-id="'+rowNo+'" placeholder="0.00" value="" min="0" autocomplete="off">';
            markup +='<div class="input-group-append"><span class="input-group-text md-addon">%</span></div>';
            markup +='</div>';
            markup +='<td>';
            markup +='<input type="number" step="any" name="discount_amount[]" tabindex="-1" id="discount_amount'+rowNo+'" class="form-control discount_amount text-right" data-id="'+rowNo+'" placeholder="0.00" value="0.00" min="0" required="required" readonly autocomplete="off">';
            markup +='</td>';
            markup +='</td>';
            markup +='<td class="text-right">';
            markup +='<input class="form-control total_price text-right" tabindex="-1" type="number" step="any" name="total_price[]" id="total_price'+rowNo+'" value="0.00" readonly>';
            markup +='</td>';
            markup +='<td>';
            markup +='<span class="btn-sm btn-danger" onClick="deleteRow('+rowNo+')"> <i class="fa fa-trash-o"></i></span>';
            markup +='</td>';
            markup +='</tr>';

        $("table tbody").append(markup);
        $(".add-row").data("row",rowNo+1);
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
                const invoice_discount  = parseFloat($("#invoice_discount").val())||0;
                const tax_percent       = parseFloat($("#tax_percent").val())||0;
                const paid_amount       = parseFloat($("#paid_amount").val())||0;
                finalCalculation(invoice_discount,tax_percent,paid_amount);
            }
        });
    }


    function selectBatch(val) {
        $("#barcode_input").val(val);
        $("#barcode_input").focus();
        addchart(val);
        $("#suggesstion-box").hide();
    }

    function dataShow(barcodes) {
        var values = $("select[name='batch_id[]']").map(function(){return $(this).val();}).get();
        var d = parseFloat(barcodes.result.batch_id);
        var ifExist = 'FALSE';
        for (var i = 0; i < values.length; i++) {
            if (parseFloat(values[i]) === parseFloat(d)){
                ifExist = 'TRUE';
                var parentRow = $("select[name='batch_id[]'] option[value='"+d+"']").parent().data('id');
            }
        }
        if(ifExist === 'FALSE'){
            var rowNo = parseFloat($('.add-row').data("row"))||0;
            if(rowNo === 0){
                $('#row0').remove();
                var markup = PosMarkup(rowNo,barcodes);
            } else {
                rowNo = parseFloat(rowNo) + 1;
                var markup = PosMarkup(rowNo,barcodes);
            }
            $("table tbody").append(markup);
            $(".add-row").data("row",rowNo+1);
            $('.js-example-basic-single').select2();
            const invoice_discount  = parseFloat($("#invoice_discount").val())||0;
            const tax_percent       = parseFloat($("#tax_percent").val())||0;
            const paid_amount       = parseFloat($('#paid_amount').val())||0;
            finalCalculation(invoice_discount,tax_percent,paid_amount);
        }else{
            var oldqty = $('#sale_qty'+parentRow).val();
            var newQty = parseFloat(oldqty)+1;
            $('#sale_qty'+parentRow).val(newQty);

            const current_stock = parseFloat($('#current_stock'+parentRow).val())||0;
            const rate = parseFloat($("#unit_price"+parentRow).val())||0;
            const discount_percent = parseFloat($("#discount_percent"+parentRow).val())||0;
            if(parseFloat(current_stock) < parseFloat(newQty)){
                alert('Please Check your Purchase Quantity');
                $('#sale_qty'+parentRow).val(oldqty);
            }
            calculate(parentRow,newQty,rate,discount_percent);

        }

    }

    function PosMarkup(rowNo,barcodes){
        var markup = '';
        markup +='<tr id="row'+rowNo+'">';
        markup +='<td>';
        markup +='<select class="form-control js-example-basic-single productoption" name="product_id[]" tabindex="-1"  id="productId'+rowNo+'" onchange="productInfo('+rowNo+')" required data-id='+rowNo+'>';
        markup += barcodes.productOption;
        markup +='</select>';
        markup +='</td>';
        markup +='<td>';
        markup +='<select class="form-control" name="batch_id[]" id="batch_id'+rowNo+'" tabindex="-1" onchange="batchInfo('+rowNo+')" data-id="'+rowNo+'" required>';
        markup += barcodes.batchOption;
        markup +='</select>';
        markup +='</td>';
        markup +='<td>';
        markup +='<input type="text" name="expiry_date[]" id="expeire_date'+rowNo+'" tabindex="-1" class="form-control" placeholder="Expiry date" value="'+barcodes.result.expiry_date+'" required="true" readonly autocomplete="off">';
        markup +='</td>';
        markup +='<td class="wt">';
        markup +='<input type="number" name="current_stock[]" id="current_stock'+rowNo+'" tabindex="-1" class="form-control text-right" placeholder="0.00" value="'+barcodes.result.in_stock+'" readonly autocomplete="off">';
        markup +='</td>';
        markup +='<td class="text-right">';
        markup +='<input type="number" step="any" name="sale_qty[]" id="sale_qty'+rowNo+'" tabindex="-1" class="form-control text-right sale_qty" value="1" data-id="'+rowNo+'" placeholder="0.00" min="0" required="required" autocomplete="off">';
        markup +='</td>';
        markup +='<td>';
        markup +='<input type="number" step="any" name="unit_price[]" id="unit_price'+rowNo+'" tabindex="-1" class="form-control product_rate text-right" data-id="'+rowNo+'" placeholder="0.00" value="'+barcodes.result.mrp+'" required="required" min="0" autocomplete="off">';
        markup +='</td>';
        markup +='<td>';
        markup +='<div class="input-group">';
        markup +='<input type="number" step="any" name="discount_percent[]" id="discount_percent'+rowNo+'" tabindex="-1" class="form-control discount_percent text-right" data-id="'+rowNo+'" placeholder="0.00" value="" min="0" autocomplete="off">';
        markup +='<div class="input-group-append"><span class="input-group-text md-addon">%</span></div>';
        markup +='</div>';
        markup +='<td>';
        markup +='<input type="number" step="any" name="discount_amount[]" tabindex="-1" id="discount_amount'+rowNo+'" class="form-control discount_amount text-right" data-id="'+rowNo+'" placeholder="0.00" value="0.00" min="0" required="required" readonly autocomplete="off">';
        markup +='</td>';
        markup +='</td>';
        markup +='<td class="text-right">';
        markup +='<input class="form-control total_price text-right" tabindex="-1" type="number" step="any" name="total_price[]" id="total_price'+rowNo+'" value="'+barcodes.result.mrp+'" readonly>';
        markup +='</td>';
        markup +='<td>';
        if(rowNo != 0) {
            markup +=  '<span class="btn-sm btn-danger" onClick="deleteRow('+rowNo+')"> <i class="fa fa-trash-o"></i></span>';
        }else{
            markup += '<span class="btn-sm btn-success btn add-row" data-row="'+rowNo+'"> <i class="fa fa-plus-square"></i></span>';
        }
        markup +='</td>';
        markup +='</tr>';
        return markup;
    }