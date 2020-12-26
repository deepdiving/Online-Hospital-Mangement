@extends('layout.app',['pageTitle' => __('My Profile')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ __('messages.my_pro_page') }}
@endslot
@endcomponent
@include('elements.alert')
@push('css')
<style>
    .avatar-upload .avatar-edit {
    right: 2px !important;
    top: 3px !important;
}
.avatar-upload .avatar-edit input+label {
    height: 186px !important;
    width: 187px !important;
    }
</style>
@endpush
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">{{ __('messages.my_profile') }}</h3>
                <h6 class="card-subtitle">{{ __('messages.profile_update') }}</h6>
                <hr class="hr-borderd">
                <form class="form-horizontal form form-material m-t-40" method="post" action="{{url('myprofile')}}" enctype="multipart/form-data">
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
                            <input type="password" name="password" class="form-control" id="password"  placeholder="Password" autocomplete="off">
                            <small class="form-text text-muted">{{ __('password_mess') }}.</small>
                            @include('elements.feedback',['field' => 'password'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-2 text-right control-label col-form-label"></label>
                        <div class="col-sm-10 d-flex">
                            <div class="form-group mr-3{{ $errors->has('logo') ? ' has-danger' : '' }}">
                            <label for="">{{ __('messages.profile_image')}} :</label>
                            <div class="avatar-upload mr-3">
                                <div class="avatar-edit">
                                    <input type='file' id="imageUpload" name="profile_image" value="{{old('profile_image')}}" class="form-control" accept=".png, .jpg, .jpeg" />
                                    <label for="imageUpload"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url({{!empty($user->profile_image)?asset(Storage::url($user->profile_image)) : url('default.png')}});"></div>
                                </div>
                            </div>
                            </div>
                            <input type="hidden" name="old_profile_image" value="{{$user->profile_image}}">
                            @include('elements.feedback',['field' => 'profile_image']) 
                            <div class="form-group mr-3{{ $errors->has('logo') ? ' has-danger' : '' }}">
                            <label for="">{{ __('messages.profile_banner')}} :</label>
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' id="banar" name="profile_banar" value="{{old('profile_banar')}}" class="form-control" accept=".png, .jpg, .jpeg" />
                                    <label for="banar"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="login_image_Preview" style="background-image: url({{!empty($user->profile_banar)?asset(Storage::url($user->profile_banar)) : url('default.png')}});"></div>
                                </div>
                            </div>
                            <input type="hidden" name="old_profile_banar" value="{{$user->profile_banar}}">
                            @include('elements.feedback',['field' => 'profile_banar'])
                        </div>
                        </div>
                    </div>

                    <div class="form-group m-b-0">
                        <button type="submit" class="btn btn-info waves-effect float-right waves-light m-t-10">{{ __('messages.update')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('css/imageupload.css') }}">
@endpush
@push('js')
<script src="{{ asset('js/imageupload.js') }}"></script>
<script>
    $('#banar').on('click', function () {
        console.log('asdiuh');
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#login_image_Preview').css('background-image', 'url('+e.target.result +')');
                    $('#login_image_Preview').hide();
                    $('#login_image_Preview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#banar").change(function() {
            readURL(this);
        });
    });
</script>
@endpush
