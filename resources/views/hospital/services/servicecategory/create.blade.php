@extends('layout.app',['pageTitle' => __('messages.new_ser_cate')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
       {{ __('messages.create_new') }} {{__('messages.ser_category')}}
    @endslot
@endcomponent
 
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{__('messages.ser_category')}}</h4>
                    <h6 class="card-subtitle">{{ __('messages.create_new') }} {{__('messages.ser_category')}} </h6>
                    <hr class="hr-borderd">
                    <form class="form-material m-t-40 form" action="{{ url('/hospital/services/servicecategory') }}" method="post">
                        @csrf  
                        <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.ser_category')}} {{ __('messages.name')}} <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="Service Category" required autocomplete="off">
                                @include('elements.feedback',['field' => 'name'])
                            </div>
                        </div>      
                        <div class="form-group m-b-0 float-right">
                            <a href="{{url('/hospital/services/servicecategory')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
