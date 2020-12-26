@extends('layout.app',['pageTitle' => __('Add New Template')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('Templates') }}
    @endslot
@endcomponent
 
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Templates</h4>
                    <h6 class="card-subtitle">Create a new template</h6>
                    <hr>
                    <form class="m-t-40 form-material form" action="{{ route('emailtemplate.store') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">Template Name :</label>
                            <div class="col-sm-10">
                                <input type="text" disabled value="{{$emailtemplate->name}}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="slug" class="col-sm-2 text-right control-label col-form-label">Template Slug :</label>
                            <div class="col-sm-10">
                                <input type="text" disabled value="{{$emailtemplate->slug}}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subject" class="col-sm-2 text-right control-label col-form-label">Template subject :</label>
                            <div class="col-sm-10">
                                <input type="text" disabled value="{{$emailtemplate->subject}}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="content" class="col-sm-2 text-right control-label col-form-label">Content :</label>
                            <div class="col-sm-10">
                                {!!$emailtemplate->content!!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-2 text-right control-label col-form-label">Description :</label>
                            <div class="col-sm-10">
                                <input type="text" disabled value="{{$emailtemplate->description}}" class="form-control">
                            </div>
                        </div>                         
                        <div class="form-group row">
                            <label for="from_name" class="col-sm-2 text-right control-label col-form-label">From Name :</label>
                            <div class="col-sm-10">
                                <input type="text" disabled value="{{$emailtemplate->from_name}}" class="form-control">
                            </div>
                        </div>                         
                        <div class="form-group row">
                            <label for="from_email" class="col-sm-2 text-right control-label col-form-label">From Email :</label>
                            <div class="col-sm-10">
                                <input type="email" disabled value="{{$emailtemplate->from_email}}" class="form-control">
                            </div>
                        </div>                         
                        <div class="form-group row">
                            <label for="cc_email" class="col-sm-2 text-right control-label col-form-label">CC Email :</label>
                            <div class="col-sm-10">
                                <input type="email" disabled value="{{$emailtemplate->cc_email}}" class="form-control">
                            </div>
                        </div>                         
                        <div class="form-group m-b-0">
                            <a href="{{route('emailtemplate.index')}}" class="btn btn-info waves-effect float-right waves-light m-t-10">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection