@extends('layout.app',['pageTitle' => __('show tax')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.tax') }}
    @endslot
@endcomponent

@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">{{ __('messages.tax') }}</h4>
                <h6 class="card-subtitle">{{ __('messages.new_tax') }}</h6>
                <hr>
                <form class="form-material m-t-40 form" action="{{ route('tax.update',$tax) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group row {{ $errors->has('tax') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.tax_name') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="tax_name" value="{{$tax->tax_name}}" class="form-control" id="tax" placeholder="tax name" required autocomplete="off" disabled>
                            @include('elements.feedback',['field' => 'tax'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                        <label for="description" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.description') }} :</label>
                        <div class="col-sm-10">
                            <textarea name="description" class="form-control" rows="10" placeholder="Tell me about this Umit." disabled>{{$tax->description}}</textarea>
                            @include('elements.feedback',['field' => 'description'])
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <a href="{{route('tax.index')}}" class="btn bg-theme text-light waves-effect float-right waves-light m-t-10">{{ __('messages.back') }}</a>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
