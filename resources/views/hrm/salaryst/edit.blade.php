@extends('layout.app',['pageTitle' => 'Salary Structure'])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
       Update New Salary Structure
    @endslot
@endcomponent

@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">Salary Structure</h4>
                <h6 class="card-subtitle">Update New Salary Structure</h6>
                <hr class="hr-borderd">
                    <form class="form-material m-t-40 form" action="{{ url('salary/structure/'.$structure->id) }}" method="post">
                        @method('put')
                        @csrf
                        <div class="form-group row {{ $errors->has('title') ? ' has-danger' : '' }}">
                            <label for="title" class="col-sm-2 text-right control-label col-form-label">Title<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" value="{{old('title',$structure->title)}}" class="form-control" id="title" required autocomplete="off">
                                @include('elements.feedback',['field' => 'title'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('type') ? ' has-danger' : '' }}">
                            <label for="type" class="col-sm-2 text-right control-label col-form-label">Type<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                            <select name="type" class="form-control" id="type" required autocomplete="off">                  
                                <option value="" selected disabled>Select Salary Structure Type</option>
                                <option value="Added" @if($structure->type == "Added") selected @endif>Added</option>
                                <option value="Detuct" @if($structure->type == "Detuct") selected @endif>Detuct</option>
                            
                            </select>
                            </div>
                        </div>
                        <div class="form-group m-b-0 float-right">
                            <a href="{{url('salary/structure/')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
