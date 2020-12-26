@extends('layout.app',['pageTitle' => 'Employee Salary Structure'])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
       Update New Employee Salary Structure
    @endslot
@endcomponent

@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">Employee Salary Structure</h4>
                <h6 class="card-subtitle">Update New Employee Salary Structure</h6>
                <hr class="hr-borderd">
                    <form class="form-material m-t-40 form" action="{{ url('employee/salary/structure/'.$structure->id) }}" method="post">
                        @method('put')
                        @csrf           
                        <div class="form-group row {{ $errors->has('emp_id') ? ' has-danger' : '' }}">
                            <label for="emp_id" class="col-sm-2 text-right control-label col-form-label">Type<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                            <select name="emp_id" class="form-control" id="emp_id" required autocomplete="off">                  
                                @foreach ($employee as $row)
                                <option value="{{ $row->id}}"@if($row->id==$structure->emp_id) selected @endif>{{ $row->name }}</option>
                                @endforeach
                            
                            </select>
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('salary_structure_id') ? ' has-danger' : '' }}">
                            <label for="salary_structure_id" class="col-sm-2 text-right control-label col-form-label">Type<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                            <select name="salary_structure_id" class="form-control" id="salary_structure_id" required autocomplete="off">                  
                                @foreach ($salarystr as $row)
                                <option value="{{ $row->id}}"@if($row->id==$structure->salary_structure_id) selected @endif>{{ $row->title }}</option>
                                @endforeach
                            
                            </select>
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('amount') ? ' has-danger' : '' }}">
                            <label for="amount" class="col-sm-2 text-right control-label col-form-label">Amount<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="amount" value="{{old('amount',$structure->amount)}}" class="form-control" id="title" required autocomplete="off">
                                @include('elements.feedback',['field' => 'amount'])
                            </div>
                        </div>

                        <div class="form-group m-b-0 float-right">
                            <a href="{{url('employee/salary/structure/')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
