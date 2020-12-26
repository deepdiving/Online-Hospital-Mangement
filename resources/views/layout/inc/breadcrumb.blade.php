<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Dashboard</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        @if(Pharma::isAdmin())
            <div class="">
                <button class="right-side-toggle waves-effect waves-light bg-theme btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
            </div>
        @endif
    </div>
</div>
