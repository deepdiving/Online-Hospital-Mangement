@extends('layout.app',['pageTitle' => $bedtype->name])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{__('messages.update')}} {{__('messages.bed_type')}}
    @endslot
@endcomponent
 
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">{{__('messages.bed_type')}}</h4>
                <h6 class="card-subtitle">{{__('messages.update')}} {{__('messages.bed_type')}}</h6>
                <hr class="hr-borderd">
                    <form class="form-material m-t-40 form" action="{{ url('/hospital/beds/bedtype/'.$bedtype->slug) }}" method="post">
                        @method('put')
                        @csrf
                        <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="category" class="col-sm-2 text-right control-label col-form-label">{{__('messages.bed_type')}} {{__('messages.name')}}<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="{{old('name',$bedtype->name)}}" class="form-control" id="name" required autocomplete="off">
                                @include('elements.feedback',['field' => 'name'])
                            </div>
                        </div>  
                        <div class="form-group m-b-0 float-right">
                            <a href="{{url('/hospital/beds/bedtype')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection