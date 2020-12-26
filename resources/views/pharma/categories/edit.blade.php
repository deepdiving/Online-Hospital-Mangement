@extends('layout.app',['pageTitle' => $category->name])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{__('messages.update')}} {{trans_choice('messages.category',1)}}
    @endslot
@endcomponent
 
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">{{trans_choice('messages.category',1)}}</h4>
                <h6 class="card-subtitle">{{__('messages.update')}} {{trans_choice('messages.category',1)}}</h6>
                <hr class="hr-borderd">
                    <form class="form-material m-t-40 form" action="{{ route('category.update',$category) }}" method="post">
                        @method('put')
                        @csrf
                        <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.name')}}<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="{{old('name',$category->name)}}" class="form-control" id="name" required autocomplete="off">
                                @include('elements.feedback',['field' => 'name'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                            <label for="description" class="col-sm-2 text-right control-label col-form-label">{{__('messages.description')}} :</label>
                            <div class="col-sm-10">
                                <textarea name="description" class="form-control" rows="10" placeholder="Tell me about this category.">{{old('name',$category->description)}}</textarea>
                                <small>{{__('messages.write_a_note')}};</small>
                                @include('elements.feedback',['field' => 'description'])
                            </div>
                        </div>  
                        <div class="form-group m-b-0 float-right">
                            <a href="{{url('products/category')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection