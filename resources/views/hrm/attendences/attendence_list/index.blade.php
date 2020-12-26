@extends('layout.app',['pageTitle' => 'Employee Attendence List'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Employee Attendence List
@endslot
@endcomponent
<style>
    table#example23 tr td {
        vertical-align: middle !important;
        padding: 0px 5px !important;
        /* border-color: #00000073; */
    }
    </style>
{{-- @php dd($search) @endphp --}}
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title d-inline"></h4>
                    <form action="" method="get" class="form-material from" id="searchForm"  style="width:40%">
                        <div class="d-flex justify-content-between">
                            <select name="month" class="form-control m-1" id="month">
                                {!!Pharma::getOptionArray([
                                    '01' => 'January',
                                    '02' => 'February',
                                    '03' => 'March',
                                    '04' => 'April',
                                    '05' => 'May',
                                    '06' => 'June',
                                    '07' => 'July',
                                    '08' => 'August',
                                    '09' => 'September',
                                    '10' => 'October',
                                    '11' => 'November',
                                    '12' => 'December',
                                ],$search['month'])!!}
                                {{-- <input type="text" name="start" value="{{$search['month']}}" class="form-control datepickers"> --}}
                            </select>
                            <select name="year" class="form-control m-1" id="year">
                                {!!Pharma::getOptionArray([
                                    '2018' => '2018',
                                    '2019' => '2019',
                                    '2020' => '2020',
                                    '2021' => '2021',
                                    '2022' => '2022',
                                    '2023' => '2023',
                                    '2024' => '2024',
                                    '2025' => '2025',
                                ],$search['year'])!!}
                                {{-- <input type="text" name="end" value="{{$search['year']}}" class="form-control datepickers"> --}}
                            </select>
                        </div>                           
                    </form>
                </div>
                <br>
                <br>
                <div class="col-lg-12">
                    <div class="Content">
                        <div class="invoiceHead text-center">
                            <h2 class="font-weight-bold">Montly Attendance Report</h2>
                            <h3>{{date('F Y',strtotime($search['year'].'-'.$search['month'].'-01'))}}</h3>
                        </div>

                        <table class="table table-bordered" id="example23">
                            <thead>
                                <tr class="">
                                    <th width="50">{{__('messages.sl')}}</th>
                                    <th>Name</th>
                                    <th>Total Days <sup>[including holidays]</sup></th>
                                    <th>Total Hours</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $i = 0 @endphp 
                                @foreach($employees as $row)
                                    <tr>
                                        <td>{{sprintf('%02d',++$i)}}</td>
                                        <td>{{ $row->name }}</td>
                                        <td> <span class="font-weight-bold display-6">{{ Pharma::attendanceDayCount($row->id,$search['month'],$search['year']) }}</span> out of {{Pharma::monthDays($search['month'],$search['year'])}} days</td>
                                        <td><a href ="#"><span data-toggle="modal" data-target=".modalDetails{{$row->id}}" class="font-weight-bold">{{ Pharma::employeeAttendance($row->id,$search['month'],$search['year']) }} </span></a></td>
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
@foreach($employees as $row)
<div class="modal fade modalDetails{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none" >     
    <div class="modal-dialog modal-md">         
         <div class="modal-content">                                                            
            <div class="modal-header">                                              
                <button class="btn btn-success buttonstyle" onclick="invoiceprint({{$row->id}})">Print</button>                                              
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">    
                <div class="Content" id="printJS-form{{$row->id}}">  
                    <h4 class="modal-title" id="myLargeModalLabel">{{ $row->name }}</h4>          
                <table class="table table-borderd table-striped">
                 
                @php  
                    $days =  Pharma::attendanceDayCount($row->id,$search['month'],$search['year'],'data');
                @endphp

                @foreach($days as $att)

                    <tr>
                        <th colspan="3" class="text-right font-weight-bold">{{ $att->date }}</th>
                    </tr>
                    @php 
                        $i = 0;
                        $slots = DB::table('hrm_attendances')->where('emp_id',$row->id)->where('date',$att->date)->get();
                        // dd($slots);
                    @endphp
                    @foreach($slots as $a)
                            <tr>                        
                                <td>{{sprintf('%02d',++$i)}}</td>                                          
                                <td>{{$a->status}}</td>
                                <td>{{ date('h:i A', strtotime($a->time)) }} </td>
                            </tr>
                    @endforeach
                   
                    <tr class="font-weight-bold">
                        <td colspan="2" class="text-right">Total</td>
                        <td>{{ Pharma::attendanceHourCount($slots) }}</td>
                    </tr>
                       
                @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endforeach

@include('elements.dataTableOne')
@endsection

@push('js')
<script src='{{ asset('js') }}/print.js'></script>
<script>
    $('#month , #year').change(function(){
        $('#searchForm').submit();
    });
    function invoiceprint(id){
        $("#printJS-form"+id).print({
            addGlobalStyles : true,
            stylesheet : "{{ asset('css') }}/print.css",
            // rejectWindow : true,
            noPrintSelector : "#printSection,#footer",
            // iframe : false,
            append : null,
            prepend : "#footer"
        });
    }   
</script>
@endpush

    