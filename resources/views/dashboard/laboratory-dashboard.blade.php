@extends('layout.app',['pageTitle' => __('Main Dashboard'),'activeMenu' => 'Event Organiser'])
@section('content')


@component('layout.inc.breadcrumb')
@slot('title')
{{ __('messages.dashboard') }}
@endslot
@endcomponent


<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<!-- Row -->
@include('elements.alert')
<div class="row">
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-info"><i class="mdi mdi-account-card-details"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-light">{{ $totalTest }}</h3>
                        <h5 class="text-muted m-b-0">Total Test</h5></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-warning"><i class="ti-layout-cta-left"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">{{$totalReport}}</h3>
                        <h5 class="text-muted m-b-0">Total Report</h5></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-primary"><i class="mdi mdi-reorder-horizontal"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">{{$todayReport}}</h3>
                        <h5 class="text-muted m-b-0">Today report</h5></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-danger"><i class="mdi mdi-library-books"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">{{$reportInvoice}}</h3>
                        <h5 class="text-muted m-b-0">#Invoice Today</h5></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div> 

<div class="row">
    <!-- Column -->
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-themecolor">Report List</h4>
                <h6 class="card-subtitle">Last 10 completed report list</h6>
                <div class="table-responsive">
                    <table class="table stylish-table">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Date</th>
                                <th>Patient Name</th>
                                <th class="text-center">#Id</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i =0 ?>
                            @foreach($lst10reports as $row)
                                <tr>
                                    <td>{{ sprintf("%02s",++$i) }}</td>
                                    <td>{{Pharma::dateFormat($row->date) }}</td>
                                    <td>{{ $row->patient->patient_name}}</td>
                                    <td>{{ $row->invoice }}</td>
                                </tr> 
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-themecolor">Upcoming Test List</h4>
                <h6 class="card-subtitle">Last 10 upcomming test</h6>
                <div class="table-responsive">
                    <table class="table stylish-table">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Expiry Date</th>
                                <th>Patient Name</th> 
                                <th>Test name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i =0 ?>
                            @foreach($lst10tests as $row)
                            <tr>
                                <td>{{ sprintf("%02s",++$i) }}</td>
                                <td>{{Pharma::dateFormat($row->date) }}</td>
                                <td>{{ $row->patient->patient_name}}</td> 
                                <td>{{$row->test->name}}</td>
                            </tr> 
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div> 

@endsection