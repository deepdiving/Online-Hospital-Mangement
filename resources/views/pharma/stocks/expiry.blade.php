@extends('layout.app',['pageTitle' => 'Upcoming Expiry Date'])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('Upcoming Expiry Items') }}
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="get" class="form-inline float-right search">
                        <div class="form-group">
                            <label for="text">{{ __('messages.expire_type')}} :</label>
                            <select name="expiry" class="form-control" id="expType">
                                <option value="upcoming" {{$expiry == 'upcoming'?'selected':''}}>Upcoming Expiry</option>
                                <option value="expired" {{$expiry == 'expired'?'selected':''}}>Already Expired</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-body">                   
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
                                        <th class="text-right">{{__('Expiry Date')}}</th>
                                    </tr>
                                    </thead>
                            
                                    <tbody>
                                    <?php $i =$Tcurrent_val= 0;?>
                                    @foreach($ExpMedicines as $batch)
                                    @php
                                        $val = $batch->product->purchase_price * $batch->in_stock;
                                        $Tcurrent_val += $val; 
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{sprintf('%02d',++$i)}}</td>
                                        <td><a href="{{url('products/product/'.$batch->product->slug)}}">{{$batch->product->title}}</a> <small class="text-muted">{{$batch->batch_number}}</small></td>
                                        <td>{{$batch->product->manufacturer->manufacturer_name}}</td>
                                        <td>{{$batch->product->category->name}}</td>
                                        <td class="text-right">{{$batch->in_stock}} <small>{{$batch->product->unit->unit_name}}</small></td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($batch->product->purchase_price)}}</td>
                                        <td class="text-right Tcurrent_val">{{Pharma::amountFormatWithCurrency($val)}}</td>
                                        <td class="text-right">{{Pharma::dateFormat($batch->expiry_date)}}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <td colspan="6" class="text-right font-weight-bold">Total:</td>
                                        <td class="text-right font-weight-bold" id="Tcurrent_val">{{Pharma::amountFormatWithCurrency($Tcurrent_val)}}</td>
                                        <td></td>
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
@push('js')
<script>
    $('#expType').change(function(){
        window.location.assign("{{url('stocks/expiry?expiry=')}}"+$(this).val());
    });

    // $(document).ready(function(){
    //     getTotalAmount();
    // });

    // $('div#dataTableNoPaging_filter input').on('keyup keypress change',function(){
    //     setTimeout(function(){
    //         getTotalAmount();
    //     },100);
    // });

    // function getTotalAmount(){
    //     var Tcurrent_val = 0;
    //     $(".Tcurrent_val").each(function(){
    //         var v = $(this).text().split('{{Pharma::getCurrency()}}');
    //         v = v[1];
    //         if(isNaN(v)){ v = $(this).text();}
    //         Tcurrent_val = parseFloat(Tcurrent_val) + parseFloat(v);
    //     });
    //     $('#Tcurrent_val').text('{{Pharma::getCurrency()}}'+parseFloat(Tcurrent_val).toFixed(2));
    // }

</script>
@endpush