<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('material')}}/assets/images/favicon.png">
    <title>Material Pro Admin Template - The Most Complete & Trusted Bootstrap 4 Admin Template</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('material')}}/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('material')}}/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{asset('material')}}/css/colors/blue.css" id="theme" rel="stylesheet">
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    {{-- {{dd($errors)}} --}}
     <?php $siteInfo = Pharma::getSiteInfo()?>
    <section id="wrapper">
        @if ($siteInfo->login_banar)
            <div class="login-register" style="background-image:url({{asset(Storage::url($siteInfo->reg_banar))}}">

        @else
            <div class="login-register" style="background-image:url({{asset('material')}}/assets/images/background/login-register.jpg);">
        @endif

            <div class="login-box card">
            <div class="card-body">
                <form class="form-horizontal form-material reg-form" id="loginform" action="{{route('process_register')}}" method="post">
                    @csrf
                    <h3 class="box-title m-b-20">Sign Up</h3>
                    @if (session($key ?? 'status'))
                        <div class="alert alert-{{session('class')}} alert-dismissible fade show" role="alert">
                            {{ session($key ?? 'status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="form-group">
                        <input class="form-control" name="first_name" type="text" required placeholder="First Name" autocomplete="off" value="{{ old('first_name') }}">
                       @include('elements.feedback',['field' => 'first_name'])
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="last_name" type="text" required placeholder="Last Name" autocomplete="off" value="{{ old('last_name') }}">
                        @include('elements.feedback',['field' => 'last_name'])
                     </div>
                    <div class="form-group ">
                       <input class="form-control" name="email" type="email" required placeholder="Email" autocomplete="off" value="{{ old('email') }}">
                       @include('elements.feedback',['field' => 'email'])
                    </div>
                    <div class="form-group ">
                       <input class="form-control" type="password" name="password" required placeholder="Password" autocomplete="off" value="{{ old('password') }}">
                       @include('elements.feedback',['field' => 'password'])
                    </div>
                    <div class="form-group">
                       <input class="form-control" type="password" name="rpassword" required placeholder="Confirm Password" autocomplete="off" value="{{ old('rpassword') }}">
                       @include('elements.feedback',['field' => 'rpassword'])
                    </div>
                    <div class="form-group">
                    <div class="checkbox checkbox-success p-t-0">
                        <input id="checkbox-signup" type="checkbox" name="terms" value="1">
                        <label for="checkbox-signup"> I agree to all <a href="{{route('404')}}" target="_blank">Terms</a></label>
                        @include('elements.feedback',['field' => 'terms'])
                    </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Sign Up</button>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            <p>Already have an account? <a href="{{url('login')}}" class="text-info m-l-5"><b>Sign In</b></a></p>
                        </div>
                    </div>
                </form>

            </div>
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
        $(document).ready(function(){
            $(".reg-form").validate({
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
