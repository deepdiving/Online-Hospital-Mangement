@extends('layout.app',['pageTitle' => 'Appointment'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Appointment List
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-12">
                    <form action="" method="get" class="form-inline float-right search">
                        <div class="form-group">
                            <label for="text">{{ __('messages.date_to')}}</label>
                            <input type="text" id="date" name="date" value="{{$search['date']}}" class="form-control datepickerDB">
                        </div>
                        <div class="form-group">
                            <label for="text">Doctor</label>
                            <select name="doctor" id="doctor" class="form-control">
                                <option value="">Select Doctor</option>
                                @foreach ($doctors as $row)
                                    <option value="{{ $row->id}}">{{ $row->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="text">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="Requested" {{($search['status'] == 'Requested')?'Selected':''}}>Requested</option>
                                <option value="Confirmed" {{($search['status'] == 'Confirmed')?'Selected':''}}>Confirmed</option>
                                <option value="Paid" {{($search['status']      == 'Paid')?'Selected':''}}>Paid</option> 
                            </select>
                        </div>
                        <div class="form-group">
                            <a href="{{url('appointment-list')}}" class="btn btn-success ml-2">Clear</a>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
</div>
<div class="col-lg-12 col-md-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title d-inline">Appointment List</h4><br>
            <h6 class="card-subtitle d-inline">{{__('messages.see_all')}} appointment</h6>

            <a class="btn float-right bg-theme text-light" href="{{url('appointment')}}">New Appointment</a>

            <hr class="hr-borderd">

            <div class="col-lg-12">
                <div class="Content">
                    <table class="table table-bordered table-hover Content" id="myTable">
                        <thead>
                            <tr class="themeThead">
                                <th width="50">{{__('messages.sl')}}</th>
                                <th>#patient</th>
                                <th>Date</th>
                                <th>Consultant</th>
                                <th>Time Slot</th>
                                <th>Day</th>
                                <th>Fees</th>
                                <th class="text-left">Status</th>
                                <th width="100">{{__('messages.action')}}</th>
                            </tr>
                        </thead>

                         <tbody>
                            <?php $i = 0;?>
                            @foreach($appointmentList as $row)
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>
                                    <td><a href="{{url('appointment/'.$row->id)}}">{{ $row->patient->patient_name }}</a></td> 
                                    <td>{{  Pharma::dateFormat($row->date) }}
                                    <td>{{ $row->doctor->full_name }}</td>
                                    <td>{{ date('h:ia', strtotime($row->start_time))}} - {{  date('h:ia', strtotime($row->end_time))}}</td>
                                    <td>{{ $row->docschedule->week_day }}</td>
                                    <td>{{ Pharma::amountFormatWithCurrency($row->net_fees) }}</td>
                                    <td class="text-left"><span class="badge {{ $row->status == 'Paid' ? 'bg-info': 'bg-primary' }}">{{ $row->status }}</span></td>

                                    <td style="display: flex; justify-content: space-evenly;">

                                        {{-- <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('schedule/'.$row->id.'/edit') }}"><i class="fa fa-edit"></i></a> --}}
                                        {{-- <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('appointed/'.$row->id) }}"><i class="fa fa-eye"></i></a> --}}

                                        <form action="{{ url('appointment/'.$row->id) }}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
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
@include('elements.dataTableOne')
@endsection
@push('js')
<script>
    $('#date, #doctor, #status').change(function(){
        var date    = $('#date').val();
        var doctor  = $('#doctor').val();
        var status  = $('#status').val();
        window.location.href = "{{url('appointment-list')}}?date="+date+"&doctor="+doctor+"&status="+status;
    });
</script>
@endpush