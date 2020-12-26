@extends('layout.app',['pageTitle' => $category->name])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{trans_choice('messages.category',10)}}
    @endslot
@endcomponent
 
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{trans_choice('messages.category',10)}}</h4>
                    <hr class="hr-borderd">
                    <form class="form-material m-t-40">
                        <div class="form-group row">
                            <label class="col-sm-2 text-right control-label col-form-label">{{__('messages.category_name')}} :</label>
                            <div class="col-sm-10">
                                <input disabled type="text" value="{{$category->name}}" class="form-control text-dark">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 text-right control-label col-form-label">{{__('messages.description')}} :</label>
                            <div class="col-sm-10">
                                <textarea disabled class="form-control text-dark" rows="5">{{$category->description}}</textarea>
                            </div>
                        </div>                              
                        <div class="form-group m-b-0">
                            <a href="{{route('category.index')}}" class="btn bg-theme text-light waves-effect float-right waves-light m-t-10">{{__('messages.back')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection