@extends('layout.app',['pageTitle' => 'Item Wise P&L Reports'])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.item_wise_p&l') }}
    @endslot
@endcomponent
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
                                        <th width="50">{{__('messages.sl')}}</th>
                                        <th>{{__('messages.item_name')}}</th>
                                        <th class="text-right">{{__('messages.sale_qty')}}</th>
                                        <th class="text-right">{{__('messages.avg_purch')}}</th>
                                        <th class="text-right">{{__('messages.purch_value')}}</th>
                                        <th class="text-right">{{__('messages.avg_sale')}}</th>
                                        <th class="text-right">{{__('messages.sale_value')}}</th>
                                        <th class="text-right">{{__('messages.net_p_loss')}}</th>
                                    </tr>
                                    </thead>
                            
                                    <tbody>
                                    <?php $i = $tqty = $tpPrice = $tsPrice = $tpValue = $tsValue = $tpl = 0;?>
                                    @foreach($products as $pro)

                                    @php
                                        $qty    = $pro->saleItems->sum('sale_qty');
                                    @endphp
                                    @if($qty>0)
                                    @php                                        
                                        $pPrice = $pro->purchaseItems->avg('unit_price');
                                        $pPrice = (empty($pPrice))?$pro->purchase_price:$pPrice;
                                        $sPrice = $pro->saleItems->avg('unit_price');
                                        $sPrice = (empty($sPrice))?$pro->sale_price:$sPrice;
                                        $pValue = $qty * $pPrice;
                                        $sValue = $qty * $sPrice;
                                        $pl     = $sValue-$pValue;
                                        $tqty       += $qty; 
                                        $tpPrice    += $pPrice; 
                                        $tsPrice    += $sPrice; 
                                        $tpValue    += $pValue; 
                                        $tsValue    += $sValue; 
                                        $tpl        += $pl; 
                                    @endphp
                                    <tr>
                                        <td>{{sprintf('%02d',++$i)}}</td>
                                        <td><a href="{{url('products/product/'.$pro->slug)}}">{{$pro->title}}</a></td>
                                        <td class="text-right">{{$qty}} <small>{{$pro->unit->unit_name}}</small></td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($pPrice)}}</td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($pValue)}}</td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($sPrice)}}</td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($sValue)}}</td>
                                        <td class="text-right {{$pl<0 ? 'text-wraning':''}}">{{Pharma::amountFormatWithCurrency($pl)}}</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <td colspan="2" class="text-right font-weight-bold">Total:</td>
                                        <td class="text-right font-weight-bold">{{$tqty}}</td>
                                        <td class="text-right font-weight-bold">{{Pharma::amountFormatWithCurrency($tpPrice)}}</td>
                                        <td class="text-right font-weight-bold">{{Pharma::amountFormatWithCurrency($tpValue)}}</td>
                                        <td class="text-right font-weight-bold">{{Pharma::amountFormatWithCurrency($tsPrice)}}</td>
                                        <td class="text-right font-weight-bold">{{Pharma::amountFormatWithCurrency($tsValue)}}</td>
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
