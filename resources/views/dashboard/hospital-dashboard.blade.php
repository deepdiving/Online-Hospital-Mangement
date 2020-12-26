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
                        <h3 class="m-b-0 font-light">{{Pharma::amountFormatWithCurrency($TotalBillAmount)}}</h3>
                        <h5 class="text-muted m-b-0">Total Admission Bill Amount</h5></div>
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
                        <h3 class="m-b-0 font-lgiht">{{Pharma::amountFormatWithCurrency($TotalDue)}}</h3>
                        <h5 class="text-muted m-b-0">Total Admission Due</h5></div>
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
                        <h3 class="m-b-0 font-lgiht">{{Pharma::amountFormatWithCurrency($TotalExpense)}}</h3>
                        <h5 class="text-muted m-b-0">Total Expense</h5></div>
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
                        <h3 class="m-b-0 font-lgiht">{{$TodayBillCount}}</h3>
                        <h5 class="text-muted m-b-0">#Invoice Today</h5></div>
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
                <h4 class="card-title text-themecolor">Admission History</h4>
                <h6 class="card-subtitle">Last 30 Days Admission History</h6>
                <div id="bar-chart" style="width:100%; height:365px;"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-xlg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <div>
                        <h3 class="card-title text-themecolor">Receive</h3>
                        <h6 class="card-subtitle">{{ __('messages.graph_char_year') }};</h6>
                    </div>
                    <div class="ml-auto align-self-center">
                        <ul class="list-inline m-b-0">
                            <li>
                                <h6 class="" style="color:#EC2B58"><i class="fa fa-circle font-10 m-r-10"></i>{{ __('messages.receive_amount') }}</h6>
                            </li>

                        </ul>
                    </div>

                </div>
                <div class="campaign ct-charts"></div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <!-- Column -->
    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-themecolor">Transaction</h4>
                <h6 class="card-subtitle">last 10 Transaction</h6>
                <div class="table-responsive">
                    <table class="table stylish-table">
                        <thead>
                            <tr>
                                <th width="50">#SL</th>
                                <th width="150">Trans Id</th>
                                <th width="150">Type</th>
                                <th width="120" class="text-right">Amount</th>
                                <th>Narration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0 @endphp
                            @forelse($last10Trans as $trans)
                            <tr>
                                <td>{{sprintf('%02d',++$i)}}</td>
                                <td>{{$trans->trans_id}}</td>
                                <td>{{$trans->transaction_type}}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($trans->amount)}}</td>
                                <td>{!!$trans->description!!}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">No Transaction</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-themecolor">Bills</h4>
                <h6 class="card-subtitle">last 10 Bill history</h6>
                <div class="table-responsive">
                    <table class="table stylish-table">
                        <thead>
                            <tr>
                                <th width="50">#SL</th>
                                <th width="150">Invoice</th>
                                <th width="120" class="text-right">Amount</th>
                                <th>Patient</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0 @endphp
                            @forelse($last10Bills as $bill)
                            <tr>
                                <td>{{sprintf('%02d',++$i)}}</td>
                                <td>{{$bill->invoice}}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($bill->grand_total)}}</td>
                                <td>{{$bill->patient->patient_name}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">No Transaction</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    {{-- <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-themecolor">{{ __('messages.upco_ex_date') }}</h4>
                <h6 class="card-subtitle">{{ __('messages.medi_with_ex_da') }}.</h6>
                <div class="table-responsive">
                    <table class="table stylish-table">
                        <thead>
                            <tr>
                                <th>{{ __('messages.batch_id') }}</th>
                                <th colspan="2" class="text-center">{{ __('messages.stock') }}</th>
                                <th>{{ __('messages.ex_date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ExpMedicine as $item)
                            <tr>
                                <td>
                                    <h6><a href="{{url('products/product/'.$item->product->slug)}}" class="link">{{$item->product->title}}</a>
                                    </h6><small class="text-muted">{{strtoupper($item->batch_number)}} </small>
                                </td>
                                <td class="text-right"><h5 class="{{($item->in_stock<=0)?'text-danger':''}}">{{$item->in_stock}}</h5></td>
                                <td><small>{{ucfirst($item->product->unit->unit_name)}}</small></td>
                                <td>
                                    <h5>{{date('M d, Y',strtotime($item->expiry_date))}}</h5></td>
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
    </div> --}}
    
</div>

@push('css')
<link href="{{ asset('material') }}/assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
<link href="{{ asset('material') }}/assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
<link href="{{ asset('material') }}/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
<!--This page css - Morris CSS -->
<link href="{{ asset('material') }}/assets/plugins/c3-master/c3.min.css" rel="stylesheet">
 <style>
     /* Use this selector to override the line style on a given series */
.ct-series-a .ct-line {
  /* Set the colour of this series line */
  stroke: #EC2B58 !important;
}
.ct-series-b .ct-line {
  /* Set the colour of this series line */
  stroke: #6C10B1 !important;
}
.ct-series-a .ct-point {
  stroke: #EC2B58 !important;
  stroke-width: 20px;
}
.ct-series-b .ct-point {
  stroke: #6C10B1 !important;
  stroke-width: 20px;
}
/* #bar-chart-2 .ct-bar:nth-of-type(4n+1) {
  stroke: #FC4B6C;
}

#bar-chart-2 .ct-bar:nth-of-type(4n+2) {
  stroke: #FFB22B;
}

#bar-chart-2 .ct-bar:nth-of-type(4n+3) {
  stroke: #26C6DA;
} */
 </style>
@endpush

@push('js')
<!-- chartist chart -->
<script src="{{ asset('material') }}/assets/plugins/chartist-js/dist/chartist.min.js"></script>
<script src="{{ asset('material') }}/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js">
</script>
<!--c3 JavaScript -->
<script src="{{ asset('material') }}/assets/plugins/d3/d3.min.js"></script>
<script src="{{ asset('material') }}/assets/plugins/c3-master/c3.min.js"></script>
<!-- Chart JS -->
{{-- <script src="{{ asset('material') }}/js/dashboard1.js"></script> --}}
<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
{{-- <script src="{{ asset('material') }}/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script> --}}


<script src="{{ asset('material') }}/assets/plugins/echarts/echarts-all.js"></script>

<script>

var chart = new Chartist.Line('.campaign', {
  labels: [<?php echo $lineData['label'];?>],
  series: [
    [<?php echo $lineData['receivedValue'];?>]
  ]
}, {
  low: 0,
  showArea: true,
  showPoint: true,
  fullWidth: false,
    plugins: [
        Chartist.plugins.tooltip()
    ],
});

chart.on('draw', function(data) {
  if(data.type === 'line' || data.type === 'area') {
    data.element.animate({
      d: {
        begin: 2000 * data.index,
        dur: 2000,
        from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
        to: data.path.clone().stringify(),
        easing: Chartist.Svg.Easing.easeOutQuint
      }
    });
  }
});
    
    
        // ============================================================== 
        // Pie Charts
        // ==============================================================
    
    
        var chart = c3.generate({
            bindto: '#visitor',
            data: {
                columns: [
                    ['Expenses', 0],
                    ['Purchases', 0],
                    ['Sales', 0],
                ],
                
                type : 'donut',
                onclick: function (d, i) { console.log("onclick", d, i); },
                onmouseover: function (d, i) { console.log("onmouseover", d, i); },
                onmouseout: function (d, i) { console.log("onmouseout", d, i); }
            },
            donut: {
                label: {
                    show: true
                },
                title: "Our visitor",
                width:60,
                
            },
    
            legend: {
            hide: false
            //or hide: 'data1'
            //or hide: ['data1', 'data2']
            },
            color: {
                pattern: ['#F02B54', '#A41C8A', '#670FB4']
            }
        });
    
    
    
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
                    name:'Sales Amount',
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
{{-- @include('layout.inc.right-sidebar') --}}

@endsection