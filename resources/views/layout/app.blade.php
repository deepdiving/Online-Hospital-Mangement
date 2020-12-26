<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('material')}}/assets/images/favicon.ico">
    <title> {{session()->get('settings')[0]['site_name']}} | {{$pageTitle}}</title>
    <!-- Bootstrap Core CSS -->
    @stack('tostCSS')
    <link href="{{ asset('material') }}/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('material') }}/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{ asset('material') }}/css/colors/{{session()->get('settings')[0]['theme']}}.css" id="theme" rel="stylesheet">
    <link href="{{ asset('css') }}/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">


<!--[endif]-->
    @stack('css')
    
</head>



<body class="fix-header fix-sidebar card-no-border" id="body">
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
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        @if(!isset($noFooter))
            @if(Sentinel::getUser()->inRole('hospital'))
                @include('layout.inc.topbar.hospital-topbar')
            @elseif(Sentinel::getUser()->inRole('pharmacy'))
                @include('layout.inc.topbar.pharmecy-topbar')
            @elseif(Sentinel::getUser()->inRole('admin')) 
                @include('layout.inc.topbar.admin-topbar')  
            @elseif(Sentinel::getUser()->inRole('laboratory'))   
                @include('layout.inc.topbar.laboratory-topbar')
            @elseif(Sentinel::getUser()->inRole('diagnostic'))  
                @include('layout.inc.topbar.diagnostic-topbar')    
            @else    
                @include('layout.inc.topbar.topbar')
            @endif
        @endif
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        
        @if(Sentinel::getUser()->inRole('hospital'))
            @include('layout.inc.sidebar.hospital-sidebar')
        @elseif(Sentinel::getUser()->inRole('pharmacy'))
            @include('layout.inc.sidebar.pharma-sidebar')
        @elseif(Sentinel::getUser()->inRole('admin'))
            @include('layout.inc.sidebar.admin-sidebar')
        @elseif(Sentinel::getUser()->inRole('laboratory'))
            @include('layout.inc.sidebar.laboratory-sidebar')
        @elseif(Sentinel::getUser()->inRole('diagnostic'))
            @include('layout.inc.sidebar.diagnostic-sidebar')
        @elseif(Sentinel::getUser()->inRole('doctor'))
            @include('layout.inc.sidebar.doctor-sidebar')
        @elseif(Sentinel::getUser()->inRole('manager'))
            @include('layout.inc.sidebar.manager-sidebar')
        @else    
            @include('layout.inc.sidebar.sidebar')
        @endif
        
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                @yield('content')
            </div>
            @if(Pharma::isAdmin())
                @include('layout.inc.right-sidebar')
            @endif
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            @if(!isset($noFooter))
                <footer class="footer"> © {{date('Y')}} {{session()->get('settings')[0]['footer_text']}} </footer>
            @endif
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('material') }}/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('material') }}/assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="{{ asset('material') }}/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('material') }}/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="{{ asset('material') }}/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('material') }}/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="{{ asset('material') }}/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="{{ asset('material') }}/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('material') }}/js/custom.min.js"></script>
    <script src="{{ asset('js') }}/validator.js"></script>
    @include('elements.myjs')
    @stack('js')
    <script>
        $('#flash-overlay-modal').modal();
    </script>
    <script>
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>
    <script>
        $(document).ready(function () {
            $(".form").validate({
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
@if(isset($sidebarStyle) || session()->get('settings')[0]['mini_sidebar'] == 'mini-sidebar')
<script>
$(document).ready(function () {
    setTimeout(function(){
        $("body").trigger("resize");
        $(".scroll-sidebar, .slimScrollDiv").css("overflow-x","visible").parent().css("overflow", "visible");
        $("body").addClass("mini-sidebar");
        $(".navbar-brand span").hide();
    },50);
});
</script>
@endif
<script>
$('.sidebartoggler').click(function(){
    $.ajax({
        type: "GET",
        url: "{{url('togglesidebar')}}/",
        data: "data",
        dataType: "text",
        beforeSend: function(){},
        success: function (response) {
            console.log(response);
        }
    });
});


</script>
</body>

</html>
