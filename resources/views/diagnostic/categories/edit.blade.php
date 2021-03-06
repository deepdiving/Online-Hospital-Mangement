@extends('layout.app',['pageTitle' => $DiagonTestCategory->category])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{__('messages.update')}} {{trans_choice('messages.test_category',10)}}
    @endslot
@endcomponent
 
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">{{trans_choice('messages.test_category',1)}}</h4>
                <h6 class="card-subtitle">{{__('messages.update')}} {{trans_choice('messages.test_category',10)}}</h6>
                <hr class="hr-borderd">
                    <form class="form-material m-t-40 form" action="{{ url('/diagnostic/categories/'.$DiagonTestCategory->id) }}" method="post">
                        @method('put')
                        @csrf
                        <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="category" class="col-sm-2 text-right control-label col-form-label">{{ trans_choice('messages.test_category',1) }} {{__('messages.name')}}<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="category" value="{{old('category',$DiagonTestCategory->category)}}" class="form-control" id="name" required autocomplete="off">
                                @include('elements.feedback',['field' => 'category'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('commission') ? ' has-danger' : '' }}">
                            <label for="commission" class="col-sm-2 text-right control-label col-form-label">{{__('messages.comission')}}<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="number" name="commission" value="{{old('commission',sprintf('%0.2f',$DiagonTestCategory->commission))}}" class="form-control" id="commission"  required autocomplete="off">
                                @include('elements.feedback',['field' => 'category'])
                            </div>
                        </div>  
                        <div class="form-group m-b-0 float-right">
                            <a href="{{url('diagnostic/categories')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection