@extends('layout.app',['pageTitle' => 'Batch Wise Stock'])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('Stock in batch') }}
    @endslot
@endcomponent
<style>
.acolor {
    color: #67757c;
}
</style>
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <p class="d-inline">{{ __('messages.refresh_batch') }} {{$batchwithZero}}.</p>
                    <a href="{{url('stocks/batch/refresh')}}" class="btn btn-themecolor waves-effect float-right">{{ __('messages.refresh')}}</a>
                    {{-- <form action="" method="get" class="form-inline float-right search">
                        <div class="form-group">
                            <label for="text">Expiry Type :</label>
                            <select name="expiry" class="form-control" id="expType">
                                <option value="upcoming" {{$expiry == 'upcoming'?'selected':''}}>Upcoming Expiry</option>
                                <option value="expired" {{$expiry == 'expired'?'selected':''}}>Already Expired</option>
                            </select>
                        </div>
                    </form> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="Content">
                                <table class="table table-bordered table-hover Content" id="dataTableNoPagingDesc">
                                    <thead>
                                    <tr class="tableHead">
                                        <th width="50" class="text-center">{{__('SL')}}</th>
                                        <th>{{__('Name of Item')}}</th>
                                        <th>{{__('Batch Number')}}</th>
                                        <th class="text-left">{{__('Expiry Date')}}</th>
                                        <th class="text-right">{{__('In Stock')}}</th>
                                        <th class="text-right">{{__('MRP Price')}}</th>
                                        <th class="text-right">{{__('Total Value')}}</th>
                                    </tr>
                                    </thead>
                            
                                    <tbody>
                                    <?php $i = 0;?>
                                    @foreach($products as $pro)
                                    <tr class="font-bold" style="background:#ddd">
                                        <td>{{sprintf('%02d',++$i)}}</td>
                                        <td><a href="{{url('products/product/'.$pro->slug)}}" class="acolor">{{$pro->title}}</a></td>
                                        <td>-</td>
                                        <td class="text-left">-</td>
                                        <td class="text-right">{{$pro->stock}} <small>{{$pro->unit->unit_name}}</small></td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($pro->sale_price,'-')}}</td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($pro->sale_price * $pro->stock,'-')}}</td>
                                    </tr>
                                        @foreach($pro->batch as $batch)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-left">{{strtoupper($batch->batch_number)}}</td>
                                            <td>{{Pharma::dateFormat($batch->expiry_date)}}</td>
                                            <td class="text-right">{{$batch->in_stock}} <small>{{$pro->unit->unit_name}}</small></td>
                                            <td class="text-right">{{Pharma::amountFormatWithCurrency($pro->sale_price,'-')}}</td>
                                            <td class="text-right">{{Pharma::amountFormatWithCurrency($pro->sale_price * $batch->in_stock,'-')}}</td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    @include('elements.dataTableOne')
@endsection