@extends('layout.app',['pageTitle' => 'Sale Wise P&L Reports'])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.sale_wise_p&l') }}
    @endslot
@endcomponent
<?php //dd($sales);?>
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        
                        <div class="Content">
                                <table class="table table-bordered table-hover Content" id="dataTableNoPaging">
                                    <thead>
                                    <tr class="tableHead">
                                        <th width="50">{{ __('messages.sl') }}</th>
                                        <th>{{__('messages.sale_invoice')}}</th>
                                        <th class="text-right">{{__('messages.sale_qty')}}</th>
                                        <th class="text-right">{{__('messages.purch_value')}}</th>
                                        <th class="text-right">{{__('messages.sale_value')}}</th>
                                        <th class="text-right">{{__('messages.net_p_loss')}}</th>
                                    </tr>
                                    </thead>
                            
                                    <tbody>
                                    <?php $i = $tPurchase = $tqty = $tSale = $tpl = 0;?>
                                    @foreach($sales as $sale)
                                        @php
                                        $invoicePurchaseValue = $invoiceSaleValue = 0;
                                        foreach($sale->saleItems as $item){
                                            $pPrice = $item->product->purchaseItems->avg('unit_price');
                                            $pPrice = (empty($pPrice))?$item->product->purchase_price:$pPrice;
                                            $invoicePurchaseValue += $item->sale_qty * $pPrice;
                                            $invoiceSaleValue += $item->sale_qty * $item->unit_price;
                                        }
                                            $qty        = $sale->saleItems->sum('sale_qty');
                                            $pl         = $invoiceSaleValue-$invoicePurchaseValue;
                                            $tqty       += $qty;
                                            $tpl        += $pl;
                                            $tPurchase  += $invoicePurchaseValue;
                                            $tSale      += $invoiceSaleValue;
                                        @endphp
                                        <tr>
                                            <td>{{sprintf('%02d',++$i)}}</td>
                                            <td><a href="{{url('sale/invoice/'.$sale->slug)}}">{{$sale->invoice}}</a></td>
                                            <td class="text-right">{{$qty}}</td>
                                            <td class="text-right">{{Pharma::amountFormatWithCurrency($invoicePurchaseValue)}}</td>
                                            <td class="text-right">{{Pharma::amountFormatWithCurrency($invoiceSaleValue)}}</td>
                                            <td class="text-right">{{Pharma::amountFormatWithCurrency($pl)}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <td colspan="2" class="text-right font-weight-bold">Total:</td>
                                        <td class="text-right font-weight-bold">{{$tqty}}</td>
                                        <td class="text-right font-weight-bold">{{Pharma::amountFormatWithCurrency($tPurchase)}}</td>
                                        <td class="text-right font-weight-bold">{{Pharma::amountFormatWithCurrency($tSale)}}</td>
                                        <td class="text-right font-weight-bold">{{Pharma::amountFormatWithCurrency($tpl)}}</td>
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
