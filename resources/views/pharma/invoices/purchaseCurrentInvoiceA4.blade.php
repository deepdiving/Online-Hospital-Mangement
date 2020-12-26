@extends('layout.app',['pageTitle' => $purchase->invoice])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.purchase') }}
    @endslot
@endcomponent
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div id="invoice">
                <div class="toolbar hidden-print" id="printSection">
                    <div class="text-right" id="buttontPlace">
                        <button id="printInvoice" class="btn btn-info print-window"><i class="fa fa-print"></i> {{ __('messages.print') }}</button>
                        <a href="{{ URL::previous() }}" class="btn btn-info"><i class="fa fa-angle-left"></i> {{ __('messages.back') }}</a>
                    </div>
                    <hr>
                </div>
                    <div class="invoice-box">
                        <div id="tablehight">
                            <tr class="top">
                                <td colspan="2">
                                    <table>
                                        <tr>
                                            <td width="30%">
                                                <img src="{{ !empty($siteInfo->logo)?asset(Storage::url($siteInfo->logo)) : asset('logo.png') }}" style="width:100px; height:auto">
                                            </td>
                                            <td width="30%" class="text-left">
                                                {{$purchase->manufacturer->manufacturer_name}}
                                                <br> {{$purchase->manufacturer->address}}
                                                <br> {{$purchase->manufacturer->phone}}
                                            </td>
                                            <td width="30%" class="text-left">
                                                Invoice #: 
                                                <br>{{$purchase->invoice}}
                                                <br> Date:  {{Pharma::dateFormat($purchase->date)}} {{Pharma::dateTimeFormat($purchase->created_at)}}
                                            </td >
                                            
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <table cellpadding="0" cellspacing="0" class="table-bordered">
                                <tr class="heading">
                                     <td class="text-center">{{ __('messages.sl') }}</td>
                                    <td class="table_context">{{ __('messages.item') }}</td>
                                    <td class="table_context">{{ __('messages.batch') }}#</td>
                                    <td class="table_context">{{ __('messages.ex_date') }}</td>
                                    <td class="table_context">{{ __('messages.qty') }}#</td>
                                    <td align="right">{{ __('messages.price_in') }}</td>
                                    <td align="right">{{ __('messages.total') }}</td>
                                </tr>
                                <?php $i = 0;?>
                                @foreach ($purchase->purchaseItems as $productList)
                                    <tr width=30>
                                        <td class="text-center">{{sprintf('%02d',++$i)}}</td>
                                        <td class="table_context">{{$productList->product->title}}</td>
                                        <td class="table_context">{{$productList->batch->batch_number}}</td>
                                        <td class="table_context">{{Pharma::dateFormat($productList->batch->expiry_date)}}</td>
                                        <td class="table_context">{{$productList->qty}} <small>{{$productList->product->unit->unit_name}}</small></td>
                                        <td align="right">{{Pharma::amountFormatWithCurrency($productList->unit_price)}}</td>
                                        <td align="right">{{Pharma::amountFormatWithCurrency($productList->total_price)}}</td>
                                    </tr>
                                @endforeach
                                <table id="total-balance" class="table" style="border-bottom-style: none!important;">
                                    <tr rowspan="">
                                        <td width="80%"></td>
                                        <td></td>
                                    </tr>
                                    <tr rowspan="">
                                        <td align="right">{{ __('messages.sub_total') }} :</td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($purchase->purchase_amount)}} </td>
                                    </tr>
                                    <tr>
                                        <td align="right">{{ __('messages.tax') }} (%{{$purchase->tax_percent}}) :</td>
                                        <td class="text-right"> {{Pharma::amountFormatWithCurrency($purchase->purchase_amount*$purchase->tax_percent/100)}}</td>
                                    </tr>
                                    <tr>
                                        <td align="right">{{ __('messages.total') }} :</td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($purchase->grand_total)}} </td>
                                    </tr>
                                    <tr>
                                        <td align="right">{{ __('messages.discount') }} :</td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($purchase->discount)}}</td>
                                    </tr>
                                    <tr>
                                        <td align="right">{{ __('messages.payable_amount') }} :</td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($purchase->payable_amount)}}</td>
                                    </tr>
                                </table>
                                <div class="inword">
                                    <span style="font-weight: bold;">{{ __('messages.in_word') }}</span>  :<?php echo Pharma::convertNumberToWord($purchase->payable_amount);?>
                                </div>
                            </table>
                            <div id="signature">
                                <table>
                                    <tr>
                                        <td>--------------------</td>
                                        <td class="text-right">--------------------</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('messages.authorised_by') }}</td>
                                        <td class="text-right">{{ __('messages.authorised_by') }}</td>
                                    </tr>
                                </table>
                            </div>
                        <div id="footer">
                            {{$siteInfo->site_name}} || {{$siteInfo->phone_number}} || {{$siteInfo->website}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('elements.print')

