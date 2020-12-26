@extends('layout.app',['pageTitle' => 'Employee'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Employee List
@endslot
@endcomponent
@include('elements.alert') 
<div class="col-lg-12 col-md-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title d-inline">Employee List</h4><br>
            <h6 class="card-subtitle d-inline">{{__('messages.see_all')}} Employee</h6>

            <a class="btn float-right bg-theme text-light" href="{{url('employee/create')}}">New Employee</a>

            <hr class="hr-borderd">

            <div class="col-lg-12">
                <div class="Content">
                    <table class="table table-bordered table-hover Content" id="myTable">
                        <thead>
                            <tr class="themeThead">
                                <th width="50">{{__('messages.sl')}}</th>
                                <th>{{trans_choice('messages.picture',1)}}</th>
                                <th>Employee</th>
                                <th>Joining Date</th>
                                <th class="text-right">Basic Salary</th>
                                <th class="text-right">Gross Salary</th> 
                                <th width="100">{{__('messages.action')}}</th>
                            </tr>
                        </thead>

                         <tbody>
                            <?php $i = 0;?>
                            @foreach($employee as $row)
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>
                                    <td><img style="width: auto;height: 50px;" src="{{ !empty($row->picture) ? asset($row->picture) : asset('user-default.png')}}" alt=""></td>
                                    <td>{{ $row->name }}</td> 
                                    <td>{{  Pharma::dateFormat($row->joining_date) }}</td>
                                    <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->basic_salary) }}</td>
                                    <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->gross_salary) }}</td> 
                                    <td style="display: flex; justify-content: space-evenly;">
                                        
                                        <a class="btn waves-effect waves-light text-light btn-xs btn-info" href="{{ url('employee/'.$row->id) }}"><i class="fa fa-eye"></i></a>
                                        <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('employee/'.$row->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                        
                                        <form action="{{ url('employee/'.$row->id) }}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
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
