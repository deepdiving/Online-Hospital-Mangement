@extends('layout.app',['pageTitle' => 'Appointment Schedule'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Appointment Schedule
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">New Schedule</h4>
                <hr class="hr-borderd">
                <form class="form-material m-t-30 form" action="{{ route('schedule.store') }}" method="post">
                    @csrf
                    
                    <div class="row">

                        <div class="form-group col-md-12 {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name">Schedule Name <sup class="text-danger font-bold">*</sup> :</label>
                            <input type="text" name="name" value="{{old('name',$schedule_name)}}" class="form-control" id="name" placeholder="name" required autocomplete="off">
                            @include('elements.feedback',['field' => 'name'])
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

                        <div class="form-group col-md-12 {{ $errors->has('week_day') ? ' has-danger' : '' }}">
                            <label for="week_day">Week Day <sup class="text-danger font-bold">*</sup> :</label>
                            <select name="week_day" class="form-control" id="week_day" required autocomplete="off">
                                {!!Pharma::getOptionArray(['Sunday'=>'Sunday','Monday'=>'Monday','Tuesday'=>'Tuesday','Wednesday'=>'Wednesday','Thursday'=>'Thursday','Friday'=>'Friday','Saturday'=>'Saturday'])!!}
                            </select>
                            @include('elements.feedback',['field' => 'week_day'])
                        </div>

                        <div class="form-group col-md-6 {{ $errors->has('start_time') ? ' has-danger' : '' }}">
                            <label for="start_time">Start Time <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                <input type="text" name="start_time" required class="form-control" value="10:00"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                            </div>
                        </div>

                        <div class="form-group col-md-6 {{ $errors->has('start_time') ? ' has-danger' : '' }}">
                            <label for="end_time">End Time <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                <input type="text" name="end_time" required class="form-control" value="12:00"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                            </div>
                        </div>

                        <div class="form-group col-md-6 {{ $errors->has('consultant_fees') ? ' has-danger' : '' }}">
                            <label for="consultant_fees">Consultant Fees <sup class="text-danger font-bold">*</sup> :</label>
                            <input type="number" name="consultant_fees" value="{{old('consultant_fees')}}" class="form-control" id="consultant_fees" placeholder="Consultant Fees" required autocomplete="off">
                            @include('elements.feedback',['field' => 'consultant_fees'])
                        </div>

                        <div class="form-group col-md-6 {{ $errors->has('visit_qty') ? ' has-danger' : '' }}">
                            <label for="visit_qty"># of Visit <sup class="text-danger font-bold">*</sup> :</label>
                            <input type="number" name="visit_qty" value="{{old('visit_qty',20)}}" class="form-control" id="visit_qty" placeholder="Number of Patient to be visited" required autocomplete="off">
                            @include('elements.feedback',['field' => 'visit_qty'])
                        </div>

                        <div class="form-group m-b-0 col-md-12 text-right">
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline">Schedules</h4>
                    <hr class="hr-borderd">
                    <div class="col-lg-12">
                        <div class="Content">
                            <table class="table table-bordered table-hover Content" id="dataTableNoPagingDesc">
                                <thead>
                                    <tr class="">
                                        <th width="50">{{__('messages.sl')}}</th>
                                        <th>Schedule Name</th>
                                        <th>Consultant</th>
                                        <th width="190">Time Slot</th>
                                        <th>Day</th>
                                        <th>Fees</th>
                                        <th class="text-center">#patient</th>
                                        <th width="80">{{__('messages.action')}}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i = 0;?>
                                @foreach($schedules as $row)
                                    <tr>
                                        <td>{{sprintf('%02d',++$i)}}</td>
                                        <td>{{ $row->name }}</td> 
                                        <td>{{ $row->doctor->full_name }}</td> 
                                        <td>{{ date('h:ia', strtotime($row->start_time))}} - {{  date('h:ia', strtotime($row->end_time))}}</td> 
                                        <td>{{ $row->week_day }}</td>
                                        <td>{{ Pharma::amountFormatWithCurrency($row->doctor_fees) }}</td>
                                        <td class="text-center">{{ $row->visit_qty }}</td>
                                        
                                        <td style="display: flex; justify-content: space-evenly;">
                                        
                                            <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('schedule/'.$row->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                        
                                            <form action="{{ url('schedule/'.$row->id) }}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$row->id}})"><i class="fa fa-trash-o"></i></button>
                                            </form> 
                                        </td> 
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