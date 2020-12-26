@extends('layout.app',['pageTitle' => ' Employee Salary Structure'])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
  HRM Employee Salary Structure
    @endslot
@endcomponent
 
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Employee Salary Structure </h4>
                    <hr class="hr-borderd">
                    <form class="form-material m-t-40">
                        <div class="form-group row">
                            <label class="col-sm-2 text-right control-label col-form-label"> Employee Name :</label>
                            <div class="col-sm-10">
                                <input disabled type="text" value="{{ $structure->employee->name }}" class="form-control text-dark">
                            </div>

                            <label class="col-sm-2 text-right control-label col-form-label"> Salary Type :</label>
                            <div class="col-sm-10 m-t-10">
                                <input disabled type="text" value="{{ $structure->salarystr->title }}" class="form-control text-dark">
                            </div>

                            <label class="col-sm-2 text-right control-label col-form-label"> Amount:</label>
                            <div class="col-sm-10 m-t-10">
                                <input disabled type="text" value="{{ $structure->amount }} %" class="form-control text-dark">
                            </div>
                        </div>                             
                        <div class="form-group m-b-0">
                            <a href="{{url('employee/salary/structure/')}}" class="btn bg-theme text-light waves-effect float-right waves-light m-t-10">{{__('messages.back')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection