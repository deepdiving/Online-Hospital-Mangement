@extends('layout.app',['pageTitle' => 'Product with low stock'])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('Low Stock Reports') }}
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
                                        <th width="50" class="text-center">{{__('SL')}}</th>
                                        <th>{{__('Name of Item')}}</th>
                                        <th>{{__('Manufacturer')}}</th>
                                        <th>{{__('Category')}}</th>
                                        <th class="text-right">{{__('Current Stock')}}</th>
                                        <th class="text-right">{{__('Purchase Price')}}</th>
                                        {{-- <th class="text-right">{{__('MRP Price')}}</th> --}}
                                        <th class="text-right">{{__('Current Value')}}</th>
                                    </tr>
                                    </thead>
                            
                                    <tbody>
                                    <?php $i = $Tcurrent_val= 0;?>
                                    @foreach($products as $pro)
                                    @php
                                        $Tcurrent_val += $pro->purchase_price * $pro->stock;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{sprintf('%02d',++$i)}}</td>
                                        <td><a href="{{url('products/product/'.$pro->slug)}}">{{$pro->title}}</a></td>
                                        <td>{{$pro->manufacturer->manufacturer_name}}</td>
                                        <td>{{$pro->category->name}}</td>
                                        <td class="text-right">{{$pro->stock}} <small>{{$pro->unit->unit_name}}</small></td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($pro->purchase_price)}}</td>
                                        <td class="text-right Tcurrent_val">{{Pharma::amountFormatWithCurrency($pro->purchase_price * $pro->stock)}}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <td colspan="6" class="text-right font-weight-bold">Total:</td>
                                        <td class="text-right font-weight-bold" id="Tcurrent_val"> {{Pharma::amountFormatWithCurrency($Tcurrent_val)}}</td>
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
        var Tcurrent_val = 0;
        $(".Tcurrent_val").each(function(){
            var v = $(this).text().split('{{Pharma::getCurrency()}}');
            v = v[1];
            if(isNaN(v)){ v = $(this).text();}
            Tcurrent_val = parseFloat(Tcurrent_val) + parseFloat(v);
        });
        $('#Tcurrent_val').text('{{Pharma::getCurrency()}}'+parseFloat(Tcurrent_val).toFixed(2));
    }

</script>
@endpush --}}