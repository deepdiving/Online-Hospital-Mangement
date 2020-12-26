@extends('layout.app',['pageTitle' => 'Appointment Schedule'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Appointment Schedule
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover Content">
                    <thead>
                        <tr class="tableHead">
                            <th width="23%">Consultant Name</th>
                            <th width="11%">Sunday</th>
                            <th width="11%">Monday</th>
                            <th width="11%">Tuesday</th>
                            <th width="11%">Wednesday</th>
                            <th width="11%">Thursday</th>
                            <th width="11%">Friday</th>
                            <th width="11%">Saturday</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $doctor)
                        <tr>
                            <td>{{$doctor->full_name}} <br> <small>{{$doctor->designation}}</small></td>
                            <td class="event">
                                <div>{{$doctor->schedule->name}}</div>
                                <small>{{$doctor->schedule->start_time}}-{{$doctor->schedule->end_time}}</small>
                                <div class="event-subtitle">#P:{{$doctor->schedule->visit_qty}}</div>
                            </td>
                            <td></td>
                            <td></td>
                            <td class="event">
                                <div>Morning Schedule</div>
                                <small>9.00pm - 10.00pm</small>
                                <div class="event-subtitle">#p: 20</div>
                            </td>
                            <td></td>
                            <td class="event">
                                <div>Morning Schedule</div>
                                <small>9.00pm - 10.00pm</small>
                                <div class="event-subtitle">#p: 20</div>
                            </td>
                            <td></td>
                        </tr>
                        @endforeach
                        @foreach ($schedule as $date)
                     <p> {{ $date .'->'. isset($date->schedule[$date]) ? $date->schedule[$date] : 0; }}</p>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('css')
<style>
    .event{
        background: #ddd;
    }

    .event:hover{
        background: red;
        color: #fff;
    }
</style>
@endpush

@push('js')
<script src='{{ asset('js') }}/print.js'></script>
<script>
    function invoiceprint(){
        $("#printArea").print();
    }
</script>
@endpush
