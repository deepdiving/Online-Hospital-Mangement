<script>

    $('#appointment_id').change(function(e){
        var id = $(this).find(":selected").attr("data-patient");

        $.ajax({
            type: "GET",
            url: "{{url('prescription/patient')}}/"+id,
            data: "data",
            dataType: "json",
            success: function (response) {
                $('#patient_name').val(response.patient_name);
                $('#patient_age').val(response.age);
                $('#patient_id').val(response.id);
                $('#prescription_patient_id').text('#'+response.slug);
                $('#prescription_patient').text(response.patient_name);
                $('#prescription_patient_age').text(response.age+' Years');
                $('#prescription_patient_mob').text(response.phone);
                swal("Patient Find Success", {icon: "success",buttons: false,timer: 1000});
            }
        }); 
    });

    function addTest(id,name){
        var row = `<tr id="testId${id}"><td>${name}</td><td class="text-danger" onclick='testRemove(${id})'> <input type='hidden' name='tests[]' value='${name}'><input type='hidden' name='testsId[]' value='${id}'>X</td></tr>`;
        $('#prescriptionTest').append(row);
        swal("Medicine Addes", {icon: "success",buttons: false,timer: 1000});
    }

    function testRemove(id){
        $('#testId'+id).remove();
    }
    function medicineRemove(id){
        $('#medicineId'+id).remove();
    }

    function clearMedicine(){
        $('#searchMedicine').val('');
        $('#name').val(0);
        searchMedicineTypeWise(0);
    }
    function newMedicine(){
        var medicine = $('#searchMedicine').val();
        var type = parseFloat($('#name').val())||0;
        if(medicine != '' &&  type != ''){
            $.ajax({
                type: "GET",
                url: "{{url('prescription/new-medicine')}}/"+type+"/"+medicine,
                data: "data",
                dataType: "json",
                success: function (response) {
                    $('#presctibeItems').append(response.prescriptionRow);
                    $('#listBodymedicine').append(response.medicineList);
                    $('#searchMedicine').val('');
                    $('#name').val(0);
                    serialPOPup();
                    swal("Medicine Addes", {icon: "success",buttons: false,timer: 1000});
                }
            });
        }else{
            swal("Medicine Name & Type Not be empty!", {icon: "error",buttons: false,timer: 1500});
        }
    }

    function addToPrescriptioin(id){
        $.ajax({
            type: "GET",
            url: "{{url('prescription/medicine')}}/"+id,
            data: "data",
            dataType: "text",
            success: function (response) {
                $('#presctibeItems').append(response);
                serialPOPup();
                swal("Medicine Addes", {icon: "success",buttons: false,timer: 1000});
                $('#searchMedicine').val('');
                $('#name').val(0);
                searchMedicineTypeWise(0);
            }
        });
    }


    function serialPOPup(){
        var i = 1;
        $(".sl").each(function(){
            $(this).text(i);
            i = i+1;
        });
    }

    function searchCategoriesWise(id){
        $.ajax({
            type: "GET",
            url: "{{url('medicine-test-sarch')}}/"+id,
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

    function searchMedicineTypeWise(id){
        $.ajax({
            type: "GET",
            url: "{{url('medicine-category-sarch')}}/"+id,
            data: "data",
            dataType: "text",
            success: function (response) {
                $('#listBodymedicine').html(response);
            }
        }); 
    } 

    $('#name').change(function(){ 
        searchMedicineTypeWise($(this).val());
    });

    $('#searchMedicine').keyup(function(){  
        search_medicin_table($(this).val());  
    });  
    function search_medicin_table(value){  
        $('#example24 tr').each(function(){  
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