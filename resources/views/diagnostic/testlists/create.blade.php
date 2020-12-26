@extends('layout.app',['pageTitle' => __('messages.new_test_list')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
       {{__('messages.create_new')}} {{trans_choice('messages.test_list',10)}}
    @endslot
@endcomponent
 
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{trans_choice('messages.test_list',1)}}</h4>
                    <h6 class="card-subtitle">{{__('messages.create_new')}} {{trans_choice('messages.test_list',10)}}</h6>
                    <hr class="hr-borderd">
                    <form class="form-material m-t-40 form" action="{{ url('/diagnostic/testlists') }}" method="post">
                        @csrf
                        <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{trans_choice('messages.test',1)}} {{__('messages.name')}}<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="Test Name" required autocomplete="off">
                                @include('elements.feedback',['field' => 'name'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('test_category_id') ? ' has-danger' : '' }}">
                            <label for="test_category_id" class="col-sm-2 text-right control-label col-form-label">{{trans_choice('messages.test',1)}} {{trans_choice('messages.category',1)}}<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <select name="test_category_id" class="form-control" id="test_category_id" required autocomplete="off">
                                 <option value="" selected disabled>Select Test Category</option>
                                 @foreach ($diagonTestCategories as $row)
                                 <option value="{{ $row->id}}">{{ $row->category }}</option>
                                 @endforeach   
                                </select>
                                @include('elements.feedback',['field' => 'test_category_id'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('price') ? ' has-danger' : '' }}">
                            <label for="price" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.price_in')}}<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="number" name="price" value="{{old('price')}}" class="form-control" id="price" placeholder="Price" required autocomplete="off">
                                @include('elements.feedback',['field' => 'price'])
                            </div>
                        </div>  
                        <div class="form-group m-b-0 float-right">
                            <a href="{{url('diagnostic/testlists')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
