@extends('layout.app',['pageTitle' => $appointment->patient_name])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Patient
@endslot
@endcomponent
@include('elements.alert')

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Show Patient</h4>
                <h6 class="card-subtitle">Patient</h6>
                <hr class="hr-borderd">
                <div class="row pt-3">
                    <div class="col-md-4 text-right">
                    </div>
                    <div class="col-md-8 text-left">
                        <h3 class="display-5 pt-1"> {{ucfirst($appointment->patient->patient_name)}} <sub class="text-muted sub"></sub></h3>
                        <table class="table table-striped m-t-40">
                            <tr>
                                <td width='200'>Registration Date</td>
                                <td  width='5'>:</td>
                                <td>{{Pharma::dateFormat($appointment->patient->created_at)}}</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>:</td>
                                <td>{{$appointment->patient->description}}</td>
                            </tr>
                             <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{$appointment->patient->email}}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>:</td>
                                <td>{{$appointment->patient->phone}}</td>
                            </tr>
                            <tr>
                                <td>Mobile</td>
                                <td>:</td>
                                <td>{{$appointment->patient->mobile}}</td>
                            </tr>
                            <tr>
                                <td>Age</td>
                                <td>:</td>
                                <td>{{$appointment->patient->age}}</td>
                            </tr>
                            <tr>
                                <td>Blood Group</td>
                                <td>:</td>
                                <td>{{$appointment->patient->blood_group}}</td>
                            <tr>
                                <td>Gender</td>
                                <td>:</td>
                                <td>{{$appointment->patient->gender}}</td>
                            </tr>
                            <tr>
                                <td>Marital Status</td>
                                <td>:</td>
                                <td>{{$appointment->patient->marital_status}}</td>
                            </tr>
                            <tr>
                                <td>Religion</td>
                                <td>:</td>
                                <td>{{$appointment->patient->religion}}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td>{{$appointment->patient->address}}</td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
  <div class="col-lg-12 col-md-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title d-inline">Patient Information</h4><br>
            <h6 class="card-subtitle d-inline"> appointed patient</h6>
           <hr class="hr-borderd">

            <div class="col-lg-12">
                <div class="Content">
                    <table class="table table-bordered table-hover Content" id="myTable">
                        <thead>
                            <tr class="themeThead">
                                <th>Serial Number</th>
                                <th>Serial Date</th>
                                <th>Schedule</th>
                                <th>Time</th>
                                <th>Problem</th>
                                <th class="text-left">Status</th>
                                <th width="100">{{__('messages.action')}}</th>
                            </tr>
                        </thead>
                        <tr>
                            <td>{{$appointment->serial}}</td>
                            <td>{{$appointment->date}}</td>
                            <td>{{$appointment->docschedule->name}}</td>
                            <td>{{$appointment->docschedule->start_time}}-{{$appointment->docschedule->end_time}}</td>
                            <td>{{$appointment->patient->description}}</td>
                            <td>{{$appointment->status}}</td>
                        </tr>
                        <tbody>
                       </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('elements.dataTableOne')
@endsection
