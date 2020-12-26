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
                        <form action="" method="get" class="form-inline float-right search">
                            <div class="form-group">
                                <label for="text">{{ __('messages.manufacturer')}} :</label>
                                <select name="manufacturer" class="form-control" id="manufacturer">
                                    <option value="All">All</option>
                                    <?php echo Pharma::getOptions($manufacturers,'manufacturer_name',$search['manufacturer'],'slug');?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="text">{{ trans_choice('messages.category',1)}} :</label>
                                <select name="category" class="form-control" id="category">
                                    <option value="All">All</option>
                                    <?php echo Pharma::getOptions($categories,'name',$search['category'],'slug');?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="text">{{ __('messages.unit')}} :</label>
                                <select name="unit" class="form-control" id="unit">
                                    <option value="All">All</option>
                                    <?php echo Pharma::getOptions($units,'unit_name',$search['unit'],'slug');?>
                                </select>
                            </div>
                            <div class="form-group">
                                <a class="btn search-btn-reset" href="{{url('stocks/closing')}}"><i class="fa fa-refresh"></i></a>
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
                                        <th width="50" class="text-center">{{__('SL')}}</th>
                                        <th>{{__('Name of Item')}}</th>
                                        {{-- <th>{{__('Manufacturer')}}</th>
                                        <th>{{__('Category')}}</th> --}}
                                        <th class="text-right" width="150">{{__('In Stock')}}</th>
                                        <th class="text-left" width="50">{{__('Unit')}}</th>
                                        <th class="text-right" width="150">{{__('Price')}}</th>
                                        {{-- <th class="text-right">{{__('MRP Price')}}</th> --}}
                                        <th class="text-right" width="150">{{__('Value')}}</th>
                                    </tr>
                                    </thead>
                            
                                    <tbody>
                                    <?php $i = 0;?>
                                    @foreach($products as $pro)
                                    <tr>
                                        <td class="text-center">{{sprintf('%02d',++$i)}}</td>
                                        <td><a href="{{url('products/product/'.$pro->slug)}}">{{$pro->title}}</a> -<small class="text-muted">{{$pro->generic_name}}</small></td>
                                        {{-- <td>{{$pro->manufacturer->manufacturer_name}}</td>
                                        <td>{{$pro->category->name}}</td> --}}
                                        <td class="text-right">{{$pro->stock}}</td>
                                        <td class="text-left">{{$pro->unit->unit_name}}</small></td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($pro->purchase_price)}}</td>
                                        <td class="text-right Tcurrent_val">{{Pharma::amountFormatWithCurrency($pro->purchase_price * $pro->stock)}}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <td colspan="5" class="text-right font-weight-bold">Total:</td>
                                        <td class="text-right font-weight-bold" id="Tcurrent_val"></td>
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
    $('#manufacturer,#category,#unit').change(function(){
        var url = "{{url('stocks/closing')}}";
        var manufacturer = $('#manufacturer').val();
        var category = $('#category').val();
        var unit = $('#unit').val();
        window.location.assign(url+"?manufacturer="+manufacturer+"&category="+category+"&unit="+unit);
    });

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
            v = v[1].replace(/,/g ,'');
            if(isNaN(v)){ v = $(this).text();}
            Tcurrent_val = parseFloat(Tcurrent_val) + parseFloat(v);
        });
        $('#Tcurrent_val').text('{{Pharma::getCurrency()}} '+parseFloat(Tcurrent_val).toFixed(2));
    }

</script>
@endpush