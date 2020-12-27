<!DOCTYPE html>
<html lang="en">
<?php $siteInfo = Pharma::getSiteInfo()?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('material')}}/assets/images/favicon.ico">
    <title>{{$siteInfo->site_name}}</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('material')}}/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('material')}}/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{asset('material')}}/css/colors/green.css" id="theme" rel="stylesheet">
    <style>
    .log-from{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    [type="checkbox"] + label:before, [type="checkbox"]:not(.filled-in) + label:after {
        border: 2px solid #ffffff;
    }
    .font-40{
        font-size: 40px;
    }
    .font-44{
        font-size: 44px;
    }
    .userArea{
        cursor: pointer;
    }
    .elements :hover{
        background: red !important;
    }
    .bg-custom{
        background: #33352b;
    }
    .bg-text{
        background: #4b561f;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>

    <section id="wrapper" class="login-register login-sidebar"  style="background-image:url({{!empty($siteInfo->login_banar) ? asset(Storage::url($siteInfo->login_banar)) : asset('material/assets/images/background/login-register.jpg')}});">
        <div class="login-box card" style="background:#000000db; color:#fff !important; overflow-y:scroll">
          <div class="card-body log-from">
              <form class="form-horizontal login-form" id="loginform" action="{{route('process_login')}}" method="post">
                <a href="javascript:void(0)" class="text-center db"><img style="width: 200px; height: auto;" src="{{!empty($siteInfo->logo) ? asset(Storage::url($siteInfo->logo)) : asset('logo.png')}}" alt="Home" /></a>
                @csrf
                @if (session($key ?? 'status'))
                    <div class="alert alert-{{session('class')}} alert-dismissible fade show" role="alert">
                        {{ session($key ?? 'status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="form-group m-t-40 {{$errors->has('email')?'has-danger':''}}">
                    <div class="col-xs-12">
                        <input class="form-control" id="email" type="email" name="email" autocomplete="off" required="" placeholder="Email" value="{{old('email')}}">
                        @include('elements.feedback',['field' => 'email'])
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" id="password" type="password" name="password" required="" autocomplete="off" placeholder="Password">
                        @include('elements.feedback',['field' => 'password'])
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <div class="checkbox checkbox-primary pull-left p-t-0">
                            <input id="checkbox-signup" type="checkbox">
                            <label for="checkbox-signup"> Remember me </label>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="{{url('password_reset')}}" class="text-dark pull-right text-white"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a>
                    </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-success btn-lg btn-block text-uppercase waves-effect waves-light" id="login" type="submit">Log In</button>
                    </div>
                </div>

                <div class="row p-2">
                    <div class="col-md-4 p-2">
                        <div class="elements bg-custom text-center" id="admin">
                            <div class="userArea pt-2">
                                <i class="fa fa fa-user-circle-o font-44 mb-3"></i>
                                <p class="text-center bg-text" id="admin">Admin</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4  p-2">
                        <div class="elements bg-custom text-center" id="manager">
                            <div class="userArea pt-2">
                                <i class="fa fa-user-secret font-44 mb-3"></i>
                                <p class="text-center bg-text">Manager</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4  p-2">
                        <div class="elements bg-custom text-center" id="receptionist">
                            <div class="userArea pt-2">
                                <i class="fa fa-user-secret font-44 mb-3"></i>
                                <p class="text-center bg-text">Reception</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4  p-2">
                        <div class="elements bg-custom text-center" id="laboratory">
                            <div class="userArea pt-2">
                                <i class="mdi mdi-needle font-40"></i>
                                <p class="text-center bg-text">Laboratory</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- <div class="col-md-4  p-2">
                        <div class="elements bg-custom text-center" id="hospital">
                            <div class="userArea pt-2">
                                <i class="mdi mdi-hospital-building font-40"></i>
                                <p class="text-center bg-text">Hospital</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4  p-2">
                        <div class="elements bg-custom text-center" id="diagnostic">
                            <div class="userArea pt-2">
                                <i class="mdi mdi-nutrition font-40"></i>
                                <p class="text-center bg-text">Diagnostic</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4  p-2">
                        <div class="elements bg-custom text-center" id="laboratory">
                            <div class="userArea pt-2">
                                <i class="mdi mdi-needle font-40"></i>
                                <p class="text-center bg-text">Laboratory</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4  p-2">
                        <div class="elements bg-custom text-center" id="pharmacy">
                            <div class="userArea pt-2">
                                <i class="mdi mdi-pill font-40"></i>
                                <p class="text-center bg-text">Pharmacy</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4  p-2">
                        <div class="elements bg-custom text-center" id="doctor">
                            <div class="userArea pt-2">
                                <i class="fa fa-user-md font-44 mb-3"></i>
                                <p class="text-center bg-text">Doctors</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4  p-2">
                        <div class="elements bg-custom text-center" id="manager">
                            <div class="userArea pt-2">
                                <i class="fa fa-user-secret font-44 mb-3"></i>
                                <p class="text-center bg-text">Manager</p>
                            </div>
                        </div>
                    </div> --}}

                </div>
              
            </form>
          </div>
        </div>
      </section>







    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{asset('material')}}/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('material')}}/assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="{{asset('material')}}/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('material')}}/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="{{asset('material')}}/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="{{asset('material')}}/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="{{asset('material')}}/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="{{asset('material')}}/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('material')}}/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{{asset('material')}}/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script>
        function hitLogin(){
            $('#login').click();
        }
        $(document).ready(function () {
            $('#doctor').click(function(){
                $('#email').val('drgopal@andit.com');
                $('#password').val('123456');
                hitLogin();
            });
            $('#admin').click(function(){
                $('#email').val('admin@andit.com');
                $('#password').val('123456');
                hitLogin();
            });
            $('#diagnostic').click(function(){
                $('#email').val('diagnostic@andit.com');
                $('#password').val('123456');
                hitLogin();
            });
            $('#pharmacy').click(function(){
                $('#email').val('pharma@andit.com');
                $('#password').val('123456');
                hitLogin();
            });
            $('#hospital').click(function(){
                $('#email').val('hospital@andit.com');
                $('#password').val('123456');
                hitLogin();
            });
            $('#laboratory').click(function(){
                $('#email').val('lab@andit.com');
                $('#password').val('123456');
                hitLogin();
            });
            $('#manager').click(function(){
                $('#email').val('manager@andit.com');
                $('#password').val('123456');
                hitLogin();
            });
            $('#receptionist').click(function(){
                $('#email').val('receptionist@andit.com');
                $('#password').val('123456');
                hitLogin();
            });
            $(".login-form").validate({
                rules: {
                    field: {
                        required: true,
                        step: 10
                    },
                }, highlight: function (element) {
                    $(element).closest('.form-group').addClass('has-danger');
                    // $(element).closest('.form-control').addClass('form-control-danger');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-danger');
                    // $(element).closest('.form-group').addClass('has-success');
                },
                errorElement: 'div',
                errorClass: 'form-control-feedback',
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });
    </script>
</body>

</html>
