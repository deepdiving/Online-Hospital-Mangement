@extends('layout.app',['pageTitle' => 'Referral Category'])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
       Update New Category
    @endslot
@endcomponent

@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">Referral Category</h4>
                <h6 class="card-subtitle">Update New Category</h6>
                <hr class="hr-borderd">
                <form class="form-material m-t-40 form" action="{{ url('referral/category') }}" method="post">
                        @csrf
                        <div class="form-group row {{ $errors->has('cat_name') ? ' has-danger' : '' }}">
                            <label for="cat_name" class="col-sm-2 text-right control-label col-form-label">Name <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="cat_name" value="{{old('name',$category->cat_name)}}"class="form-control" id="name" placeholder="Type Name" required autocomplete="off">
                                @include('elements.feedback',['field' => 'cat_name'])
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('price') ? ' has-danger' : '' }}">
                            <label for="price" class="col-sm-2 text-right control-label col-form-label">Price <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                            <div class="md-form input-group ">
                                <input type="number" name="price"  value="{{old('price',$category->price)}}"%" class="form-control form-control-line" id="price" placeholder="discountPercent" autocomplete="off">
                                <div class="input-group-append "><span class="input-group-text md-addon">%</span></div>
                            </div>
                                @include('elements.feedback',['field' => 'price'])
                            </div>
                        </div>
                        <div class="form-group m-b-0 float-right">
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
