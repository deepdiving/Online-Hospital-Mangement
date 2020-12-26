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
                    <div class="round round-lg align-self-center round-info"><i class="mdi mdi-scale-balance"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-light">#{{$NumPres}}</h3>
                        <h5 class="text-muted m-b-0">Number Of Prescription</h5></div>
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
                    <div class="round round-lg align-self-center round-warning"><i class="mdi mdi-cart-outline"></i></div>
                    <div class="m-l-10 align-self-center">
                    <h3 class="m-b-0 font-lgiht">#{{$NumDraftPres}}</h3>
                        <h5 class="text-muted m-b-0">Number Of Draft Prescription</h5></div>
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
                    <div class="round round-lg align-self-center round-primary"><i class="mdi mdi-bullseye"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">#{{$PreMedi}}</h3>
                        <h5 class="text-muted m-b-0">Pre Medicine</h5></div>
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
                        <h3 class="m-b-0 font-lgiht">#{{$Todayappoin}}</h3>
                        <h5 class="text-muted m-b-0">#Today's Appointment</h5></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-themecolor">Last 30 Day's Prescription</h4>
                <h6 class="card-subtitle">See Last Thirty Days Prescription Status</h6>
                <div id="bar-chart" style="width:100%; height:365px;"></div>
            </div>
        </div>
    </div>


</div>

<div class="row">
    <!-- Column -->
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-themecolor">Prescription</h4>
                <h6 class="card-subtitle">Last 10 Day's Prescription</h6>
                <div class="table-responsive">
                    <table class="table stylish-table">
                        <thead>
                            <tr>
                                <th width="150">Invoice</th>
                                <th width="150">Date</th>
                                <th width="120" >Patient Name</th>                              
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($Prescription as $row)
                            <tr>
                                <td><h6><a href="{{url('prescription/invoice/a4/'.$row->invoice)}}" class="link">{{$row->invoice}}</a></h6><small class="text-muted">{{strtoupper($row->generic_name)}} </small></td>
                                <td> {{date('M d, Y',strtotime($row->date))}}</h5></td>
                                <td>{{$row->patient->patient_name}}</td>
                             </tr>
                            @empty
                            <tr>
                                <td colspan="">{{ __('messages.no_medi_found') }}!</td>
                            </tr>
                            @endforelse
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
                <h4 class="card-title text-themecolor">Draft Prescription</h4>
                <h6 class="card-subtitle">Last 10 Day's Draft Prescription</h6>
                <div class="table-responsive">
                    <table class="table stylish-table">
                        <thead>
                            <tr>
                                <th width="150">Invoice</th>
                                <th width="150">Date</th>
                                <th width="120" >Patient Name</th>  
                            </tr>
                        </thead>                        
                            <tbody>
                                @forelse($DraftPres as $row)
                                <tr>
                                    <td><h6><a href="{{url('prescription/invoice/'.$row->id)}}" class="link">{{$row->invoice}}</a></h6><small class="text-muted">{{strtoupper($row->generic_name)}} </small></td>
                                    <td> <h5>{{date('M d, Y',strtotime($row->date))}}</h5></td>
                                    <td>{{$row->patient->patient_name}}</td>
                                 </tr>
                                @empty
                                <tr>
                                    <td colspan="">{{ __('messages.no_medi_found') }}!</td>
                                </tr>
                                @endforelse
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@push('css')
<link href="{{ asset('material') }}/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
@endpush

@push('js')

<script src="{{ asset('material') }}/assets/plugins/echarts/echarts-all.js"></script>

<script>

    

        // ==============================================================
        // Bar Charts
        // ==============================================================

    var myChart = echarts.init(document.getElementById('bar-chart'));
    // specify chart configuration item and data
        option = {
            tooltip : {
                trigger: 'axis'
            },
            toolbox: {
                show : true,
                feature : {
                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            color: ["#cb246f"],
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    data : [<?php echo $barData['BarItems'] ?>]
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    name:'Total Prescription',
                    type:'bar',
                    data:[{{$barData['Barvalue']}}],
                    markLine : {
                        data : [
                            {type : 'average', name : 'Average'}
                        ]
                    }
                }
            ]
        };
    // use configuration item and data specified to show chart
    myChart.setOption(option, true), $(function() {
        function resize() {
            setTimeout(function() {
                myChart.resize()
            }, 100)
        }
        $(window).on("resize", resize), $(".sidebartoggler").on("click", resize);
    });



    </script>

@endpush

@endsection
