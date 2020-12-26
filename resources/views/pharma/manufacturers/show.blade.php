@extends('layout.app',['pageTitle' => __('messages.manufactureres_show')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.manufac_show') }}
    @endslot
@endcomponent

@include('elements.alert') 
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"> {{ __('messages.manufacturer') }}</h4>
                    <hr>
                    <form class="form-material m-t-40 form" action="{{ route('manufacturer.update',$manufacturer) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group row {{ $errors->has('manufacturer') ? ' has-danger' : '' }}">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.manufac_name') }}:</label>
                            <div class="col-sm-10">
                                <input type="text" name="manufacturer_name" value="{{$manufacturer->manufacturer_name}}" class="form-control" id="manufacturer" placeholder="manufacturer name" required autocomplete="off" disabled>
                                @include('elements.feedback',['field' => 'manufacturer'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('phone') ? ' has-danger' : '' }}">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.manufac_phone') }} :</label>
                            <div class="col-sm-10">
                                <input type="number" name="phone" value="{{$manufacturer->phone}}" class="form-control" id="Phone" placeholder="manufacturer Phone" required autocomplete="off" disabled>
                                @include('elements.feedback',['field' => 'phone'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('address') ? ' has-danger' : '' }}">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.manufac_address') }}</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="address" value="{{$manufacturer->address}}" class="form-control" id="address" placeholder="manufacturer Address" required autocomplete="off" disabled>
                                @include('elements.feedback',['field' => 'address'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('balance') ? ' has-danger' : '' }}">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.manufac_balance') }} :</label>
                            <div class="col-sm-10">
                                <input type="text" name="manufacturer_balance" value="{{$manufacturer->manufacturer_balance}}" class="form-control" id="balance" placeholder="manufacturer balance" required autocomplete="off" disabled>
                                @include('elements.feedback',['field' => 'balance'])
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <a href="{{route('manufacturer.index')}}" class="btn btn-themecolor waves-effect float-right waves-light m-t-10">{{__('messages.back')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
