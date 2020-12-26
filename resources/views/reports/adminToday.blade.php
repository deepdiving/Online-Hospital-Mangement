@extends('layout.app',['pageTitle' => 'Income Statement'])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.sale_report') }}
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <form action="" method="get" class="form-inline float-right search">
                            <div class="form-group">
                                <label for="text">{{ __('messages.date_from') }}</label>
                                <input type="text" name="start" value="{{($data['start'] == '-') ? '-' : date('Y-m-d',strtotime($data['start']))}}" class="form-control datepickerDB">
                            </div>
                            <div class="form-group">
                                <label for="text">{{ __('messages.date_to') }}</label>
                                <input type="text" name="end" value="{{ ($data['end'] == '-') ? '-' : date('Y-m-d',strtotime($data['end']))}}" class="form-control datepickerDB">
                            </div>
                            <div class="form-group">
                                <button class="btn search-btn"><i class="fa fa-search"></i></button>
                                <a class="btn search-btn-reset" href="{{url('reports/admin-today')}}"><i class="fa fa-refresh"></i></a>
                                <button type="button" class="btn btn-success ml-3" style="padding: 10px 15px; border-radius:0px" onclick="invoiceprint()"> <i class="mdi mdi-printer"> </i> {{ __('messages.print') }} </button>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">                        
                        <div class="Content" id="printJS-form">
                            <div class="invoiceHead text-center">
                                <h2>Admin - {{$siteInfo->site_name}}</h2>
                                <h3>{{ __('messages.income_State')}}</h3>
                                <h4>{{ __('messages.from')}} <b>{{ ($data['start'] == '-') ? 'First' : date('dS M Y', strtotime($data['start']))}} </b> {{ __('messages.to')}} <b>{{ ($data['end'] == '-') ? 'Last' : date('dS M Y', strtotime($data['end']))}}</b></h4>
                            </div>
                            <table class="table table-bordered table-hover Content"  cellpadding="5" cellspacing="0">
                                <tr>
                                    <td class="font-weight-bold wd60percent">{{ __('messages.revenues_ganis') }}</td>
                                    <td class="font-weight-bold text-right wd15percent">{{ __('messages.total_amount')}}</td>
                                </tr>
                                <tr class="text-right">
                                    <td class="wd25percent">Diagnostic Bill Revenue : </td>
                                    <td class="wd15percent">{{Pharma::amountFormatWithCurrency($data['diagon_ravenu'])}}</td>
                                </tr>
                                <tr class="text-right">
                                    <td class="wd25percent">Appointment Revenue : </td>
                                    <td class="wd15percent">{{Pharma::amountFormatWithCurrency($data['appoint_revenu'])}}</td>
                                </tr>
                                <tr class="text-right">
                                    <td class="wd25percent">Admission Revenue : </td>
                                    <td class="wd15percent">{{Pharma::amountFormatWithCurrency($data['admission_revenu'])}}</td>
                                </tr>
                                <tr class="text-right">
                                    <td class="wd25percent">Bed Revenue : </td>
                                    <td class="wd15percent">{{Pharma::amountFormatWithCurrency($data['bed_revenu'] )}}</td>
                                </tr>
                                <tr class="text-right">
                                    <td class="wd25percent">Emergency Revenue : </td>
                                    <td class="wd15percent">{{Pharma::amountFormatWithCurrency($data['emergency_revenu'])}}</td>
                                </tr>
                                <tr class="text-right">
                                    <td class="wd25percent">Operation Revenue : </td>
                                    <td class="wd15percent">{{Pharma::amountFormatWithCurrency($data['operation_revenu'])}}</td>
                                </tr>
                                <tr class="text-right">
                                    <td class="wd25percent">Sales Revenue : </td>
                                    <td class="wd15percent">{{Pharma::amountFormatWithCurrency($data['sale_revenu'])}}</td>
                                </tr>
                                <tr class="text-right">
                                    <td class="wd25percent">{{ __('messages.getable_dues') }} : </td>
                                    <td class="wd15percent">{{Pharma::amountFormatWithCurrency($totalDues)}}</td>
                                </tr>
                                <tr class="text-right">
                                    <td class="wd25percent">{{ __('messages.due_collection') }} : </td>
                                    <td class="wd15percent">{{Pharma::amountFormatWithCurrency($totalDueColection)}}</td>
                                </tr>
                                <tr class="text-right">
                                    <td class="wd25percent">{{ trans_choice('messages.other',10) }} : </td>
                                    <td class="wd15percent">{{Pharma::amountFormatWithCurrency(0)}}</td>
                                </tr>
                                <tr style="border-top: 2px solid" class="text-right font-weight-bold">
                                    <td class="wd25percent">{{ __('messages.total_revenue') }} : </td> 
                                    <td class="wd15percent">{{Pharma::amountFormatWithCurrency( $tsales =  ($data['diagon_ravenu'] + $data['appoint_revenu'] + $data['admission_revenu']+ $data['emergency_revenu'] + $data['operation_revenu'] + $data['sale_revenu'] + $data['bed_revenu'] + $totalDues + $totalDueColection))}}</td> 
                                </tr> 
                            </table>
                            <table class="table table-bordered table-hover Content"  cellpadding="5" cellspacing="0">
                                <tr>
                                    <td class="font-weight-bold wd60percent">{{ __('messages.expense_losses') }}</td>
                                    <td class="font-weight-bold text-right wd15percent">{{ __('messages.total_amount') }}</td>
                                </tr>
                                 <tr class="text-right">
                                    <td class="wd25percent">Referral Payment : </td>
                                    <td class="wd15percent">{{Pharma::amountFormatWithCurrency($data['referral_payment'])}}</td>
                                </tr>
                                <tr class="text-right">
                                    <td class="wd25percent">Doctor Payment : </td>
                                    <td class="wd15percent">{{Pharma::amountFormatWithCurrency($data['doctor_payment'])}}</td>
                                </tr>
                                @php $total_exp = 0; @endphp
                                @foreach($data['expense'] as $exp)
                                    @php $total_exp +=$exp->amount; @endphp
                                     <tr class="text-right"> 
                                        <td class="wd25percent">{{ucfirst($exp->category->category_name)}} : </td>
                                    <td class="wd15percent">{{Pharma::amountFormatWithCurrency($exp->amount)}}</td>
                                    </tr>
                                @endforeach
                                <tr class="text-right">
                                    <td class="wd25percent">{{ trans_choice('messages.other',10) }} : </td>
                                    <td class="wd15percent">{{Pharma::amountFormatWithCurrency(0)}}</td>
                                </tr>
                                <tr style="border-top: 2px solid" class="text-right font-weight-bold">
                                    <td class="wd25percent">{{ __('messages.total_expence') }} : </td>
                                    <td class="wd15percent">{{Pharma::amountFormatWithCurrency($costOfSold = $total_exp + $data['referral_payment'] + $data['doctor_payment'])}}</td>
                                </tr>
                            </table>
                            <table class="table table-bordered table-hover Content"  cellpadding="5" cellspacing="0">
                                <tr>
                                    <td class="font-weight-bold wd60percent"></td>
                                    <td class="font-weight-bold text-right wd15percent">{{ __('messages.total_amount') }}t</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold wd60percent">{{ __('messages.net_income') }} : </td>
                                    <td class="text-right font-weight-bold wd15percent">{{Pharma::amountFormatWithCurrency($tsales - $costOfSold)}}</td>
                                </tr>
                            </table>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    @include('elements.dataTableOne')
@endsection
@push('css')
<style>
    .wd60percent{ width: 60%;}
    .wd15percent{ width: 15%;}
    .wd25percent{ width: 25%;}
</style>
@endpush
@push('js')
<script src='{{ asset('js') }}/print.js'></script>
<script>
    function invoiceprint(){
        $("#printJS-form").print({
            addGlobalStyles : true,
            stylesheet : "{{ asset('css') }}/print.css",
            // rejectWindow : true,
            noPrintSelector : "#printSection,#footer",
            // iframe : false,
            append : null,
            prepend : "#footer"
        });
    }   
</script>
@endpush
