@extends('layout.app',['pageTitle' =>'Appointment Schedule'])
@section('content')

@include('elements.alert')

<div class="row p-t-30">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Appointment Schedule</h4>
                    <hr class="hr-borderd">
                    <form class="form-material m-t-10 form" action="{{ route('schedule.update',$schedule) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group col-md-12 {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name">Schedule Name <sup class="text-danger font-bold">*</sup> :</label>
                            <input type="text" name="name" value="{{old('name',$schedule->name)}}" class="form-control" id="name" placeholder="name" required autocomplete="off">
                            @include('elements.feedback',['field' => 'name'])
                        </div>

                        <div class="form-group col-md-12 {{ $errors->has('doctor_id') ? ' has-danger' : '' }}">
                            <label for="doctor_id">Doctor <sup class="text-danger font-bold">*</sup> :</label>
                            <select name="doctor_id" class="form-control" id="doctor_id" required autocomplete="off">
                                <option value="" selected disabled>Select Doctor</option>
                                @foreach ($doctors as $row)
                                    <option value="{{ $row->id}}"@if($row->id==$schedule->doctor_id) selected @endif>{{ $row->full_name }}</option>
                                @endforeach   
                            </select>
                            @include('elements.feedback',['field' => 'doctor_id']) 
                        </div>

                        <div class="form-group col-md-12 {{ $errors->has('week_day') ? ' has-danger' : '' }}">
                            <label for="week_day">Week Day <sup class="text-danger font-bold">*</sup> :</label>
                            <select name="week_day" class="form-control" id="week_day" required autocomplete="off">
                                <option value="" selected disabled>Week Day (required)</option>
                                <?php echo Pharma::getOptionArray(['Sunday'=>'Sunday','Monday'=>'Monday','Tuesday'=>'Tuesday','Wednesday'=>'Wednesday','Thursday'=>'Thursday','Friday'=>'Friday','Saturday'=>'Saturday'],old('week_day',$schedule->week_day)) ?> 
                            </select>
                            @include('elements.feedback',['field' => 'week_day']) 
                        </div> 
                        
                        <div class="form-group col-md-6 {{ $errors->has('start_time') ? ' has-danger' : '' }} d-inline-block">
                            <label for="start_time">Start Time <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                <input type="text" name="start_time" required class="form-control" value="{{old('name',$schedule->start_time)}}"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                            </div>
                        </div>

                        <div class="form-group col-md-6 {{ $errors->has('start_time') ? ' has-danger' : '' }} float-right">
                            <label for="end_time">End Time <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                <input type="text" name="end_time" required class="form-control" value="{{old('name',$schedule->end_time)}}"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                            </div>
                        </div>

                        <div class="form-group col-md-6 {{ $errors->has('consultant_fees') ? ' has-danger' : '' }} d-inline-block">
                            <label for="consultant_fees">Consultant Fees <sup class="text-danger font-bold">*</sup> :</label>
                            <input type="number" name="consultant_fees" value="{{old('consultant_fees',$schedule->doctor_fees)}}" class="form-control" id="consultant_fees" placeholder="Consultant Fees" required autocomplete="off">
                            @include('elements.feedback',['field' => 'consultant_fees'])
                        </div>

                        <div class="form-group col-md-6 {{ $errors->has('visit_qty') ? ' has-danger' : '' }} float-right">
                            <label for="visit_qty"># of Visit <sup class="text-danger font-bold">*</sup> :</label>
                            <input type="number" name="visit_qty" value="{{old('visit_qty',20,$schedule->visit_qty)}}" class="form-control" id="visit_qty" placeholder="Number of Patient to be visited" required autocomplete="off">
                            @include('elements.feedback',['field' => 'visit_qty'])
                        </div>

                        <div class="form-group m-b-0 float-right"> 
                            <a href="{{url('/schedule/')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

</div>
@include('elements.dataTableOne')
@endsection

@push('css')
<link href="{{ asset('material') }}/assets/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
@endpush

@push('js')
<script src="{{ asset('material') }}/assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>
<script src="{{ asset('js') }}/sweetalert.min.js"></script>
<script>
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
</script>
@endpush