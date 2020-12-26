@extends('layout.app',['pageTitle' => __('Site Management')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.site_setting') }}
    @endslot
@endcomponent
@push('css')
<style>
.avatar-upload .avatar-edit {
    right: 2px !important;
    top: 3px !important;
}
.avatar-upload .avatar-edit input+label {
    height: 186px !important;
}
</style>
@endpush
@include('elements.alert')

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline">{{ __('messages.site_setting') }}</h4>
                    <h6 class="card-subtitle d-inline">{{ __('messages.all_setting_li') }}..</h6>
                <hr class="hr-borderd">
                <form class="form-material m-t-40 form" action="{{ url('settings/system-setting/general') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- @method('put') --}}
                    <div class="form-group row {{ $errors->has('site_name') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.site_title') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input siteSetting="text" name="site_name" value="{{old('site_name',$siteSetting->site_name)}}" class="form-control" id="site_name" placeholder="Site name" required autocomplete="off">
                            @include('elements.feedback',['field' => 'site_name'])
                        </div>
                    </div>

                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10 d-flex">
                        <div class="form-group mr-3{{ $errors->has('logo') ? ' has-danger' : '' }}">
                            <label for="">{{ __('messages.site_logo') }} :</label>
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' id="imageUpload" name="logo" value="{{old('logo')}}" class="form-control" accept=".png, .jpg, .jpeg" />
                                        <label for="imageUpload"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="imagePreview" style="background-image: url({{!empty($siteSetting->logo)?asset(Storage::url($siteSetting->logo)) : url('default.png')}});"></div>
                                    </div>
                                @include('elements.feedback',['field' => 'logo'])
                            </div>
                        </div>
                        <input type="hidden" name="old_logo" value="{{$siteSetting->logo}}">

                        <div class="form-group mr-3{{ $errors->has('login_banar') ? ' has-danger' : '' }}">
                            <label for="">{{ __('messages.login_banar') }} :</label>
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' id="login_image" name="login_banar" value="{{old('login_banar')}}" class="form-control" accept=".png, .jpg, .jpeg" />
                                        <label for="login_image"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="login_image_Preview" style="background-image: url({{!empty($siteSetting->login_banar)?asset(Storage::url($siteSetting->login_banar)) : url('default.png')}});"></div>
                                    </div>
                                </div>
                                @include('elements.feedback',['field' => 'login_banar'])
                        </div>
                        <input type="hidden" name="old_login_banar" value="{{$siteSetting->login_banar}}">

                        <div class="form-group mr-3{{ $errors->has('reg_banar') ? ' has-danger' : '' }}">
                            <label for="">{{ __('messages.register_banar') }} :</label>
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' id="register_image" name="reg_banar" value="{{old('reg_banar')}}" class="form-control" accept=".png, .jpg, .jpeg" />
                                        <label for="register_image"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="register_image_Preview" style="background-image: url({{!empty($siteSetting->reg_banar)?asset(Storage::url($siteSetting->reg_banar)) : url('default.png')}});"></div>
                                    </div>
                                </div>
                                @include('elements.feedback',['field' => 'reg_banar'])
                           
                        </div>
                        <input type="hidden" name="old_reg_banar" value="{{$siteSetting->reg_banar}}">

                    </div>
                </div>












                            {{-- <div class="form-group row {{ $errors->has('login_banar') ? ' has-danger' : '' }}">
                                <label for="" class="col">Login Banar :</label>
                                <div class="col-sm-10">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' id="login_image" name="login_banar" value="{{old('login_banar')}}" class="form-control" accept=".png, .jpg, .jpeg" />
                                            <label for="login_image"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="login_image_Preview" style="background-image: url({{!empty($siteSetting->login_banar)?asset(Storage::url($siteSetting->login_banar)) : url('default.png')}});"></div>
                                        </div>
                                    </div>
                                    @include('elements.feedback',['field' => 'login_banar'])
                                </div>
                            </div>
                            <input type="hidden" name="old_login_banar" value="{{$siteSetting->login_banar}}">

                            <div class="form-group row {{ $errors->has('reg_banar') ? ' has-danger' : '' }}">
                                <label for="" class="col">Register Banar :</label>
                                <div class="col-sm-10">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' id="register_image" name="reg_banar" value="{{old('reg_banar')}}" class="form-control" accept=".png, .jpg, .jpeg" />
                                            <label for="register_image"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="register_image_Preview" style="background-image: url({{!empty($siteSetting->reg_banar)?asset(Storage::url($siteSetting->reg_banar)) : url('default.png')}});"></div>
                                        </div>
                                    </div>
                                    @include('elements.feedback',['field' => 'reg_banar'])
                                </div>
                            </div>
                            <input type="hidden" name="old_reg_banar" value="{{$siteSetting->reg_banar}}">
                        </div>
                    </div> --}}
                    <div class="form-group row {{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.email') }} :<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input siteSetting="email" name="email" value="{{old('email',$siteSetting->email)}}" class="form-control" id="email" placeholder="Site email" required autocomplete="off">
                            @include('elements.feedback',['field' => 'email'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('phone_number') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.phone') }} :<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input siteSetting="number" name="phone_number" value="{{old('phone_number',$siteSetting->phone_number)}}" class="form-control" id="phone_number" placeholder="Site email" required autocomplete="off">
                            @include('elements.feedback',['field' => 'phone_number'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('address') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.address_text') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input siteSetting="text" name="address" value="{{old('address',$siteSetting->address)}}" class="form-control" id="address" placeholder="Site footer" required autocomplete="off">
                            @include('elements.feedback',['field' => 'address'])
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('footer') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.footer_text') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input siteSetting="text" name="footer" value="{{old('footer',$siteSetting->footer_text)}}" class="form-control" id="footer" placeholder="Site footer" required autocomplete="off">
                            @include('elements.feedback',['field' => 'footer'])
                        </div>
                    </div>

                    <div class="form-group m-b-0">
                        <button siteSetting="submit" class="btn bg-theme text-light waves-effect float-right waves-light m-t-10">{{ __('messages.update') }}</button>
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
    $('#login_image').on('click', function () {
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
        $("#login_image").change(function() {
            readURL(this);
        });
    });
    $('#register_image').on('click', function () {
        console.log('asdiuh');
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#register_image_Preview').css('background-image', 'url('+e.target.result +')');
                    $('#register_image_Preview').hide();
                    $('#register_image_Preview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#register_image").change(function() {
            readURL(this);
        });
    });
    </script>

@endpush
