@extends('layout.app',['pageTitle' => 'Positions Edit'])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        Update Position
    @endslot
@endcomponent
 
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Position Name</h4>
                    <h6 class="card-subtitle">Update Positons</h6>
                    <hr class="hr-borderd">
                    <form class="form-material m-t-40 form" action="{{ route('position.update',$position) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">Operation Name <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="{{old('name',$position->name)}}" class="form-control" id="name" placeholder="Service Name" required autocomplete="off">
                                @include('elements.feedback',['field' => 'name'])
                            </div>
                        </div> 
                        <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                            <label for="description" class="col-sm-2 text-right control-label col-form-label">Description <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                            <textarea  name="description"  class="form-control" row="9"  autocomplete="off">{{$position->description}}</textarea>
                                @include('elements.feedback',['field' => 'description'])
                            </div>
                        </div>       
                        <div class="form-group m-b-0 float-right">
                            <a href="{{url('/position')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
