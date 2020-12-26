<script>

    $("input[name='patient_type']").change(function(){
        var p_type = $("input[name='patient_type']:checked").val();
        if(p_type === 'new_patient'){
            $('.find_user').slideUp();
            $('#user_area').removeClass('fade');
            $('#patient').removeAttr("disabled");
            $('#age').removeAttr("disabled");
            $('#blood_group').removeAttr("disabled");
            $('#phone').removeAttr("disabled");
            $('#address').removeAttr("disabled");

            $('#patient').val('');
            $('#age').val('');
            $('#blood_group').val('');
            $('#phone').val('');
            $('#address').val('');
            $('#patient_id').val('');
            $('#CheckoutModule').removeClass('noneState');
            
        }
        if(p_type === 'old_patient'){
            $('#patient').attr("disabled", "disabled");
            $('#age').attr("disabled", "disabled");
            $('#blood_group').attr("disabled", "disabled");
            $('#phone').attr("disabled", "disabled");
            $('#address').attr("disabled", "disabled");
            $('.find_user').slideDown();
            $('#user_area').addClass('fade');
            $('#CheckoutModule').addClass('noneState');
        }
    });

    $('#newRefaral').click(function(){
        $('#new_refaral').toggle('slow',function(){
            if ($(this).is(":visible")) {
                $('#newRefaral').html('<i class="mdi mdi-minus-box text-white"></i>')
                $('#ref_id').attr("disabled","disabled");
                $('#ref_id').html("<option value='new'>New Refaral</option>");
                $('#ref_name').attr("required","required");
                $('#ref_contact').attr("required","required");
            } else {
                $('#newRefaral').html('<i class="mdi mdi-plus-box text-white"></i>')
                $('#ref_id').removeAttr("disabled");
                $('#ref_id').html("<?php echo Pharma::GetOptions($refarences,'name',1)?>");
                $('#ref_name').removeAttr("required");
                $('#ref_contact').removeAttr("required");
            }
        });
    });


    $('#patient_id').on('keyup',function(){
        var id = $(this).val();
        if(id.length == 4){
            $.ajax({
                type: "GET",
                url: "{{url('diagnostic/find-patient')}}/"+id,
                data: "data",
                dataType: "json",
                beforeSend: function(){},
                success: function (response) {
                    if(response.status === "OK"){
                        swal("Patient Find Successfull!", {icon: "success",buttons: false,timer: 2000});
                        $('#patient').val(response.data.patient_name);
                        $('#age').val(parseFloat(response.data.age));
                        $('#blood_group').val(response.data.blood_group);
                        $('#phone').val(response.data.phone);
                        $('#address').val(response.data.address);
                        radioChecked('gender',response.data.gender);
                        radioChecked('marital_status',response.data.marital_status);
                        $('#CheckoutModule').removeClass('noneState');
                    }else{
                        $('#patient_id').val('');
                        swal("Sorry the Patient not found!", {icon: "error",buttons: false,timer: 2000});
                    }
                }
            });
        }
    });

    function incrementCount(id){
        $.ajax({
            type: "GET",
            url: "{{url('diagnostic/testcount/increment')}}/"+id,
            data: "data",
            dataType: "json",
        }); 
    }
    function decrementCount(id){
        $.ajax({
            type: "GET",
            url: "{{url('diagnostic/testcount/decrement')}}/"+id,
            data: "data",
            dataType: "json",
        }); 
    }

    function searchCategoriesWise(id){
        $.ajax({
            type: "GET",
            url: "{{url('diagnostic/bill/categori-sarch')}}/"+id,
            data: "data",
            dataType: "text",
            success: function (response) {
                $('#listBody').html(response);
            }
        }); 
    }



    $('#categories').change(function(){
        searchCategoriesWise($(this).val());
    });



    function searchServiceWise(id){
        $.ajax({
            type: "GET",
            url: "{{url('hospital/admission/service-search')}}/"+id,
            data: "data",
            dataType: "text",
            success: function (response) {
                $('#listBody').html(response);
            }
        }); 
    }



    $('#service_category_id').change(function(){
        searchServiceWise($(this).val());
    });




    function radioChecked(name,val) {
        document.querySelectorAll(`input[name="${name}"]`).forEach(data => data.checked = 'false');
        document.querySelector(`input[value="${val}"]`).checked = 'true';
    }

    function addToCart(rowId,name,price){
        var html;
        html +=`<tr width="30" id="CartRowId${rowId}">`;
        html +=`<td class="text-center sl"></td>`;
        html +=`<td>${name}</td>`;
        html +=`<td class="text-right unit_price">${price}.00</td>`;
        html +=`<td align="center"><span class="btn btn-warning" onClick="removeCart(${rowId})"><i class="mdi mdi-close-box-outline"></i></span>`;
        html +=`<input type="hiden" class="display_none" name="test_items[]" value="${rowId}">`;
        html +=`<input type="hiden" class="display_none" name="test_item_price[]" value="${price}">`;
        html +=`</td></tr>`;
        $('#cartBody').append(html);
        $('#rowId'+rowId).hide();
        CheckOutCalculation();
        serialPOPup();
        // incrementCount(rowId);
    }

    function removeCart(id){
        $('#CartRowId'+id).remove();
        $('#rowId'+id).show();
        CheckOutCalculation();
        serialPOPup();
        // decrementCount(id);
    }

    function serialPOPup(){
        var i = 1;
        $(".sl").each(function(){
            $(this).text(i);
            i = i+1;
        });
    }


function CheckOutCalculation(){
    var sub_total = 0;
    $(".unit_price").each(function(){
        sub_total = parseFloat(sub_total) + parseFloat($(this).text());
    });
    if(sub_total > 0){
        $('#finalCheckOUT').removeAttr("disabled");
    }
    $('#cartTotal').text('{{Pharma::getCurrency()}}'+parseFloat(sub_total).toFixed(2));
    $('#sub_total').val(parseFloat(sub_total).toFixed(2));
    var disPercent = $('#discountPercent').val();
    var disOverall = $('#discountOverall').val();
    calulation(sub_total,disPercent,disOverall);
    
}
$('#discountPercent').on('keyup',function(){
    var disPercent  =  parseFloat($(this).val())||0;
    var sub_total   = parseFloat($('#sub_total').val())||0;
    var disOverall  = $('#discountOverall').val();
    calulation(sub_total,disPercent,disOverall)
});
$('#discountOverall').on('keyup',function(){
    var disPercent = $('#discountPercent').val();
    var sub_total = $('#sub_total').val();
    var disOverall = parseFloat($(this).val())||0;
    calulation(sub_total,disPercent,disOverall)
});

$("#paidAmount").on('change keyup',function(){
    const paid_amount       = parseFloat($(this).val())||0;
    const grand_total         = parseFloat($('#grandTotal').val())||0;
    findDueandChange(grand_total,paid_amount);
});

function findDueandChange(grand_total,paid_amount){
    const due   = parseFloat(grand_total).toFixed(2) - parseFloat(paid_amount).toFixed(2);
    if(grand_total <= paid_amount){
        $('#due').val('0.00');
        $('#change').val(parseFloat(parseFloat(paid_amount)-parseFloat(grand_total)).toFixed(2));
        $('#change-field').show();
        $('#due-field').hide();
    }else{
        $('#change-field').hide();
        $('#due-field').show();
        $('#due').val(parseFloat(due).toFixed(2));
        $('#change').val('0.00');
    }
}


function calulation(sub_total,disPercent,disOverall){
    var percentAmount = parseFloat(sub_total) * parseFloat(disPercent) / 100;
    var totalDis = parseFloat(percentAmount)+parseFloat(disOverall);
    var grandTotal = parseFloat(sub_total)-parseFloat(totalDis);
    $('#percentAmount').val(parseFloat(percentAmount).toFixed(2));
    $('#TotalDiscount').val(parseFloat(totalDis).toFixed(2));
    $('#grandTotal').val(parseFloat(grandTotal).toFixed(2));

    const paidAmount         = parseFloat($('#paidAmount').val())||0;
    findDueandChange(grandTotal,paidAmount);
}



//table search
    $('#search').keyup(function(){  
        search_table($(this).val());  
    });  
    function search_table(value){  
        $('#example23 tr').each(function(){  
            var found = 'false';  
            $(this).each(function(){  
                if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0)  
                {  
                    found = 'true';  
                }  
            });  
            if(found == 'true')  
            {  
                $(this).show();  
            }  
            else  
            {  
                $(this).hide();  
            }  
        });  
    }  

</script>