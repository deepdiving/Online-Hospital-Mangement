@extends('layout.app',['pageTitle' => $sale->invoice])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        {{  __('messages.sale')  }}
    @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div id="invoice">
                <div class="toolbar hidden-print" id="printSection">
                    <div class="text-right" id="buttontPlace">
                        <button id="printInvoice" class="btn btn-info print-window"><i class="fa fa-print"></i> {{ __('messages.print') }}</button>
                        <a href="{{ URL::previous() }}" class="btn btn-info aa"><i class="fa fa-angle-left"></i> {{ __('messages.back') }}</a>
                    </div>
                    <hr>
                </div>
                    <div class="invoice-box">
                        <div id="tablehight">
                            <tr class="top">
                                <td colspan="2">
                                    <table style="margin-bottom: 35px;">
                                        <tr>
                                            <td width="30%">
                                                <img src="{{ !empty($siteInfo->logo)?asset(Storage::url($siteInfo->logo)) : asset('logo.png') }}" style="width:100px; height:auto">
                                            </td>
                                            <td>
                                                 @if ($sale->patient->patient_name != 'Walking Customer')
                                                    {{$sale->patient->patient_name}}
                                                    <br> {{$sale->patient->address}}
                                                    <br> {{$sale->patient->phone}}
                                                    <br> {{$sale->patient->email}}
                                                @else
                                                    {{$sale->patient->patient_name}}
                                                @endif
                                            </td>
                                            <td width="33%" class="text-left">
                                                {{ __('messages.invoice') }} #: 
                                                <br>{{$sale->invoice}}
                                                <br> {{ __('messages.date') }}:  {{Pharma::dateFormat($sale->date)}} {{Pharma::dateTimeFormat($sale->created_at)}}
                                            </td >
                                            
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <table cellpadding="0" cellspacing="0" class="table-bordered">
                                <tr class="heading">
                                    <td>{{ __('messages.sl') }}</td>
                                    <td>{{ __('messages.item') }}</td>
                                    <td class="table_context">{{ __('messages.ex_date') }}</td>
                                    <td class="text-center">{{ __('messages.qty') }}</td >
                                    <td class="text-right">{{ __('messages.unit_price') }}</td>
                                    <td class="text-right">{{ __('messages.discount') }}</td>
                                    <td align="right">{{ __('messages.total_price') }}</td>
                                </tr>
                                <?php $i = 0;?>
                                @foreach ($sale->saleItems as $productList)
                                    <tr width=30>
                                        <td class="text-center">{{sprintf('%02d',++$i)}}</td>
                                        <td>{{$productList->product->title}} </td>
                                        <td class="table_context">{{Pharma::dateFormat($productList->expiry_date)}}</td>
                                        <td class="text-center">{{$productList->sale_qty}} <small>{{$productList->product->unit->unit_name}} </small></td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($productList->unit_price)}}</td>
                                        <td class="text-right"> <i class="mdi mdi-minus-box-outline"></i> {{Pharma::amountFormatWithCurrency($productList->unit_price*$productList->sale_qty - $productList->total_price)}} <small>({{Pharma::amountFormatWithCurrency($productList->discount_percent)}}%)</small></td>
                                        <td align="right">{{Pharma::amountFormatWithCurrency($productList->total_price)}}</td>
                                    </tr>
                                @endforeach
                                <table id="total-balance" cellpadding="0" cellspacing="0" class="table" style="border-bottom-style: none!important;">
                                    <tr>
                                        <td colspan="6" align="right" width="80%">{{ __('messages.sub_total') }} :</td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($sale->sub_total)}} </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" align="right">{{ __('messages.invoice_discou') }} <i class="mdi mdi-minus-box-outline"></i> :</td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($sale->invoice_discount)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" align="right">{{ __('messages.tax') }} (%{{$sale->tax_percent}}) <i class="mdi mdi-plus-box-outline"></i> :</td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($sale->total_tax)}}</td>
                                    </tr>
                                    {{-- @if($sale->pre_balance > 0)
                                        <tr>
                                            <td colspan="6" align="right">Pre Due <i class="mdi mdi-plus-box-outline"></i> :</td>
                                            <td class="text-right">{{number_format($sale->pre_balance,2)}}</td>
                                        </tr>
                                    @endif --}}
                                    <tr style="border-top: 2px solid;">
                                        <td colspan="6" align="right">{{ __('messages.grand_total') }} :</td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($sale->grand_total)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" align="right">{{ __('messages.paid_amount') }} :</td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($sale->paid_amount)}}</td>
                                    </tr>
                                    @if($sale->new_balance > 0)
                                        <tr>
                                            <td colspan="6" align="right">{{ __('messages.due') }} :</td>
                                            <td class="text-right">{{Pharma::amountFormatWithCurrency($sale->grand_total - $sale->paid_amount)}}</td>
                                        </tr>
                                    @endif
                                </table>
                                <div class="inword">
                                    <span style="font-weight: bold;">{{ __('messages.in_word') }}</span>  :<?php echo Pharma::convertNumberToWord($sale->paid_amount);?>
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
@if(isset($_GET['print']))
@push('js')
<script>
    $(document).ready(function(){
        setTimeout(function(){
            $('#printInvoice').click()
        },1000);
    });
</script>
@endpush
@endif