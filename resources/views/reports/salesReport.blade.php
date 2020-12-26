@extends('layout.app',['pageTitle' => 'Sales Reports'])
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
                                <input type="text" name="start" value="{{$search['start']}}" class="form-control datepickerDB">
                            </div>
                            <div class="form-group">
                                <label for="text">{{ __('messages.date_to') }}</label>
                                <input type="text" name="end" value="{{$search['end']}}" class="form-control datepickerDB">
                            </div>
                            <div class="form-group">
                                <label for="text">{{ trans_choice('messages.customer',1) }}</label>
                                <select name="customer" class="form-control">
                                    <option value="All">All</option>
                                    <?php echo Pharma::getOptions($customers,'patient_name',$search['customer'],'slug')?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn search-btn"><i class="fa fa-search"></i></button>
                                <a class="btn search-btn-reset" href="{{url('reports/sales')}}"><i class="fa fa-refresh"></i></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="Content">
                                <table class="table table-bordered table-hover Content" id="dataTableNoPaging">
                                    <thead>
                                    <tr class="tableHead">
                                        <th width="50">{{__('messages.sl')}}</th>
                                        <th>{{__('messages.date')}}</th>
                                        <th>{{__('messages.invoice')}}</th>
                                        <th>{{ trans_choice('messages.customer',1) }}</th>
                                        <th class="text-right">{{__('messages.sub_total')}}</th>
                                        <th class="text-right">{{__('messages.tax')}}</th>
                                        <th class="text-right">{{__('messages.discount')}}</th>
                                        <th class="text-right">{{__('messages.grand_total')}}</th>
                                        <th class="text-right">{{__('messages.net_amount')}}</th>
                                        <th class="text-right">{{__('messages.dues')}}</th>
                                    </tr>
                                    </thead>
                            
                                    <tbody>
                                    @php $i =$Tsub_total=$Ttotal_tax=$Tinvoice_discount=$Tgrand_total=$Tpaid_amount=$Tnew_balance= 0;@endphp
                                    @foreach($sales as $sale)
                                    @php 
                                        $Tsub_total         +=  $sale->sub_total;
                                        $Ttotal_tax         +=  $sale->total_tax;
                                        $Tinvoice_discount  +=  $sale->invoice_discount;
                                        $Tgrand_total       +=  $sale->grand_total;
                                        $Tpaid_amount       +=  $sale->paid_amount;
                                        $Tnew_balance       +=  $sale->new_balance;
                                    @endphp
                                    <tr>
                                        <td>{{sprintf('%02d',++$i)}}</td>
                                        <td>{{Pharma::dateFormat($sale->date)}}</td>
                                        <td><a href="" onClick="newWindow('{{url('sale/invoice/'.$sale->slug)}}')">{{$sale->invoice}}</a></td>
                                        <td>{{$sale->patient->patient_name}}</td>
                                        <td class="text-right Tsub_total">{{Pharma::amountFormatWithCurrency($sale->sub_total,'-')}}</td>
                                        <td class="text-right Ttax_amount">{{Pharma::amountFormatWithCurrency($sale->total_tax,'-')}}</td>
                                        <td class="text-right Ttotal_discount">{{Pharma::amountFormatWithCurrency($sale->invoice_discount,'-')}}</td>
                                        <td class="text-right Tgrand_total">{{Pharma::amountFormatWithCurrency($sale->grand_total,'-')}}</td>
                                        <td class="text-right Tpaid_amount">{{Pharma::amountFormatWithCurrency($sale->paid_amount,'-')}}</td>
                                        <td class="text-right Tdue">{{Pharma::amountFormatWithCurrency($sale->new_balance,'-')}}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <td colspan="4" class="text-right font-weight-bold">{{ __('messages.total') }}:</td>
                                        <td class="text-right font-weight-bold" id="Tsub_total">{{Pharma::amountFormatWithCurrency($Tsub_total)}}</td>
                                        <td class="text-right font-weight-bold" id="Ttax_amount">{{Pharma::amountFormatWithCurrency($Ttotal_tax)}}</td>
                                        <td class="text-right font-weight-bold" id="Ttotal_discount">{{Pharma::amountFormatWithCurrency($Tinvoice_discount)}}</td>
                                        <td class="text-right font-weight-bold" id="Tgrand_total">{{Pharma::amountFormatWithCurrency($Tgrand_total)}}</td>
                                        <td class="text-right font-weight-bold" id="Tpaid_amount">{{Pharma::amountFormatWithCurrency($Tpaid_amount)}}</td>
                                        <td class="text-right font-weight-bold" id="Tdue">{{Pharma::amountFormatWithCurrency($Tnew_balance)}}</td>
                                    </tfoot>
                            </table>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    @include('elements.dataTableOne')
@endsection
{{-- @push('js')
<script>
    $(document).ready(function(){
        getTotalAmount();
    });

    $('div#dataTableNoPaging_filter input').on('keyup keypress change',function(){
        setTimeout(function(){
            getTotalAmount();
        },100);
    });

    function getTotalAmount(){
        var Tsub_total = 0;
        var Ttax_amount = 0;
        var Tgrand_total = 0;
        var Tpaid_amount = 0;
        var Ttotal_discount = 0;
        var Tdue = 0;
        $(".Tsub_total").each(function(){
            var v = $(this).text().split('{{Pharma::getCurrency()}}');
            v = v[1];
            if(isNaN(v)){ v = $(this).text();}
            Tsub_total = parseFloat(Tsub_total) + parseFloat(v);
        });
        $(".Ttax_amount").each(function(){
            var v = $(this).text().split('{{Pharma::getCurrency()}}');
            v = v[1];
            if(isNaN(v)){ v = $(this).text();}
            Ttax_amount = parseFloat(Ttax_amount) + parseFloat(v);
        });
        $(".Ttotal_discount").each(function(){
            var v = $(this).text().split('{{Pharma::getCurrency()}}');
            v = v[1];
            if(isNaN(v)){ v = $(this).text();}
            Ttotal_discount = parseFloat(Ttotal_discount) + parseFloat(v);
        });
        $(".Tgrand_total").each(function(){
            var v = $(this).text().split('{{Pharma::getCurrency()}}');
            v = v[1];
            if(isNaN(v)){ v = $(this).text();}
            Tgrand_total = parseFloat(Tgrand_total) + parseFloat(v);
        });
        $(".Tpaid_amount").each(function(){
            var v = $(this).text().split('{{Pharma::getCurrency()}}');
            v = v[1];
            if(isNaN(v)){ v = $(this).text();}
            Tpaid_amount = parseFloat(Tpaid_amount) + parseFloat(v);
        });
        $(".Tdue").each(function(){
            var v = $(this).text().split('{{Pharma::getCurrency()}}');
            v = v[1];
            if(isNaN(v)){ v = $(this).text();}
            Tdue = parseFloat(Tdue) + parseFloat(v);
        });
        $('#Tsub_total').text('{{Pharma::getCurrency()}}'+parseFloat(Tsub_total).toFixed(2));
        $('#Ttax_amount').text('{{Pharma::getCurrency()}}'+parseFloat(Ttax_amount).toFixed(2));
        $('#Tgrand_total').text('{{Pharma::getCurrency()}}'+parseFloat(Tgrand_total).toFixed(2));
        $('#Tpaid_amount').text('{{Pharma::getCurrency()}}'+parseFloat(Tpaid_amount).toFixed(2));
        $('#Tdue').text('{{Pharma::getCurrency()}}'+parseFloat(Tdue).toFixed(2));
        $('#Ttotal_discount').text('{{Pharma::getCurrency()}}'+parseFloat(Ttotal_discount).toFixed(2));
    }

</script>
@endpush --}}