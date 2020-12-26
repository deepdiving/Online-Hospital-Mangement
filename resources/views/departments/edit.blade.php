@extends('layout.app',['pageTitle' => 'Doctor Department'])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
       Update New Doctor Department
    @endslot
@endcomponent

@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">Doctor Department</h4>
                <h6 class="card-subtitle">Update New Doctor Department</h6>
                <hr class="hr-borderd">
                    <form class="form-material m-t-40 form" action="{{ url('departments/'.$department->id) }}" method="post">
                        @method('put')
                        @csrf
                        <div class="form-group row {{ $errors->has('dep_name') ? ' has-danger' : '' }}">
                            <label for="dep_name" class="col-sm-2 text-right control-label col-form-label">Department Name<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="dep_name" value="{{old('dep_name',$department->dep_name)}}" class="form-control" id="dep_name" required autocomplete="off">
                                @include('elements.feedback',['field' => 'dep_name'])
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                            <label for="description" class="col-sm-2 text-right control-label col-form-label">Description<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="description" value="{{old('description',$department->description)}}" class="form-control" id="description" required autocomplete="off">
                                @include('elements.feedback',['field' => 'description'])
                            </div>
                        </div>
                        <div class="form-group m-b-0 float-right">
                            <a href="{{url('departments')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
