@extends('layout.app',['pageTitle' => 'Appointment Schedule'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Appointment Schedule
@endslot
@endcomponent
@include('elements.alert')
<button class="btn btn-success m-t-40 buttonstyle" onclick="invoiceprint()">Print</button> </br></br>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
              <div id="printArea">
                <table class="table table-bordered Content">
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

                            <td class="font-weight-bold bg-muted">{{$doctor->full_name}} <br> <small>{{$doctor->designation}}</small></td>
                            @php $days = Pharma::getScheduleDayWise($doctor->id) @endphp
                            {!!Pharma::scheduleChart('Sunday',$days,$doctor)!!}
                            {!!Pharma::scheduleChart('Monday',$days,$doctor)!!}
                            {!!Pharma::scheduleChart('Tuesday',$days,$doctor)!!}
                            {!!Pharma::scheduleChart('Wednesday',$days,$doctor)!!}
                            {!!Pharma::scheduleChart('Thursday',$days,$doctor)!!}
                            {!!Pharma::scheduleChart('Friday',$days,$doctor)!!}
                            {!!Pharma::scheduleChart('Saturday',$days,$doctor)!!}
                        </tr>
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
    .schedule{
        border-radius: 3px;
        padding: 5px;
        margin-bottom: 5px;
        background: #ddd;
        cursor: pointer;
    }
    /* .event{
        background: #ddd;
    } */

    /* .schedule:hover,.s-name{
        background: #ddd;
        color: #fff;
    } */
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
