@extends('layout.app',['pageTitle' => 'Salary List'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Salary List
@endslot
@endcomponent
@include('elements.alert') 
<div class="col-lg-12 col-md-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title d-inline">Salary List</h4><br>
            <h6 class="card-subtitle d-inline">{{__('messages.see_all')}} Salary</h6> 

            <hr class="hr-borderd">

            <div class="col-lg-12">
                <div class="Content">
                    <table class="table table-bordered table-hover Content" id="myTable">
                        <thead>
                            <tr class="themeThead">
                                <th width="50">{{__('messages.sl')}}</th>  
                                <th>Month</th> 
                                <th>Employee</th>
                                <th class="text-right">Net Amount</th> 
                                <th>status</th>
                                <th width="100">{{__('messages.action')}}</th>
                            </tr>
                        </thead>

                         <tbody>
                            <?php $i = 0;?>
                            @foreach($salaryList as $row)
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>   
                                    <td>{{ date('F', mktime(0, 0, 0, $row->month)) }} {{ $row->year}}</td> 
                                    <td>{{ $row->employee->name }}</td>
                                    <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->thismonthamount) }}</td> 
                                    <td>{{$row->status}}</td> 
                                    <td style="display: flex; justify-content: space-evenly;"> 
                                        @if($row->status == 'Pending')
                                        <form action="{{url('salary/status/'.$row->id)}}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
                                            @csrf
                                            <input type="hidden" value="{{ $row->employee->id }}"  name="emp_id">
                                            <input type="hidden" value="{{ $row->id }}"  name="hrm_salary_id">
                                            <input type="hidden" value="{{ $row->basic_salary }}"  name="basic">
                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$row->id}})"><i class="mdi mdi-backup-restore"></i> Pay Now</button>
                                        </form>
                                        @else
                                        <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('salary/slip/'.$row->id)}}"><i class="mdi mdi-format-align-justify"></i> Pay Slip</a>
                                        @endif
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
