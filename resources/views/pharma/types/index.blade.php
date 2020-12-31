@extends('layout.app',['pageTitle' => __('Type Management')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.product_type') }}
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline">{{ __('messages.prod_type_list') }}</h4>
                    <h6 class="card-subtitle d-inline">{{ __('messages.all_type_list') }}..</h6>
                    @if(Sentinel::hasAccess('type-create'))
                        <a class="btn float-right bg-theme text-light" href="{{route('product_type.create')}}">{{ __('messages.new_prod_type') }}e</a>
                    @endif
                    <hr class="hr-borderd">
                    <div class="col-lg-12">   
                        <div class="Content">
                                <table class="table table-bordered table-hover Content" id="myTable">
                                    <thead>
                                    <tr class="themeThead">
                                        <th width="50">{{__('messages.sl')}}</th>
                                        <th style="width: 20%" >{{__('messages.name')}}</th>
                                        <th>{{__('messages.description')}}</th>
                                        <th width="150">{{__('messages.status')}}</th>
                                        @if(Sentinel::hasAccess('type-show') || Sentinel::hasAccess('type-edit') || Sentinel::hasAccess('type-destroy'))
                                            <th width="100">{{__('messages.action')}}</th>
                                        @endif
                                    </tr>
                                    </thead>
                            
                                    <tbody>
                                    <?php $i = 0;?>
                                    @foreach($types as $type)
                                        <tr>
                                            <td>{{sprintf('%02d',++$i)}}</td>
                                            <td>
                                                {{ $type->type_name }}
                                            </td>
                                            <td>{{ Pharma::limit_text($type->description,15)}}</td>
                                            <td>{{ $type->status}}</td>
                                            @if(Sentinel::hasAccess('type-show') || Sentinel::hasAccess('type-edit') || Sentinel::hasAccess('type-destroy'))
                                                <td style="display: flex; justify-content: space-evenly;">
                                                    @if(Sentinel::hasAccess('type-show'))
                                                        <a class="btn waves-effect waves-light btn-xs btn-info" href="{{url('products/product_type/'.$type->slug)}}"><i class="fa fa-eye"></i></a>
                                                    @endif
                                                    @if(Sentinel::hasAccess('type-edit'))
                                                        <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{url('products/product_type/'.$type->slug.'/edit')}}"><i class="fa fa-edit"></i></a>
                                                    @endif
                                                    @if(Sentinel::hasAccess('type-destroy'))
                                                        <form action="{{url('products/product_type/'.$type->slug)}}" method="post" style="margin-top:-2px" id="deleteButton{{$type->id}}">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$type->id}})"><i class="fa fa-trash-o"></i></button>
                                                        </form>
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