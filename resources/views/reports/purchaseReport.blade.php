@extends('layout.app',['pageTitle' => 'Purchase Reports'])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.purchase_report') }}
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
                                <label for="text">{{ __('messages.manufacturer') }}</label>
                                <select name="manufacturer" class="form-control">
                                    <option value="All">All</option>
                                    <?php echo Pharma::getOptions($manufacturers,'manufacturer_name',$search['manufacturer'],'slug')?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn search-btn"><i class="fa fa-search"></i></button>
                                <a class="btn search-btn-reset" href="{{url('reports/purchase')}}"><i class="fa fa-refresh"></i></a>
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
                                        <th>{{ __('messages.manufacturer') }}</th>
                                        <th class="text-right">{{__('messages.sub_total')}}</th>
                                        <th class="text-right">{{__('messages.tax')}}</th>
                                        <th class="text-right">{{__('messages.grand_total')}}</th>
                                        <th class="text-right">{{__('messages.discount')}}</th>
                                        <th class="text-right">{{__('messages.net_amount')}}</th>
                                    </tr>
                                    </thead>
                            
                                    <tbody>
                                    <?php $i = $Tpurchase_amount =$Ttax_percent =$Tgrand_total =$Tdiscount =$Tpayable_amount= 0;?>
                                    @foreach($purchases as $purchase)
                                    @php
                                        $Tpurchase_amount += $purchase->purchase_amount;
                                        $Ttax_percent += $purchase->tax_percent;
                                        $Tgrand_total += $purchase->grand_total;
                                        $Tdiscount += $purchase->discount;
                                        $Tpayable_amount += $purchase->payable_amount;
                                    @endphp
                                    <tr>
                                        <td>{{sprintf('%02d',++$i)}}</td>
                                        <td>{{Pharma::dateFormat($purchase->date)}}</td>
                                        <td><a href="" onClick="newWindow('{{url('purchase/invoice/'.$purchase->slug)}}')">{{$purchase->invoice}}</a></td>
                                        <td>{{$purchase->manufacturer->manufacturer_name}}</td>
                                        <td class="text-right Tsub_total">{{Pharma::amountFormatWithCurrency($purchase->purchase_amount,'-')}}</td>
                                        <td class="text-right Ttax_amount">{{Pharma::amountFormatWithCurrency($purchase->tax_percent,'-')}}</td>
                                        <td class="text-right Ttotal_discount">{{Pharma::amountFormatWithCurrency($purchase->grand_total,'-')}}</td>
                                        <td class="text-right Tgrand_total">{{Pharma::amountFormatWithCurrency($purchase->discount,'-')}}</td>
                                        <td class="text-right Tpaid_amount">{{Pharma::amountFormatWithCurrency($purchase->payable_amount,'-')}}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <td colspan="4" class="text-right font-weight-bold">{{__('messages.total')}}:</td>
                                        <td class="text-right font-weight-bold" id="Tsub_total">{{Pharma::amountFormatWithCurrency($Tpurchase_amount)}}</td>
                                        <td class="text-right font-weight-bold" id="Ttax_amount">{{Pharma::amountFormatWithCurrency($Ttax_percent)}}</td>
                                        <td class="text-right font-weight-bold" id="Ttotal_discount">{{Pharma::amountFormatWithCurrency($Tgrand_total)}}</td>
                                        <td class="text-right font-weight-bold" id="Tgrand_total">{{Pharma::amountFormatWithCurrency($Tdiscount)}}</td>
                                        <td class="text-right font-weight-bold" id="Tpaid_amount">{{Pharma::amountFormatWithCurrency($Tpayable_amount)}}</td>
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
        $('#Tsub_total').text('{{Pharma::getCurrency()}}'+parseFloat(Tsub_total).toFixed(2));
        $('#Ttax_amount').text('{{Pharma::getCurrency()}}'+parseFloat(Ttax_amount).toFixed(2));
        $('#Tgrand_total').text('{{Pharma::getCurrency()}}'+parseFloat(Tgrand_total).toFixed(2));
        $('#Tpaid_amount').text('{{Pharma::getCurrency()}}'+parseFloat(Tpaid_amount).toFixed(2));
        $('#Ttotal_discount').text('{{Pharma::getCurrency()}}'+parseFloat(Ttotal_discount).toFixed(2));
    }

</script>
@endpush --}}