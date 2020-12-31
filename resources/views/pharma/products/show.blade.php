@extends('layout.app',['pageTitle' => __('Medicine Details')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ __('messages.medicin') }}
@endslot
@endcomponent
@push('css')
<style>
    .badge {
        padding: 5px;
        font-size: 15px;
        border-radius: 0px;
    }

    .sub {
        font-size: 18px;
        font-weight: bold;
    }
</style>
@endpush
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ trans_choice('messages.medicin',1) }}</h4>
                <h6 class="card-subtitle">{{ __('messages.medic_detail') }}</h6>
                <hr class="hr-borderd">
                <div class="row pt-3">
                    <div class="col-md-4 text-right">
                        <img src="{{!empty($product->image)?asset(Storage::url($product->image)) : asset('default.png')}}" class="img-thumbnail" alt="">
                    </div>
                    <div class="col-md-8 text-left">
                        <h3 class="display-5 pt-1">{{$product->title}} <sub class="text-muted sub">{{$product->generic_name}}</sub></h3>
                        <p class="mt-4">{{ __('messages.purc_rate') }} : {{Pharma::amountFormatWithCurrency($product->purchase_price)}} | {{ __('messages.mrp') }} : {{Pharma::amountFormatWithCurrency($product->sale_price)}}
                        </p>
                        <p class="lead text-justify">{{$product->note}}</p>
                        <p>
                            {{-- <span class="badge bg-primary">Stock: {{$product->opening_stock}}
                            {{$product->unit->unit_name}} | {{$product->stock}} {{$product->unit->unit_name}}</span>
                            --}}
                            <span class="badge bg-info">{{ __('messages.shelf') }} {{$product->shelf_no}}</span>
                            <span class="badge bg-success">{{ __('messages.box_size') }} {{$product->box_size}}</span>
                            <span class="badge bg-warning"> <a href="{{url('products/category/'.$product->category->slug)}}" class="text-white"> {{ trans_choice('messages.category',1) }} {{$product->category->name}}</a></span>
                            <span class="badge bg-info"><a href="{{url('products/type/'.$product->type->slug)}}" class="text-white"> Type: {{$product->type->type_name}}</a></span>
                            <span class="badge bg-danger"><a href="{{url('products/type/'.$product->type->slug)}}" class="text-white"> {{$product->manufacturer->manufacturer_name}}</a></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('messages.openig_stock') }}</h4>
                <div class="row">
                    @if(Sentinel::hasAccess('batch-create'))
                    <div class="col-md-3">
                        <form class="form-material form" action="{{ route('batch.store') }}" method="post" id="addOpeningStock">
                            @csrf
                            <div class="form-group {{ $errors->has('stock') ? ' has-danger' : '' }}">
                                <label for="stock" class=" text-right control-label col-form-label">{{ __('messages.in_stock') }}<sup class="text-danger font-bold">*</sup> :</label>
                                <input type="number" name="stock" value="{{old('stock')}}" class="form-control" id="stock" placeholder="In Stock" required autocomplete="off">
                                @include('elements.feedback',['field' => 'stock'])
                            </div>
                            <div class="form-group {{ $errors->has('expiry_date') ? ' has-danger' : '' }}">
                                <label for="expiry_date" class="text-right control-label col-form-label">{{ __('messages.ex_date') }}<sup class="text-danger font-bold">*</sup> :</label>
                                <input type="text" class="form-control datepicker" name="expiry_date" value="{{date('d-m-Y')}}" id="expiry_date" required="" autocomplete="off">
                                @include('elements.feedback',['field' => 'expiry_date'])
                            </div>
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <div class="form-group m-b-0">
                                <button type="submit" class="btn btn-themecolor waves-effect float-right waves-light m-t-10">{{  __('messages.add_stock') }}</button>
                            </div>
                        </form>
                    </div>
                    @endif
                    <div class="col-md-9">
                        <table class="table table-bordered">
                            <thead class="bg-theme text-light font-weight-bold">
                                <tr>
                                    <th>{{ __('messages.batch_number') }}</th>
                                    <th colspan="2" class="text-center">{{ __('messsages.stock_quentity') }}</th>
                                    <th>{{ __('messages.ex_date') }}</th>
                                    @if(Sentinel::hasAccess('batch-destroy'))
                                        <th>{{ __('messages.action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="BatchProduct">
                                @foreach($batches as $batch)
                                <tr id="row{{$batch->id}}">
                                    <td>{{ strtoupper($batch->batch_number)}}</td>
                                    <td class="text-right">{{$batch->in_stock}}</td>
                                    <td><small>{{$product->unit->unit_name}}</small></td>
                                    <td>{{Pharma::dateFormat($batch->expiry_date)}}</td>
                                    @if(Sentinel::hasAccess('batch-destroy'))
                                    <td>
                                        @if($batch->purchase_item_id == 0)
                                            <button class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDeletes({{$batch->id}})"><i class="fa fa-trash-o"></i></button>
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
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('messages.purch_history') }}</h4>
                <table class="table table-bordered">
                    <thead class="bg-theme text-light font-weight-bold">
                        <tr>
                            <th>{{ __('messages.date') }}</th>
                            <th>{{ __('messages.invoice') }}</th>
                            <th>{{ __('messages.vendor_name') }}</th>
                            <th class="text-right">{{  __('messages.old_stock') }}</th>
                            <th class="text-right">{{ __('messages.quentity')}}</th>
                            <th class="text-right">{{  __('messages.unit_price')}}</th>
                            <th class="text-right">{{  __('messages.price_value') }}</th>
                            <th class="text-right">{{ __('messages.new_stock') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchaseItems as $item)
                        <tr>
                            <td>{{date('M d, Y',strtotime($item->purchase->date))}}</td>
                            <td><a href="#">{{$item->purchase->invoice}}</a></td>
                            <td>{{$item->purchase->manufacturer->manufacturer_name}}</td>
                            <td class="text-right">{{$item->was_stock}} <small>{{$product->unit->unit_name}}</small></td>
                            <td class="text-right">{{$item->qty}} <small>{{$product->unit->unit_name}}</small></td>
                            <td class="text-right">{{Pharma::amountFormatWithCurrency($item->unit_price)}}</td>
                            <td class="text-right">{{Pharma::amountFormatWithCurrency($item->total_price)}}</td>
                            <td class="text-right">{{$item->new_stock}} <small>{{$product->unit->unit_name}}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">{{ __('messages.no_purch') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('messages.sale_history') }}</h4>
                <table class="table table-bordered">
                    <thead class="bg-theme text-light font-weight-bold">
                        <tr>
                            <th>{{ __('messages.date') }}</th>
                            <th>{{ __('messages.invoice') }}</th>
                            <th>{{ __('messages.vendor_name') }}</th>
                            <th class="text-right">{{  __('messages.old_stock') }}</th>
                            <th class="text-right">{{ __('messages.quentity')}}</th>
                            <th class="text-right">{{  __('messages.unit_price')}}</th>
                            <th class="text-right">{{  __('messages.price_value') }}</th>
                            <th class="text-right">{{ __('messages.new_stock') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($saleItems as $item)
                        <tr>
                            <td>{{date('M d, Y',strtotime($item->sale->date))}}</td>
                            <td><a href="#">{{$item->sale->invoice}}</a></td>
                            <td>{{$item->sale->patient->patient_name}}</td>
                            <td class="text-right">{{$item->current_stock}} <small>{{$product->unit->unit_name}}</small>
                            </td>
                            <td class="text-right">{{$item->sale_qty}} <small>{{$product->unit->unit_name}}</small></td>
                            <td class="text-right">{{Pharma::amountFormatWithCurrency($item->unit_price)}}</td>
                            <td class="text-right">{{Pharma::amountFormatWithCurrency($item->total_price)}}</td>
                            <td class="text-right">{{$item->new_stock}} <small>{{$product->unit->unit_name}}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">{{ __('messages.no_sale') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('js')
<script src="{{ asset('js') }}/sweetalert.min.js"></script>
<script>
    $('#addOpeningStock').on('submit',function(e){
        e.preventDefault();
        const stock = parseFloat($('#stock').val())||0;
        if(stock>0){
            var newItem = '';
            $.ajax({
                type: "POST",
                url: "{{ route('batch.store') }}",
                data: $('#addOpeningStock').serialize(),
                dataType: "json",
                beforeSend: function(){
                    swal("Stock added Successed", {icon: "success",buttons: false,timer: 1000});
                },
                success: function (response) {
                    // console.log(response);
                    newItem += '<tr id="row'+response.id+'">';
                    newItem += '<td>'+response.batch_number+'</td>';
                    newItem += '<td class="text-right">'+response.in_stock+'</td>';
                    newItem += '<td><small>{{$product->unit->unit_name}}</small></td>';
                    newItem += '<td>'+response.expiry_date+'</td>';
                    newItem += '<td><button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDeletes('+response.id+')"><i class="fa fa-trash-o"></i></button></td>';
                    newItem += '</tr>';
                    $('#BatchProduct').show("slow", function() { $('#BatchProduct').append(newItem);});
                    $('#addOpeningStock')[0].reset();
                }
            });
        }
    });


    function sweetalertDeletes(id) {
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Delete the record!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            swal("Your record has been deleted!", {icon: "success",buttons: false,timer: 1000});
            $.ajax({
                type: "GET",
                url: "{{url('batch/delete')}}/"+id,
                data: "data",
                dataType: "text",
                success: function (response) {
                    console.log(response);
                    if(response === "OK"){
                        $('#row'+id).hide("slow", function() { $('#row'+id).remove();});
                    }else{
                        alert('Something is not right!');
                    }
                }
            });
        }
        });
    }
</script>
@endpush