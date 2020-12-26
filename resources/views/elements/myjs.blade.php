<script src="{{ asset('js') }}/sweetalert.min.js"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script>
    function newWindow(url) {
        window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=970,height=890");
    }
</script>
<script>
  $('.datepickerDB').datepicker({
      format:"yyyy-mm-dd",
      autoclose: true,
      todayHighlight: true,
  });
  $('.datepicker').datepicker({
      startDate: '-0d',
      format:"dd-mm-yyyy",
      autoclose: true,
      todayHighlight: true,
  });
  $('.datepickerNexDayOnly').datepicker({
      startDate: '-0d',
      format:"yyyy-mm-dd",
      autoclose: true,
      todayHighlight: true,
  });

  $('.datepickers').datepicker({
      format:"dd-mm-yyyy",
      autoclose: true,
      todayHighlight: true,
  });
  //https://bootstrap-datepicker.readthedocs.io/en/stable/index.html


$(document).ready(function(){
  // toastr.success('The process has been saved.', 'Success');
  $(".form").validate({
    rules: {
        field: {
            required: true,
            step: 10
        },
    }, highlight: function (element) {
        $(element).closest('.form-group').addClass('has-danger');
        // $(element).closest('.form-control').addClass('form-control-danger');
    },
    unhighlight: function (element) {
        $(element).closest('.form-group').removeClass('has-danger');
        // $(element).closest('.form-group').addClass('has-success');
    },
    errorElement: 'div',
    errorClass: 'form-control-feedback',
    errorPlacement: function (error, element) {
        if (element.parent('.input-group').length) {
            error.insertAfter(element.parent());
        } else {
            error.insertAfter(element);
        }
    }
  });
});

$('.updateNotification').click(function(){
  const id = $(this).data('id');
    $.ajax({
        type: "GET",
        url: "<?php echo url('notification/"+id+"/update')?>",
        success: function(data){
          console.log(data);
        }
      });
});

function sweetalertDelete(id) {
    event.preventDefault();
    swal({
      title: "Are you sure?",
      text: "To continue this action!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        swal("Your action has beed done! :)", {
          icon: "success",
          buttons: false,
          timer: 1000
        });
          $("#deleteButton"+id).submit();
      }
    });
}
//https://sweetalert2.github.io/

</script>
