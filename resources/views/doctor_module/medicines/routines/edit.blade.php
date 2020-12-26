@extends('layout.app',['pageTitle' => $routine->name])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
       Update Routine
    @endslot
@endcomponent
 
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Routine</h4>
                    <h6 class="card-subtitle">Update Routine</h6>
                    <hr class="hr-borderd">
                    <form class="form-material m-t-40 form" action="{{ url('doctor/medicine/routine/'.$routine->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.service_name')}} <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="{{old('name',$routine->name)}}" class="form-control" id="name" placeholder="Service Name" required autocomplete="off">
                                @include('elements.feedback',['field' => 'name'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('pre_medicine_type_id') ? ' has-danger' : '' }}">
                            <label for="pre_medicine_type_id" class="col-sm-2 text-right control-label col-form-label">{{__('messages.ser_category')}}<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <select name="pre_medicine_type_id" class="form-control" id="pre_medicine_type_id" required autocomplete="off">
                                 <option value="" selected disabled>Select Medicine Type</option>
                                 @foreach ($type as $row)
                                 <option value="{{ $row->id}}"@if($row->id==$routine->pre_medicine_type_id) selected @endif>{{ $row->name }}</option>
                                 @endforeach   
                                </select>
                                @include('elements.feedback',['field' => 'pre_medicine_type_id'])
                            </div> 
                        </div>                     
                        <div class="form-group m-b-0 float-right">
                            <a href="{{url('doctor/medicine/routine/')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
