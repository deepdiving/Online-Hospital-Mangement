@extends('layout.app',['pageTitle' => __('Add expense Category')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('Expense Category') }}
    @endslot
@endcomponent

@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">{{__('messages.expense_catagory')}}</h4>
                <h6 class="card-subtitle">{{__('messages.edit_expense_category_edit')}}</h6>
                <hr>
                <form class="form-material m-t-40 form" action="{{ url('expenses/category',[$expenseCategory->slug])}}" method="post">
                    @csrf
                    @method('put')
                    <input type="hidden" name="slug" value="{{$expenseCategory->slug}}">
                    <div class="form-group row {{ $errors->has('category_name') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.expense_catagory')}} {{__('messages.name')}}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="category_name" value="{{$expenseCategory->category_name}}" class="form-control" id="category_name" placeholder="category name" required autocomplete="off">
                            @include('elements.feedback',['field' => 'category_name'])
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <button type="submit" class="btn btn-info waves-effect float-right waves-light m-t-10"> {{__('messages.update')}}</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
