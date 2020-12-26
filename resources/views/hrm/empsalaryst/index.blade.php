@extends('layout.app',['pageTitle' =>'Employee Salary Structure'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
HRM Employee Salary Structure
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="col-md-7 d-inline-block">
            <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline">Employee Salary Structure</h4><br>
                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="myTable">
                            <thead>
                                <tr class="">
                                    <th width="50">SL</th>
                                    <th>Employee Name</th>  
                                    <th>Salary Type</th> 
                                    <th>Amount %</th>                                                                    
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <?php $i = 0;?>
                            @foreach($empsalarystr as $row)
                             <tr>
                                 <td>{{sprintf('%02d',++$i)}}</td>
                                 <td>
                                     {{ $row->employee->name }}
                                 </td> 
                                 <td>
                                     {{ $row->salarystr->title }}
                                 </td> 
                                 <td>
                                     {{ $row->amount }}
                                 </td>                              
                                 <td style="display: flex; justify-content: space-evenly;">
                                    <a class="btn waves-effect waves-light btn-xs btn-info" href="{{ url('employee/salary/structure/'.$row->id) }}"><i class="fa fa-eye"></i></a>    
                                    <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('employee/salary/structure/'.$row->id.'/edit') }}"><i class="fa fa-edit"></i></a>                           
                                    <form action="{{  url('employee/salary/structure/'.$row->id) }}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
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
        <div class="col-md-5 float-right">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Employee Salary Structure</h4>
                    <h6 class="card-subtitle">Create New Employee Salary Structure </h6>
                    <form class="form-material m-t-40 form" action="{{ url('employee/salary/structure/') }}" method="post">
                        @csrf            
                        <div class="form-group row {{ $errors->has('emp_id') ? ' has-danger' : '' }}">
                            <label for="emp_id" class="col-sm-4 text-right control-label col-form-label">Employee Name<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-8">
                                <select name="emp_id" class="form-control" id="emp_id" required autocomplete="off">
                                 <option value="" selected disabled>Select Employee Name</option>
                                 @foreach ($employee as $row)
                                 <option value="{{ $row->id}}">{{ $row->name }}</option>
                                 @endforeach
                                </select>
                                @include('elements.feedback',['field' => 'emp_id'])
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('salary_structure_id') ? ' has-danger' : '' }}">
                            <label for="salary_structure_id" class="col-sm-4 text-right control-label col-form-label">Salary Type<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-8">
                                <select name="salary_structure_id" class="form-control" id="salary_structure_id" required autocomplete="off">
                                 <option value="" selected disabled>Select Employee Salary Type</option>
                                 @foreach ($salarystr as $row)
                                 <option value="{{ $row->id}}">{{ $row->title }}</option>
                                 @endforeach
                                </select>
                                @include('elements.feedback',['field' => 'salary_structure_id'])
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('amount') ? ' has-danger' : '' }}">
                            <label for="amount" class="col-sm-4 text-right control-label col-form-label">Amount <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-8">
                                <input type="text" name="amount" value="{{old('amount')}} %" class="form-control" id="amount" placeholder="Amount " required autocomplete="off">
                                @include('elements.feedback',['field' => 'amount'])
                            </div>
                        </div>
                        @foreach ($empsalarystr as $row)
                        <option value="{{ $row->id}}">{{ $row->type }}</option>
                        @endforeach
                        <div class="form-group m-b-0 float-right">
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('elements.dataTableOne')
@endsection
