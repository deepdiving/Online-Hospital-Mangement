@extends('layout.app',['pageTitle' => __('Unit Management')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.unitegories') }}
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline">{{ __('messages.unit_list') }}</h4><br>
                    <h6 class="card-subtitle d-inline">{{ __('messages.all_unit') }}..</h6>
                    @if(Sentinel::hasAccess('unit-create'))
                        <a class="btn float-right bg-theme text-light" href="{{route('unit.create')}}">{{ __('messages.unit_new') }}</a>
                    @endif
                    <hr class="hr-borderd">
                    <div class="col-lg-12">
                        <div class="Content">
                                <table class="table table-bordered table-hover Content" id="myTable">
                                    <thead>
                                    <tr class="themeThead">
                                        <th width="50">{{__('SL')}}</th>
                                        <th>{{__('Unit')}}</th>
                                        <th>{{__('Description')}}</th>
                                        <th>{{__('Status')}}</th>
                                        @if(Sentinel::hasAccess('unit-show') || Sentinel::hasAccess('unit-edit') || Sentinel::hasAccess('unit-destroy'))
                                            <th width="100">{{__('Action')}}</th>
                                        @endif
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php $i = 0;?>
                                    @foreach($units as $unit)
                                        <tr>
                                            <td>{{sprintf('%02d',++$i)}}</td>
                                            <td>
                                                {{ $unit->unit_name }}
                                            </td>
                                            <td>{{ Pharma::limit_text($unit->description,15)}}</td>
                                            <td>{{ $unit->status}}</td>
                                            @if(Sentinel::hasAccess('unit-show') || Sentinel::hasAccess('unit-edit') || Sentinel::hasAccess('unit-destroy'))
                                                <td style="display: flex; justify-content: space-evenly;">
                                                    @if(Sentinel::hasAccess('unit-show'))
                                                        <a class="btn waves-effect waves-light btn-xs btn-info" href="{{url('products/unit/'.$unit->slug)}}"><i class="fa fa-eye"></i></a>
                                                    @endif
                                                    @if(Sentinel::hasAccess('unit-edit'))
                                                        <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{url('products/unit/'.$unit->slug.'/edit')}}"><i class="fa fa-edit"></i></a>
                                                    @endif
                                                    @if(Sentinel::hasAccess('unit-destroy'))
                                                        <form action="{{url('products/unit/'.$unit->slug)}}" method="post" style="margin-top:-2px" id="deleteButton{{$unit->id}}">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$unit->id}})"><i class="fa fa-trash-o"></i></button>
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
