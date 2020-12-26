@extends('layout.app',['pageTitle' => 'Appointment Schedule','noFooter' => 'true'])
@section('content')

@include('elements.alert')
<div class="row p-t-30">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                {{-- <h4 class="card-title">New Appointment</h4>
                <hr class="hr-borderd"> --}}
                <form class="form-material form" action="{{ route('appointment.store') }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="form-group col-md-8{{ $errors->has('date') ? ' has-danger' : '' }}">
                            <label for="date">Date <sup class="text-danger font-bold">*</sup> :</label>
                            <input type="text" name="date" value="{{old('date',date('Y-m-d'))}}" class="form-control datepickerDB" id="date" placeholder="Appointment Date" required autocomplete="off"> 
                            @include('elements.feedback',['field' => 'date'])
                        </div>

                        <div class="form-group col-md-4 {{ $errors->has('serial') ? ' has-danger' : '' }}">
                            <label for="serial">Serial<sup class="text-danger font-bold">*</sup> :</label>
                            <input type="number" name="serial" readonly value="{{old('serial')}}" class="form-control" id="serial" placeholder="Serial Number" required autocomplete="off">
                            @include('elements.feedback',['field' => 'serial'])
                        </div>


                        <div class="form-group col-md-12 {{ $errors->has('doctor_id') ? ' has-danger' : '' }}">
                            <label for="doctor_id">Doctor <sup class="text-danger font-bold">*</sup> :</label>
                            <select name="doctor_id" class="form-control" id="doctor_id" required autocomplete="off">
                                <option value="" selected disabled>Select Doctor</option>
                                @foreach ($doctors as $row)
                                    <option value="{{ $row->id}}">{{ $row->full_name }}</option>
                                @endforeach
                            </select>
                            @include('elements.feedback',['field' => 'doctor_id'])
                        </div>
                        </div>
                        <div class="row inactive" id="nextarea">
                            <div class="form-group col-md-6 mb-0 {{ $errors->has('time_slot') ? ' has-danger' : '' }}">
                                {{-- <label for="time_slot">Select Time Slot <sup class="text-danger font-bold">*</sup> :</label> --}}
                                <div class="demo-radio-button" id="timeSlot">
                                </div>
                            </div>


                            <div class="form-group col-md-12 {{ $errors->has('patient_id') ? ' has-danger' : '' }}">
                                <label for="patient_id">Patient <sup class="text-danger font-bold">*</sup> :</label>
                                <div class="input-group" data-placement="bottom" data-align="top" data-autoclose="true">
                                    <select name="patient_id" class="form-control js-example-basic-single" id="patient_id" required autocomplete="off">
                                        <option value="" selected disabled>Select Paitent</option>
                                        @foreach ($patients as $row)
                                            <option value="{{ $row->id}}">{{ $row->patient_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-addon" data-toggle="modal" data-target=".new-patient"> <span class="fa fa-plus"></span> </span>
                                </div>
                                @include('elements.feedback',['field' => 'patient_id'])
                            </div>

                            <div class="form-group col-md-7 {{ $errors->has('consultant_fees') ? ' has-danger' : '' }}">
                                <label for="consultant_fees">Consultant Fees <sup class="text-danger font-bold">*</sup> :</label>
                                <input type="number" name="consultant_fees" readonly value="{{old('consultant_fees')}}" class="form-control" id="consultant_fees" placeholder="Consultant Fees" required autocomplete="off">
                                @include('elements.feedback',['field' => 'consultant_fees'])
                            </div>
                            <div class="form-group col-md-5 {{ $errors->has('discount') ? ' has-danger' : '' }}">
                                <label for="discount">Discount<sup class="text-danger font-bold">*</sup> :</label>
                                <input type="number" name="discount" value="{{old('discount',0)}}" class="form-control" id="discount" placeholder="Consultant Fees"  autocomplete="off">
                                @include('elements.feedback',['field' => 'discount'])
                            </div>
                            <div class="form-group col-md-7 {{ $errors->has('net_fees') ? ' has-danger' : '' }}">
                                <label for="net_fees">Net Fees <sup class="text-danger font-bold">*</sup> :</label>
                                <input type="number" name="net_fees" readonly value="{{old('net_fees')}}" class="form-control" id="net_fees" placeholder="Consultant Fees" required autocomplete="off">
                                @include('elements.feedback',['field' => 'net_fees'])
                            </div>
                            <div class="form-group col-md-5 {{ $errors->has('received_payment') ? ' has-danger' : '' }}">
                                <label for="received_payment">Payment Status <sup class="text-danger font-bold">*</sup> :</label>
                                <input type="checkbox" id="md_checkbox_22" value="1" name="received_payment" class="filled-in chk-col-pink" >
                                <label for="md_checkbox_22">Received Fees</label>
                            </div>
                            <div class="form-group col-md-12 {{ $errors->has('remark') ? ' has-danger' : '' }}">
                                <label for="remark">Remark <sup class="text-danger font-bold">*</sup> :</label>
                                <textarea name="remark" id="" class="form-control" rows="3" placeholder="Short Note.."></textarea>
                                @include('elements.feedback',['field' => 'consultant_fees'])
                            </div>

                            <div class="form-group m-b-0 col-md-12 text-right">
                                <button type="submit" class="btn bg-theme text-white">Make Appoint</button>
                            </div>

                        </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form class="form-material" action="{{ route('appoint-payment') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12 {{ $errors->has('payment_appoint_id') ? ' has-danger' : '' }}">
                            <label for="payment_appoint_id">Patient <sup class="text-danger font-bold">*</sup> :</label>
                                <select name="payment_appoint_id" class="form-control js-example-basic-single" id="payment_appoint_id" autocomplete="off">
                                    <option value="" selected disabled>Select Paitent</option>
                                    @foreach ($confirmdAppoints as $row)
                                    <option value="{{ $row->id}}">#{{ $row->invoice }} {{$row->patient->patient_name}} -- {{ $row->date }}</option>
                                    @endforeach
                                </select>
                            @include('elements.feedback',['field' => 'payment_appoint_id'])
                        </div>
                        <div class="form-group col-md-4{{ $errors->has('payment_amount') ? ' has-danger' : '' }}">
                            <label for="payment_amount">Amount <sup class="text-danger font-bold">*</sup> :</label>
                            <input type="text" name="payment_amount" value="{{old('payment_amount',0)}}" readonly class="form-control" id="payment_amount" placeholder="Appointment amount" required autocomplete="off">
                            @include('elements.feedback',['field' => 'payment_amount'])
                        </div>
                        <div class="form-group col-md-4{{ $errors->has('payment_discount') ? ' has-danger' : '' }}">
                            <label for="payment_discount">Discount <sup class="text-danger font-bold">*</sup> :</label>
                            <input type="text" name="payment_discount" value="{{old('payment_discount',0)}}" class="form-control" id="payment_discount" placeholder="Appointment discount"  autocomplete="off">
                            @include('elements.feedback',['field' => 'payment_discount'])
                        </div>
                        <div class="form-group col-md-4{{ $errors->has('payment_net_fees') ? ' has-danger' : '' }}">
                            <label for="payment_net_fees">Net Fees <sup class="text-danger font-bold">*</sup> :</label>
                            <input type="text" name="payment_net_fees" value="{{old('payment_net_fees',0)}}" readonly class="form-control" id="payment_net_fees" placeholder="Appointment Net Fees" required autocomplete="off">
                            @include('elements.feedback',['field' => 'payment_net_fees'])
                        </div>

                        <div class="form-group m-b-0 col-md-12 text-right">
                            <button type="submit" class="btn bg-theme text-white">Make Payment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade new-patient" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form id="patientId" role="form" action="" class="form-material form" method="post">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">New Patient Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <input type="text" name="patient_name" id="patient_name" class="form-control form-control-line" placeholder="{{__('messages.patient_name')}} (required)" required autocomplete="off" value="{{old('patient_name')}}">
                            @include('elements.feedback',['field' => 'patient_name'])
                        </div>
                        <div class="form-group col-md-6">
                            <input type="number" name="phone" value="{{old('phone')}}" maxlength="11" minlength="11" class="form-control  form-control-line" id="phone" placeholder="{{__('messages.phone_number')}} (required)" required autocomplete="off">
                            @include('elements.feedback',['field' => 'phone'])
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" name="address" value="{{old('address')}}" class="form-control  form-control-line" id="address" placeholder="{{__('messages.address')}} (required)" required autocomplete="off">
                            @include('elements.feedback',['field' => 'address'])
                        </div>
                        <div class="form-group col-md-6">
                            <input type="number" name="age" maxlength="2" value="{{old('age')}}" class="form-control  form-control-line" id="age" placeholder="{{__('messages.age')}} (required)" required autocomplete="off">
                            @include('elements.feedback',['field' => 'age'])
                        </div>
                        <div class="form-group col-md-6">
                            <input type="email" name="email" value="{{old('email')}}" class="form-control form-control-line" id="email" placeholder="{{__('messages.email')}}" autocomplete="off">
                            @include('elements.feedback',['field' => 'email'])
                        </div>
                        <div class="form-group col-md-6">
                            <select class="form-control" required name="blood_group">
                                <?php echo Pharma::getOptionArray(['A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','O+'=>'O+','O-'=>'O-','AB+'=>'AB+','AB-'=>'AB-'],old('blood_group'))?>
                            </select>
                            @include('elements.feedback',['field' => 'blood_group'])
                        </div>
                        <div class="form-group col-md-6">
                            <select class="form-control"  name="occupation">
                                <?php echo Pharma::getOptionArray(['Business'=>'Business','Professional'=>'Professional','Student'=>'Student','House Wife'=>'House Wife','Labourers'=>'Labourers','Other'=>'Other'],old('occupation'))?>
                            </select>
                            @include('elements.feedback',['field' => 'occupation'])
                        </div>
                        <div class="form-group col-md-6">
                            <select class="form-control" required name="religion">
                                <?php echo Pharma::getOptionArray(['Islam'=>'Islam','Hindu'=>'Hindu','Buddha'=>'Buddha','Christian'=>'Christian','Other'=>'Other'],old('religion'))?>
                            </select>
                            @include('elements.feedback',['field' => 'religion'])
                        </div>
                        <div class="form-group col-md-12">
                            <textarea name="description" class="form-control" rows="9" placeholder="{{__('messages.write_a_note')}}"></textarea>
                        </div>

                        <div class="form-group col-md-12 row">
                            <label for="description" class="col-sm-3 control-label col-form-label">{{__('messages.gender')}} :</label>
                            <div class="col-sm-9">
                                <input name="gender" value="Male" type="radio" class="with-gap" id="Male">
                                <label for="Male">{{__('messages.male')}}</label>
                                <input name="gender" value="Female" type="radio" id="Female" class="with-gap" checked>
                                <label for="Female">{{__('messages.female')}}</label>
                                <input name="gender" value="Other" type="radio" id="Other" class="with-gap">
                                <label for="Other">{{trans_choice('messages.other',1)}}</label>
                            </div>
                        </div>
                        <div class="form-group col-md-12 row">
                            <label for="description" class="col-sm-3 control-label col-form-label">{{__('messages.marital_status')}} :</label>
                            <div class="col-sm-9">
                                <input name="marital_status" value="Married" type="radio" class="with-gap" id="Married" checked>
                                <label for="Married">{{__('messages.married')}}</label>
                                <input name="marital_status" value="Single" type="radio" id="Single" class="with-gap">
                                <label for="Single">{{__('messages.single')}}</label>
                            </div>
                        </div>
                    </div>
                    <h3 class="form-title text-themecolor"><span>{{__('messages.guardian_information')}}</span></h3>
                    <div class="row m-t-30">
                        <div class="form-group col-md-4">
                            <input type="text" name="guardian" id="patient" class="form-control form-control-line" placeholder="{{__('messages.guardian_name')}}" autocomplete="off" value="{{old('guardian')}}">
                            @include('elements.feedback',['field' => 'guardian'])
                        </div>
                        <div class="form-group col-md-4">
                            <input type="number" name="guardian_phone" value="{{old('guardian_phone')}}" maxlength="11" minlength="11" class="form-control  form-control-line" id="guardian_phone" placeholder="{{__('messages.guardian_phone')}}" autocomplete="off">
                            @include('elements.feedback',['field' => 'guardian_phone'])
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" name="relationship" value="{{old('relationship')}}" class="form-control form-control-line" id="relationship" placeholder="{{__('messages.guardian_rela')}}" autocomplete="off">
                            @include('elements.feedback',['field' => 'relationship'])
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span id="SavePatient" class="btn btn-danger waves-effect text-left">Save Patient</span>
                </div>
            </form>
        </div>
    </div>
</div>

{{--
<span class="input-group-addon" data-toggle="modal" data-target=".payment-invoice"> <span class="fa fa-plus"></span> </span>

 <div class="modal fade payment-invoice" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">New Patient Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row" id="printArea">
                        <div class="col-md-12 mt-3">
                            <div class="p-2" style="background:#ddd">
                                <h2 class="display-4 font-weight-bold">1 <small style="font-size: 40%;">#A0001</small></h2>
                                <h4>Hasan <small>#0002</small></h4><b>Feb 28, 2020<br>06:00 AM</b>
                                <span class='btn btn-primary float-right rounded-0 p-1' style='margin-right: -8px;margin-bottom: -8px;'>Paid</span>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span id="singleInvoicePrint" onclick="invoiceprint()" class="btn btn-danger waves-effect text-left">Print</span>
                </div>
        </div>
    </div>
</div> --}}

 <!-- BEGIN MODAL -->
 <div class="modal none-border" id="my-event">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong>Appointment List</strong></h4>
            </div>

            <div class="modal-body"  id="printArea" ></div>

            <div class="modal-footer">
                <span id="singleInvoicePrint" onclick="invoiceprint()" class="btn btn-danger waves-effect text-left">Print</span>
                <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@include('elements.dataTableOne')
@endsection
@push('css')
<link href="{{ asset('material') }}/assets/plugins/calendar/dist/fullcalendar.css" rel="stylesheet" />
<link href="{{ asset('material') }}/css/select2.min.css" rel="stylesheet" />

	<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->


<style>
    span.select2.select2-container.select2-container--default{
        width: 100% !important;
    }
    .inactive{
        opacity: .8;
        pointer-events: none;
    }
    .red{
        background: #ff0000 !important;
    }
</style>
<style>

    @media print {
        @page {
            size: a4;
        }
        .row{
            width: 100%;
        }
        .col-md-4{
            width: 33% !important;
        }
    }
    tbody.borderhade tr {
        border-top: 2px dashed #d4d2d2;
    }
    .borderdobul{
        border-top: double;
        margin-top: -15px !important;
    }
    .b-r{
        border-right: 2px dashed #ddd !important;
    }
    .table td{
        padding: 0px !important;
    }
    .m-l{
        margin-left:160px;
    }
    </style>
@endpush

@push('js')

{{-- //Calendar Script --}}
<script src="{{ asset('material') }}/assets/plugins/calendar/jquery-ui.min.js"></script>
<script src="{{ asset('material') }}/assets/plugins/moment/moment.js"></script>
<script src="{{ asset('material') }}/assets/plugins/calendar/dist/fullcalendar.min.js"></script>
{{-- <script src="{{ asset('material') }}/js/cal.js"></script> --}}
@include('elements.appointment-calendar');

//dataepicker
<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
//


<script src="{{ asset('js') }}/sweetalert.min.js"></script>
<script src="{{ asset('material') }}/js/select2.min.js"></script>
<script>
    $('.js-example-basic-single').select2();

    $('#date').change(function(){
        const doctor = parseFloat($('#doctor_id').val())||0;
        if(doctor > 0){
            getTimeSlot($(this).val(),doctor);
        }
    });

    $('#doctor_id').change(function(){
        const date = $('#date').val();
        console.log('asdf');
        if(date != ''){
            console.log(date);
            getTimeSlot(date,$(this).val());
        }
    });

    function getTimeSlot(date,doctor){
        $.ajax({
            type: "GET",
            url: "{{url('appointment/get-time-slot')}}/"+date+"/"+doctor,
            data: "data",
            dataType: "json",
            beforeSend: function(){},
            success: function (response) {
                if(response.status === "OK"){
                    $('#timeSlot').html(response.html);
                    const scheduleId = parseFloat($("input[type='radio'][name='time_slot']:checked").val())||0;
                    if( scheduleId > 0){
                        getSerialAndFees(scheduleId,date);
                        $('#nextarea').removeClass('inactive');
                    }else{
                        $('#consultant_fees').val('');
                        $('#serial').val('');
                        $('#serial').removeAttr('style');
                        $('#nextarea').addClass('inactive');
                    }
                }else{
                    $('#timeSlot').html('NO TIME SLOT FOUND');
                }
            }
        });
    }

    function time_slot_change(scheduleId){
        const date = $('#date').val();
        getSerialAndFees(scheduleId,date);
    }

    function getSerialAndFees(scheduleId,date){
        $.ajax({
            type: "GET",
            url: "{{url('appointment/get-time-slot-data')}}/"+scheduleId+"/"+date,
            data: "data",
            dataType: "json",
            beforeSend: function(){},
            success: function (response) {
                console.log(response);
                $('#consultant_fees').val(response.fees);
                $('#net_fees').val(response.fees);
                $('#serial').val(response.serial);
                if(response.red === 'red'){
                    $('#serial').attr('style', 'background: #ff0000 !important');
                    $('#serial').css('font-weight','bold');
                }
            }
        });
    }

   $('#discount').on('change keyup',function(){
       const discount        = parseFloat($(this).val())||0;
       const consultant_fees = parseFloat($('#consultant_fees').val())||0;

       const net_fees = parseFloat(consultant_fees)-parseFloat(discount);
       if(discount>net_fees){
        $('#net_fees').val(0);
        $('#discount').val(0);
        alert('Discount Must Be Smaller Then Consultant Fees ');
        $('#net_fees').val(parseFloat(consultant_fees).toFixed(2));
       }else{
        $('#net_fees').val(parseFloat(net_fees).toFixed(2));
       }
    })


    $('#SavePatient').click(function(e){
        e.preventDefault();
        const name = $('#patient_name').val();
        const phone = $('#phone').val();
        const age = $('#age').val();
        const address = $('#address').val();

        if(name == '' || phone == '' || age == '' || address == ''){
            alert ('Required Filed Must be filled');
        }else{
            var formData = $("#patientId").serialize();
            $.ajax({
                type: 'POST',
                url:"{{ url('appointment-patient') }}",
                data: formData,
                dataType: "json",
                success: function(response){
                    var option = `<option value='${response.id}' selected>${response.patient_name}</option>`;
                    $('#patient_id').append(option);
                    $(".new-patient").modal("hide");
                    swal(response.patient_name+" Inserted as Patient!", {icon: "success",buttons: false,timer: 2000});
                    $('#patientId')[0].reset();
                }
            })
        }
    });

    $('#payment_appoint_id').change(function (){
        var id = parseFloat($(this).val())||0;
        $.ajax({
            type: "GET",
            url: "{{url('appointment/get-appointment')}}/"+id,
            data: "data",
            dataType: "json",
            beforeSend: function(){},
            success: function (response) {
                $('#payment_amount').val(response.data.doctor_fees);
                $('#payment_discount').val(response.data.discount);
                $('#payment_net_fees').val(parseFloat(parseFloat(response.data.doctor_fees)-parseFloat(response.data.discount)).toFixed(2));
            }
        });
    });

    $('#payment_discount').on('change keyup',function(){
        const payment_discount = parseFloat($(this).val())||0;
        const payment_amount  = parseFloat($('#payment_amount').val())||0;

        const payment_net_fees = parseFloat(payment_amount)-parseFloat(payment_discount);
        if(payment_discount>payment_net_fees){
        $('#payment_net_fees').val(0);
        $('#payment_discount').val(0);
        alert('Discount Must Be Smaller Then Consultant Fees ');
        $('#payment_net_fees').val(parseFloat(payment_amount).toFixed(2));
        }
        else{
        $('#payment_net_fees').val(parseFloat(payment_net_fees).toFixed(2));
        }
    })
//     $('.datepickerdischarge').datepicker({
//         startDate: '-{{3-1}}d',
//         format:"yyyy-mm-dd",
//         autoclose: true,
//         todayHighlight: true,
//   });

</script>


<script src='{{ asset('js') }}/print.js'></script>
<script>
    function invoiceprint(){
        $("#printArea").print({
            addGlobalStyles : true,
            // stylesheet : "{{ asset('css') }}/print.css",
            // rejectWindow : true,
            noPrintSelector : "#printSection,#footer",
            // iframe : false,
            append : null,
            prepend : "#footer"
        });
    }
</script>


<script>
  $( function() {
    $( "#shootdate" ).datepicker({
      minDate: 0
    });
  });
</script>
    }
</script>




@endpush 
