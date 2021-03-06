@extends('layout.app',['pageTitle' => 'Referral Category'])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
    Referral Category
    @endslot
@endcomponent

@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"> Referral Category </h4>
                    <hr class="hr-borderd">
                    <form class="form-material m-t-40">
                        <div class="form-group row">
                            <label class="col-sm-2 text-right control-label col-form-label"> Category Name :</label>
                            <div class="col-sm-10">
                                <input disabled type="text" value="{{ $category->cat_name }}" class="form-control text-dark">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 text-right control-label col-form-label"> Price :</label>
                            <div class="col-sm-10">
                                <input disabled type="text" value="{{ $category->price }}%" class="form-control text-dark">
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <a href="{{url('referral/category')}}" class="btn bg-theme text-light waves-effect float-right waves-light m-t-10">{{__('messages.back')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
