@extends('layout.app',['pageTitle' => __('messages.add_expense')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('Expense Categorys') }}
    @endslot
@endcomponent

@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">{{__('messages.expense_category')}}</h4>
                <h6 class="card-subtitle">{{__('messages.create_new')}}</h6>
                <hr class="hr-borderd">
                <form class="form-material m-t-40 form" action="{{ url('expenses/category/store/') }}" method="post">
                    @csrf
                    <div class="form-group row {{ $errors->has('category_name') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label"> {{__('messages.name')}}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="category_name" value="{{old('category_name')}}" class="form-control" id="category_name" placeholder="category name" required autocomplete="off">
                            @include('elements.feedback',['field' => 'category_name'])
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <button type="submit" class="btn bg-theme waves-effect text-white float-right waves-light m-t-10">{{__('messages.save')}}</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
