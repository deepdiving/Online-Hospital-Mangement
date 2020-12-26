@extends('layout.app',['pageTitle' => $employee->name])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Employees
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Show Employee</h4>
                <h6 class="card-subtitle">Employee</h6>
                <hr class="hr-borderd">
                <div class="row pt-3">
                    <div class="col-md-4 text-right">
                        <img src="{{ !empty($employee->picture) ? asset($employee->picture) : asset('user-default.png')}}" class="img-thumbnail" alt="">
                    </div>
                    <div class="col-md-4">
                        <h3 diplay-3 pt-1>{{ucfirst($employee->name)}}</h3>
                        <table class="table table-striped m-t-20"> 
                            <tr>
                                <td width='200'>Joining Date</td>
                                <td  width='5'>:</td>
                                <td>{{Pharma::dateFormat($employee->joining_date)}}</td>
                            </tr>
                            <tr>
                                <td>Date of Birth</td>
                                <td>:</td>
                                <td>{{Pharma::dateFormat($employee->date_of_birth)}}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{$employee->email}}</td>
                            </tr>
                            <tr>
                                <td>Mobile</td>
                                <td>:</td>
                                <td>{{$employee->phone_no}}</td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>:</td>
                                <td>{{$employee->gender}}</td>
                            </tr>
                            <tr>
                                <td>Maritual Status</td>
                                <td>:</td>
                                <td>{{$employee->marital_status}}</td>
                            </tr>
                            <tr>
                                <td>Basic Salary</td>
                                <td>:</td>
                                <td>{{$employee->basic_salary}}</td>
                            </tr>
                            <tr>
                                <td>Gross Salary</td>
                                <td>:</td>
                                <td>{{$employee->gross_salary}}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td>{{$employee->address}}</td>
                            </tr>
                            <tr>
                                <td>Emergency Contact</td>
                                <td>:</td>
                                <td>{{$employee->emergency_contact}}</td>
                            </tr>
                            <tr>
                                <td>Emergency Address</td>
                                <td>:</td>
                                <td>{{$employee->emergency_address}}</td>
                            </tr>
                        </table>
                        <a href="{{url('employee/'.$employee->id.'/edit')}}" class="btn bg-theme text-white">Edit</a>
                        <a href="{{route('employee.index')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>


@endsection

@push('js')
<script src="{{ asset('js') }}/sweetalert.min.js"></script> 
@endpush
