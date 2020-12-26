
@push('css')
<link href="{{ asset('material') }}/css/select2.min.css" rel="stylesheet" />
@endpush

@push('js')
<script src="{{ asset('material') }}/js/select2.min.js"></script>
<script src="{{ asset('material') }}/assets/plugins/moment/moment.js"></script>
<script src="{{ asset('js') }}/sweetalert.min.js"></script>

<script>
// product add by barcode
    $('#barcode_input').keyup(function(e){
        e.preventDefault();
        var barcode = $('input[name=barcode]').val();
        $.ajax({
            type: "GET",
            url: "{{url('batch/saggestion')}}/"+barcode,
            data: "data",
            dataType: "text",
            beforeSend: function(){},
            success: function (data) {
                $("#suggesstion-box").show();
                $("#suggesstion-box").html(data);
            }
        });
        $(body).click(function(){
            $("#suggesstion-box").hide();
        });
        if(e.keyCode == 13){
            addchart(barcode);
        }
    });

    function addchart(barcode){
        $.ajax({
            type: "GET",
            url: "{{url('sale/products')}}/"+barcode,
            data: "data",
            dataType: "json",
            beforeSend: function(){
                $('#addSalesItem').css('opacity','.5');
            },
            success: function (barcodes) {
                if(barcodes.status === "OK"){
                    dataShow(barcodes);
                    $('#addSalesItem').css('opacity','1');
                    $('input[name=barcode]').val('');
                    $('#name-error').html('');
                }else if(barcodes.status === 'Expired'){
                    swal("The Selected Item has already beed expired!", {icon: "error",buttons: false,timer: 2000});
                    $('#addSalesItem').css('opacity','1');
                    $('input[name=barcode]').val('');
                }else{
                    $('#addSalesItem').css('opacity','1');
                    // $('#name-error').html('Invlaid Batch Number');
                    swal("The Selected not found!", {icon: "error",buttons: false,timer: 2000});
                    $('input[name=barcode]').val('');
                }
                $("#suggesstion-box").hide();
            }
        });
    }

    $('#customer_id').on('change',function(){
        var id = parseFloat($(this).val())||0;
        if(id>1){
            $.ajax({
                type: "GET",
                url: "{{url('sale/customer')}}/"+id,
                data: "data",
                dataType: "json",
                success: function (response) {
                    // $('#grand-total-field').show();
                    // $('#pre_balance').val(response.customer_balance);
                    // $('#pre-balance-field').show();
                    // const invoice_discount  = parseFloat($("#invoice_discount").val())||0;
                    // const tax_percent       = parseFloat($("#tax_percent").val())||0;
                    // const paid_amount       = parseFloat($("#paid_amount").val())||0;
                    // finalCalculation(invoice_discount,tax_percent,paid_amount);
                }
            });
        }else{
            // $('#pre_balance').val(0);
            // $('#grand-total-field').hide();
            // $('#pre-balance-field').hide();
            // const invoice_discount  = parseFloat($("#invoice_discount").val())||0;
            // const tax_percent       = parseFloat($("#tax_percent").val())||0;
            // const paid_amount       = parseFloat($("#paid_amount").val())||0;
            // finalCalculation(invoice_discount,tax_percent,paid_amount);
        }
    });

    function productInfo(rowNo){
        resetEmpty(rowNo);
        var id = $('#productId'+rowNo).val();
        var options = '<option value="">Select Batch Number</option>';
        $.ajax({
            type: "GET",
            url: "{{url('batch/product')}}/"+id,
            data: "data",
            dataType: "json",
            success: function (response) {
                if(response == ""){
                    $('#batch_id'+rowNo).html('<option value="">No Data Found</option>');
                }else{
                    for(var i =0;i < response.length;i++){
                        options += '<option value="'+response[i].id+'">'+response[i].batch_number+'</option>';
                    }
                    $('#batch_id'+rowNo).html(options);
                }
            }
        });
    }
    function batchInfo(rowNo){
        var id = $('#batch_id'+rowNo).val();
        var options = '<option value="">Select Batch Number</option>';
        $.ajax({
            type: "GET",
            url: "{{url('batch/')}}/"+id,
            data: "data",
            dataType: "json",
            success: function (response) {
                $('#expeire_date'+rowNo).val(response.expiry_date);
                $('#current_stock'+rowNo).val(response.in_stock);
                $('#unit_price'+rowNo).val(response.mrp);
                calculate(rowNo,1,response.mrp,0);
            }
        });
    }

    $('#newcustomer').click(function(){
        $('#new_customer').toggle('slow',function(){
            if ($(this).is(":visible")) {
                $('#newcustomer').html('<i class="mdi mdi-minus-box text-danger"></i>')
                $('#customer_id').attr("disabled","disabled");
                $('#customer_id').html("<option value='new'>New Customer</option>");
                $('#customer_name').attr("required","required");
                $('#customer_address').attr("required","required");
                $('#customer_phone').attr("required","required");
            } else {
                $('#newcustomer').html('<i class="mdi mdi-plus-box text-success"></i>')
                $('#customer_id').removeAttr("disabled");
                $('#customer_id').html("<?php echo Pharma::GetOptions($customers,'patient_name',1)?>");
                $('#customer_name').removeAttr("required");
                $('#customer_address').removeAttr("required");
                $('#customer_phone').removeAttr("required");
            }
        });
    });

</script>

<script src="{{ asset('js') }}/sale.js"></script>
@endpush