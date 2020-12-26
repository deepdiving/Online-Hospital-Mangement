@extends('layout.app',['pageTitle' => __('messages.manufacturer_management')]) 
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.manufacturer') }}
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline">{{ __('messages.manufac_list') }}</h4>
                    @if(Sentinel::hasAccess('manufacturer-create'))
                        <a class="btn float-right bg-theme text-light" href="{{url('manufacturers/manufacturer/create')}}">{{ __('messages.new_manufa') }}</a>
                    @endif
                    <hr class="hr-borderd">
                    <div class="col-lg-12">
                        <div class="Content">
                                <table class="table table-bordered table-hover Content" id="myTable">
                                    <thead>
                                    <tr class="themeThead">
                                        <th width="50">{{__('messages.sl')}}</th>
                                        <th>{{__('messages.manufac_name')}}</th>
                                        <th>{{__('messages.phone')}}</th>
                                        <th>{{__('messages.address')}}</th>
                                        <th class="text-right">{{__('messages.balance')}}</th>
                                        <th>{{__('messages.status')}}</th>
                                        @if(Sentinel::hasAccess('manufacturer-show') || Sentinel::hasAccess('manufacturer-edit') || Sentinel::hasAccess('manufacturer-destroy'))
                                            <th width="100">{{__('messages.action')}}</th>
                                        @endif
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php $i = 0;?>
                                        @foreach($manufacturers as $manufacturer)
                                            <tr>
                                                <td>{{sprintf('%02d',++$i)}}</td>
                                                <td>
                                                    {{ $manufacturer->manufacturer_name }}
                                                </td>
                                                <td>
                                                    {{ $manufacturer->phone }}
                                                </td>
                                                    <td>{{ $manufacturer->address }}</td>
                                                <td class="text-right">
                                                    {{ Pharma::getManufacturerBalance($manufacturer->id)}}
                                                </td>
                                                <td>{{ $manufacturer->status}}</td>
                                                @if(Sentinel::hasAccess('manufacturer-show') || Sentinel::hasAccess('manufacturer-edit') || Sentinel::hasAccess('manufacturer-destroy'))
                                                    <td style="display: flex; justify-content: space-evenly;">
                                                        @if(Sentinel::hasAccess('manufacturer-show'))
                                                            <a class="btn waves-effect waves-light btn-xs btn-info" href="{{url('manufacturers/manufacturer/'.$manufacturer->slug)}}"><i class="fa fa-eye"></i></a>
                                                        @endif
                                                        @if(Sentinel::hasAccess('manufacturer-edit'))
                                                            <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{url('manufacturers/manufacturer/'.$manufacturer->slug.'/edit')}}"><i class="fa fa-edit"></i></a>
                                                        @endif
                                                        @if(Sentinel::hasAccess('manufacturer-destroy'))
                                                            <form action="{{url('manufacturers/manufacturer/'.$manufacturer->slug)}}" method="post" style="margin-top:-2px" id="deleteButton{{$manufacturer->id}}">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$manufacturer->id}})"><i class="fa fa-trash-o"></i></button>
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
