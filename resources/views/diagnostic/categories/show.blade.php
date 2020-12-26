@extends('layout.app',['pageTitle' => $DiagonTestCategory->category])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
       {{ trans_choice('messages.test_category',1) }}
    @endslot
@endcomponent
 
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{trans_choice('messages.test',1)}} {{trans_choice('messages.category',10)}}</h4>
                    <hr class="hr-borderd">
                    <form class="form-material m-t-40">
                        <div class="form-group row">
                            <label class="col-sm-2 text-right control-label col-form-label">{{trans_choice('messages.test',1)}} {{trans_choice('messages.category',10)}} :</label>
                            <div class="col-sm-10">
                                <input disabled type="text" value="{{ $DiagonTestCategory->category }}" class="form-control text-dark">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 text-right control-label col-form-label">{{__('messages.comission')}} :</label>
                            <div class="col-sm-10">
                                <input disabled type="text" class="form-control text-dark" value="{{ $DiagonTestCategory->commission }}">
                            </div>
                        </div>                              
                        <div class="form-group m-b-0">
                            <a href="{{url('diagnostic/categories')}}" class="btn bg-theme text-light waves-effect float-right waves-light m-t-10">{{__('messages.back')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection