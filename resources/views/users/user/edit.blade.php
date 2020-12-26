@extends('layout.app',['pageTitle' => __('User Managenent')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ __('messages.my_pro_page') }}
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('messages.user_profile')}}</h4>
                <h6 class="card-subtitle">{{ __('messages.edit_user_pro') }}</h6>
                <hr class="hr-borderd">
                <form class="form-material m-t-40 form" method="post" action="{{url('users/'.$user->id.'/update')}}">
                    @csrf
                    <div class="form-group row {{ $errors->has('first_name') ? ' has-danger' : '' }}">
                        <label for="first_name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.first_name') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="first_name" value="{{old('first_name',$user->first_name)}}" class="form-control" id="first_name" placeholder="First Name" required>
                            @include('elements.feedback',['field' => 'first_name'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('last_name') ? ' has-danger' : '' }}">
                        <label for="last_name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.last_name') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="last_name" value="{{old('last_name',$user->last_name)}}" class="form-control" id="last_name" placeholder="Last Name">
                            @include('elements.feedback',['field' => 'last_name'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label for="email" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.email') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="email" disabled class="form-control" id="email" placeholder="Email" name="email" value="{{old('email',$user->email)}}">
                            @include('elements.feedback',['field' => 'email'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label for="password" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.password') }} :</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                            <small class="form-text text-muted">{{ __('messages.password_mess') }}.</small>
                            @include('elements.feedback',['field' => 'password'])
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <button type="submit" class="btn bg-theme text-white waves-effect float-right waves-light m-t-10">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
