@extends('layout.app',['pageTitle' => __('Add Unit')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.unit') }}
    @endslot
@endcomponent

@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">{{ __('messages.unit') }}</h4>
                <h6 class="card-subtitle">{{ __('messages.new_unit') }}</h6>
                <hr class="hr-borderd">
                <form class="form-material m-t-40 form" action="{{ route('unit.update',$unit) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group row {{ $errors->has('unit') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.unit_name') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="unit_name" value="{{$unit->unit_name}}" class="form-control" id="unit" placeholder="unit name" required autocomplete="off">
                            @include('elements.feedback',['field' => 'unit'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                        <label for="description" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.description') }} :</label>
                        <div class="col-sm-10">
                            <textarea name="description" class="form-control" rows="10" placeholder="Tell me about this Umit.">{{$unit->description}}</textarea>
                            <small>Write a short description;</small>
                            @include('elements.feedback',['field' => 'description'])
                        </div>
                    </div> 
                    <div class="form-group m-b-0 float-right">
                        <a href="{{url('products/unit')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                        <button type="submit" class="btn bg-theme text-white">{{__('messages.update')}}</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
