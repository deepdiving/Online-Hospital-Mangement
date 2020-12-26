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
                    <div class="round round-lg align-self-center round-info"><i class="fa fa-shopping-cart"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-light">{{Pharma::amountFormatWithCurrency($TotalSale)}}</h3>
                        <h5 class="text-muted m-b-0">Total Sale</h5></div>
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
                    <div class="round round-lg align-self-center round-warning"><i class="fa fa-shopping-bag"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">{{Pharma::amountFormatWithCurrency($TotalPurchase)}}</h3>
                        <h5 class="text-muted m-b-0">Total Purchase</h5></div>
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
                    <div class="round round-lg align-self-center round-primary"><i class="fa fa-hospital-o"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">{{Pharma::amountFormatWithCurrency($TotalDiagonBill)}}</h3>
                        <h5 class="text-muted m-b-0">Total Diagnostic Bill</h5></div>
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
                    <div class="round round-lg align-self-center round-danger"><i class="fa fa-calendar"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">{{$TotalAppointmetn}}</h3>
                        <h5 class="text-muted m-b-0">Total Appointment</h5></div>
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
                    <div class="round round-lg align-self-center round-info"><i class="fa fa-file-word-o"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-light">{{$TotalPrescription}}</h3>
                        <h5 class="text-muted m-b-0">Total Prescription</h5></div>
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
                    <div class="round round-lg align-self-center round-warning"><i class="fa fa-bar-chart"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">{{$TotalLabReport}}</h3>
                        <h5 class="text-muted m-b-0">Total Laboratory Report</h5></div>
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
                    <div class="round round-lg align-self-center round-primary"><i class="fa fa-registered"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">{{$TotalAdmission}}</h3>
                        <h5 class="text-muted m-b-0">Total Admission</h5></div>
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
                    <div class="round round-lg align-self-center round-danger"><i class="fa fa-ambulance"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">{{$TotalEmergency}}</h3>
                        <h5 class="text-muted m-b-0">Total Emergency</h5></div>
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
                    <div class="round round-lg align-self-center round-info"><i class="fa fa-user-circle-o"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-light">{{$TotalPatient}}</h3>
                        <h5 class="text-muted m-b-0">Total Patient</h5></div>
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
                    <div class="round round-lg align-self-center round-warning"><i class="fa fa-credit-card"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">{{Pharma::amountFormatWithCurrency($TotalPayment)}}</h3>
                        <h5 class="text-muted m-b-0">Total Payment</h5></div>
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
                    <div class="round round-lg align-self-center round-primary"><i class="fa fa-dollar"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">{{Pharma::amountFormatWithCurrency($TotalReceive)}}</h3>
                        <h5 class="text-muted m-b-0">Total Received</h5></div>
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
                    <div class="round round-lg align-self-center round-danger"><i class="fa fa-user-md"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">{{$TotalDoctor}}</h3>
                        <h5 class="text-muted m-b-0">Total Doctor</h5></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>

<div class="row">
    <div class="col-lg-12 col-xlg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <div>
                        <h3 class="card-title text-themecolor">Transactions</h3>
                        <h6 class="card-subtitle">Graph Chart for all transaction on this year;</h6>
                    </div>
                    <div class="ml-auto align-self-center">
                        <ul class="list-inline m-b-0">
                            <li>
                                <h6 class="" style="color:#6C10B1"><i class="fa fa-circle font-10 m-r-10 "></i>{{ __('messages.payment_amount') }}</h6>
                            </li>
                            <li>
                                <h6 class="" style="color:#EC2B58"><i class="fa fa-circle font-10 m-r-10"></i>{{ __('messages.receive_amount') }}</h6>
                            </li>

                        </ul>
                    </div>

                </div>
                <div class="campaign ct-charts"> 
                </div>
            </div>
        </div>
    </div>
    

    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-themecolor">Overall Revenue</h3>
                <div id="bar-chart-2" style="width:100%; height:300px;"></div>
                <div class="card-body revenues">
                    <h6 class="text-success"><i class="fa fa-circle font-10 m-r-10 "></i>Admission : <span class="text-black"><a href="{{url('reports/sales?start='.date("Y-m-d").'&end='.date("Y-m-d").'&customer=All')}}">{{$TotalAdmission}}</a></span></h6>
                    <h6 class="text-warning"><i class="fa fa-circle font-10 m-r-10 "></i>Emergency : <span class="text-black"><a href="{{url('reports/sales?start='.date("Y-m-d").'&end='.date("Y-m-d").'&customer=All')}}">{{$TotalEmergency}}</a></span></h6>
                    <h6 class="text-danger"><i class="fa fa-circle font-10 m-r-10 "></i>Bed Charge : <span class="text-black"><a href="{{url('reports/sales?start='.date("Y-m-d").'&end='.date("Y-m-d").'&customer=All')}}">{{Pharma::amountFormatWithCurrency($TotalbedCharge)}}</a></span></h6>
                    <h6 class="text-danger"><i class="fa fa-circle font-10 m-r-10 "></i>Operation : <span class="text-black"><a href="{{url('reports/sales?start='.date("Y-m-d").'&end='.date("Y-m-d").'&customer=All')}}">{{Pharma::amountFormatWithCurrency($Totalotbill)}}</a></span></h6>
                    <h6 class="text-success"><i class="fa fa-circle font-10 m-r-10 "></i>Medicine Sale : <span class="text-black"><a href="{{url('reports/sales?start='.date("Y-m-d").'&end='.date("Y-m-d").'&customer=All')}}">{{Pharma::amountFormatWithCurrency($TotalSale)}}</a></span></h6>
                    <h6 class="text-warning"><i class="fa fa-circle font-10 m-r-10 "></i>Appointment : <span class="text-black"><a href="{{url('reports/sales?start='.date("Y-m-d").'&end='.date("Y-m-d").'&customer=All')}}">{{$TotalAppointmetn}}</a></span></h6>
                    <h6 class="text-danger"><i class="fa fa-circle font-10 m-r-10 "></i>Laboratory : <span class="text-black"><a href="{{url('reports/sales?start='.date("Y-m-d").'&end='.date("Y-m-d").'&customer=All')}}">{{$TotalLabReport}}</a></span></h6>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-lg-6 col-md-6"> 
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-themecolor">Today User Transactions</h4>
                <div class="table-respossive">
                    <table class="table stylish-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>User Name</th> 
                                <th>Payment</th>
                                <th>Receive</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0 ?>
                            @foreach($users as $row)
                            @if(!$row->inRole('doctor'))
                                @php 
                                    $payment = $receive = 0;
                                    foreach ($row->transaction as $trans){
                                        if($trans->transaction_type == 'Payment')
                                            $payment += $trans->amount;
                                        else if ($trans->transaction_type == 'Received')
                                            $receive += $trans->amount;
                                    }
                                @endphp
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>
                                    <td>{{$row->name}}</td> 
                                    <td>{{$payment}}</td>
                                    <td>{{$receive}}</td>
                                </tr> 
                                @endif
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6"> 
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-themecolor">Expences</h4>
                <h6 class="card-subtitle">Last 10 Expences List</h6>
                <div class="table-respossive">
                    <table class="table stylish-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>User Name</th> 
                                <th>Payment Type</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0 @endphp
                            @forelse($last10expence as $row)
                            <tr>
                                <td>{{sprintf('%02d',++$i)}}</td>
                                <td>{{$row->user->name}}</td>  
                                <td>{{ $row->payment_type }}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($row->amount)}}</td>
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

    <!-- Column -->
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-themecolor">Appointment</h4>
                <h6 class="card-subtitle">Last 10 Appointment List</h6>
                <div class="table-responsive">
                    <table class="table stylish-table">
                        <thead> 
                            <tr>
                                <th>Id</th>
                                <th>Patient Name</th>
                                <th>Invoice</th>
                                <th class="text-right">Amount</th>
                            </tr> 
                        </thead>
                        <tbody>
                            @php $i = 0 @endphp
                            @forelse($last10appoint as $row)
                            <tr>
                                <td>{{sprintf('%02d',++$i)}}</td>
                                <td>{{$row->patient->patient_name}}</td>  
                                <td>{{ $row->invoice }}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($row->grand_total)}}</td>
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
    <!-- Column -->
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-themecolor">Sales</h4>
                <h6 class="card-subtitle">Last 10 Sales List</h6>
                <div class="table-responsive">
                    <table class="table stylish-table">
                        <thead>
                            <tr>
                                <tr>
                                    <th>Id</th>
                                    <th>Patient Name</th>
                                    <th>Invoice</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0 @endphp
                            @forelse($last10sales as $row)
                            <tr>
                                <td>{{sprintf('%02d',++$i)}}</td>
                                <td>{{$row->patient->patient_name}}</td>  
                                <td>{{ $row->invoice }}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($row->grand_total)}}</td>
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

    <div class="col-lg-6 col-md-6"> 
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-themecolor">Emergency</h4>
                <h6 class="card-subtitle">Last 10 Emergency List</h6>
                <div class="table-respossive">
                    <table class="table stylish-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Patient Name</th>
                                <th>Invoice</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0 @endphp
                            @forelse($last10emergency as $row)
                            <tr>
                                <td>{{sprintf('%02d',++$i)}}</td>
                                <td>{{$row->patient->patient_name}}</td>  
                                <td>{{ $row->invoice }}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($row->grand_total)}}</td>
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
    <div class="col-lg-6 col-md-6"> 
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-themecolor">Diagonstic</h4>
                <h6 class="card-subtitle">Last 10 Diagnostic List</h6>
                <div class="table-respossive">
                    <table class="table stylish-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Patient Name</th> 
                                <th>Invoice</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0 @endphp
                            @forelse($last10diagnostic as $row)
                            <tr>
                                <td>{{sprintf('%02d',++$i)}}</td>
                                <td>{{$row->patient->patient_name}}</td>  
                                <td>{{ $row->invoice }}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($row->grand_total)}}</td>
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
</div>

@endsection
@push('css')
<link href="{{ asset('material') }}/assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
<link href="{{ asset('material') }}/assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
<link href="{{ asset('material') }}/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
<!--This page css - Morris CSS -->
<link href="{{ asset('material') }}/assets/plugins/c3-master/c3.min.css" rel="stylesheet">
 <style>
.revenues {
    margin-left: 140px;
    display: flex;
    justify-content: space-between;
}
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
#bar-chart-2 .ct-bar:nth-of-type(4n+1) {
  stroke: #FC4B6C;
}

#bar-chart-2 .ct-bar:nth-of-type(4n+2) {
  stroke: #FFB22B;
}

#bar-chart-2 .ct-bar:nth-of-type(4n+3) {
  stroke: #26C6DA;
}
.ct-label{
    font-weight: bold !important;
    font-style: italic !important;
}
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
    [<?php echo $lineData['receivedValue'];?>],
    [<?php echo $lineData['paymentValue'];?>]
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
    
    
    
    
    
    
    
    
new Chartist.Bar('#bar-chart-2', {
    labels: ['Admission :', 'Emergency :', 'Bed Charge :','Operation :', 'Medicine Sale :', 'Appointment :', 'Laboratory :'],
    series: [
        [{{$TotalAdmission}}, {{$TotalEmergency}}, {{$TotalbedCharge}},{{$Totalotbill}}, {{$TotalSale}}, {{$TotalAppointmetn}}, {{$TotalLabReport}}],
        [{{$TodayAdmission}}, {{$TodayEmergency}}, {{$TodaybedCharge}},{{$Todayotbill}}, {{$todaySale}}, {{$TodayAppointmetn}}, {{$TodaylLabReport}}],
    ]
}, {
  seriesBarDistance: 15,
  reverseData: true,
  horizontalBars: true,
  axisY: {
    offset: 60,
    scaleMinSpace: 20,
  },
  axisY: {
    offset: 150
  }
});
    
</script>

@endpush

