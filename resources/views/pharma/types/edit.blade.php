@extends('layout.app',['pageTitle' => __('Edit Type')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ trans_choice('messages.type',1) }}
    @endslot
@endcomponent
 
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">{{ trans_choice('messages.type',1) }}</h4>
                <h6 class="card-subtitle">{{ __('messages.update_product') }}</h6>
                <hr class="hr-borderd">
                <form class="form-material m-t-40 form" action="{{ route('type.update',$type) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{  __('messages.pro_type_name')}}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="type_name" value="{{old('type_name',$type->type_name)}}" class="form-control" id="name" placeholder="Type name" required autocomplete="off">
                            @include('elements.feedback',['field' => 'type_name'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                        <label for="description" class="col-sm-2 text-right control-label col-form-label">{{  __('messages.description')}} :</label>
                        <div class="col-sm-10">
                            <textarea name="description" class="form-control" rows="10" placeholder="Tell me about this type.">{{$type->description}}</textarea>
                            <small>{{ __('messages.pro_short_note') }};</small>
                            @include('elements.feedback',['field' => 'description'])
                        </div>
                    </div>   
                    <div class="form-group m-b-0 float-right">
                        <a href="{{url('products/type')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                        <button type="submit" class="btn bg-theme text-white">{{__('messages.update')}}</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
