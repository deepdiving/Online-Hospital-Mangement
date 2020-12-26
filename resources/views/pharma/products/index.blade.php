@extends('layout.app',['pageTitle' => __('Medicine Management')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.medicin') }}
    @endslot
@endcomponent
<style>
table#example23 tr td {
    vertical-align: middle !important;
    padding: 0px 5px !important;
    /* border-color: #00000073; */
}
</style>
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title d-inline">{{ __('messages.medicin_list') }}</h4>
                    <h6 class="card-subtitle d-inline">{{ __('messages.all_medicine') }}..</h6>
                    @if(Sentinel::hasAccess('product-create'))
                        <a class="btn float-right bg-theme text-light" href="{{route('product.create')}}">{{__('messages.medicin_new')}}</a>
                    @endif
                    <hr class="hr-borderd">
                    <div class="col-lg-12">   
                        <div class="Content">
                                <table class="table table-bordered table-striped Content" id="example23">
                                    <thead>
                                    <tr class="themeThead">
                                        <th width="50" class="text-center">{{__('SL')}}</th>
                                        <th width="80">{{__('Image')}}</th>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Generic Name')}}</th>
                                        <th class="text-right">{{__('Stock')}}</th>
                                        <th class="text-right">{{__('Shelf No')}}</th>
                                        <th class="text-right">{{__('Purchase Rate')}}</th>
                                        <th class="text-right">{{__('MRP Rate')}}</th>
                                        @if(Sentinel::hasAccess('product-destroy'))
                                            <th width="100" class="text-center">{{__('Status')}}</th>
                                        @endif
                                        @if(Sentinel::hasAccess('product-show') || Sentinel::hasAccess('product-edit') || Sentinel::hasAccess('product-destroy'))
                                            <th width="120" class="text-center">{{__('Action')}}</th>
                                        @endif
                                    </tr>
                                    </thead>
                            
                                    <tbody>
                                    <?php $i = 0; setlocale(LC_MONETARY,"en_US"); ?>
                                    @foreach($products as $medicine)
                                        <tr>
                                            <td class="text-center">{{sprintf('%02d',++$i)}}</td>
                                            <td><img src="{{ !empty($medicine->image)?asset(Storage::url($medicine->image)) : asset('default.png')}}" alt="" style="width:80px"></td> 
                                            <td><a href="{{url('products/product/'.$medicine->slug)}}">{{ $medicine->title }}</a></td>
                                            <td>{{ $medicine->generic_name }}</td>
                                            <td class="text-right">{{ $medicine->stock }}</td>
                                            <td class="text-right">{{ $medicine->shelf_no }}</td>
                                            <td class="text-right">{{ Pharma::amountFormatWithCurrency($medicine->purchase_price)}}</td>
                                            <td class="text-right">{{ Pharma::amountFormatWithCurrency($medicine->sale_price)}}</td>
                                            @if(Sentinel::hasAccess('product-destroy'))
                                            <td class="text-center">
                                                <div class="switch">
                                                    <label><input type="checkbox" name="status{{$medicine->id}}" onchange="myStatus({{$medicine->id}})" {{$medicine->status == 'Active'?'checked':''}}><span class="lever switch-col-info"></span></label>
                                                </div>
                                            </td>
                                            @endif
                                            @if(Sentinel::hasAccess('product-show') || Sentinel::hasAccess('product-edit'))
                                                <td style="display: flex; justify-content: space-between; margin-top: 15px;">
                                                    <a class="btn waves-effect waves-light btn-xs btn-primary" href="{{url('products/product/barcode/'.$medicine->slug)}}"><i class="fa fa-barcode"></i></a>
                                                    @if(Sentinel::hasAccess('product-show'))
                                                        <a class="btn waves-effect waves-light btn-xs btn-info" href="{{url('products/product/'.$medicine->slug)}}"><i class="fa fa-eye"></i></a>
                                                    @endif
                                                    @if(Sentinel::hasAccess('product-edit'))
                                                        <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{url('products/product/'.$medicine->slug.'/edit')}}"><i class="fa fa-edit"></i></a>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
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
@push('js')
<script src="{{ asset('js') }}/sweetalert.min.js"></script>
<script>
    function myStatus(id){
        console.log(id);
        if($('input[name=status'+id+']').is(':checked')){
            changingStatus(id,'Active');
        } else {
            changingStatus(id,'Inactive');
        }
    }
    function changingStatus(id,status){
        $.ajax({
            type: "GET",
            url: "{{url('products/change-status')}}/"+id+"/"+status,
            data: "data",
            dataType: "text",
            beforeSend: function(){
                // $('#addSalesItem').css('opacity','.5');
            },
            success: function (response) {
                if(response === 'OK'){
                    swal("Item Status has been changed to "+status+"!", {icon: "success",buttons: false,timer: 1500});
                }
            }
        });
    }
</script>
@endpush