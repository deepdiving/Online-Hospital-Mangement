@extends('layout.app',['pageTitle' => 'Attendence'])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
    Attendence
    @endslot
@endcomponent
 
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"> Attendence</h4>
                    <hr class="hr-borderd">
                    <form class="form-material m-t-40">
                        <div class="form-group row">
                            <label class="col-sm-2 text-right control-label col-form-label">Employee Name :</label>
                            <div class="col-sm-10">
                                <input disabled type="text" value="{{  $attendence->employee->name }}" class="form-control text-dark">
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-sm-2 text-right control-label col-form-label">Date :</label>
                            <div class="col-sm-10">
                                <input disabled type="text" value="{{date('d M ',strtotime($attendence->date)) }}" class="form-control text-dark">
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-sm-2 text-right control-label col-form-label">Time :</label>
                            <div class="col-sm-10">
                                <input disabled type="text" value="{{ date('h:i A', strtotime($attendence->time)) }}" class="form-control text-dark">
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-sm-2 text-right control-label col-form-label">Check  :</label>
                            <div class="col-sm-10">
                                <input disabled type="text" value="{{  $attendence->status }}" class="form-control text-dark">
                            </div>
                        </div>  
                                                   
                        <div class="form-group m-b-0">
                            <a href="{{url('/attendence')}}" class="btn bg-theme text-light waves-effect float-right waves-light m-t-10">{{__('messages.back')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection