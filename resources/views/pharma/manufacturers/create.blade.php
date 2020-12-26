@extends('layout.app',['pageTitle' => __('messages.manufacturer')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ __('messages.create_new_manufac') }}
@endslot
@endcomponent

@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('messages.manufacturer') }}</h4>
                <h6 class="card-subtitle">{{ __('messages.create_new_manufac') }}</h6>
                <hr class="hr-borderd">
                <form class="form-material m-t-40 form" action="{{ url('manufacturers/manufacturer') }}" method="post">
                    @csrf
                    <div class="form-group row {{ $errors->has('manufacturer') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.manufac_name') }}<supclass="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="manufacturer_name" value="{{old('manufacturer_name')}}"class="form-control" id="manufacturer" placeholder="manufacturer name" required autocomplete="off">
                            @include('elements.feedback',['field' => 'manufacturer'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('phone') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.manufac_phone') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="number" name="phone" value="{{old('phone')}}" class="form-control" id="Phone" placeholder="manufacturer Phone" required autocomplete="off">
                            @include('elements.feedback',['field' => 'phone'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('address') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.manufac_address') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="address" value="{{old('address')}}" class="form-control" id="address" placeholder="manufacturer Address" required autocomplete="off">
                            @include('elements.feedback',['field' => 'address'])
                        </div>
                    </div> 
                    <div class="form-group m-b-0 float-right">
                        <a href="{{url('manufacturers/manufacturer')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                        <button type="submit" class="btn bg-theme text-white">{{__('messages.save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection