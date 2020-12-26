@extends('layout.app',['pageTitle' => __('tax Management')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.tax_management') }}
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline">{{ __('messages.tax_list')}}</h4><br>
                    <h6 class="card-subtitle d-inline">{{ __('messages.all_tax_list')}}..</h6>
                    @if(Sentinel::hasAccess('tax-create'))
                        <a class="btn float-right bg-theme text-light" href="{{route('tax.create')}}">{{ __('messages.add_tax')}}</a>
                    @endif
                    <div class="col-lg-12">
                        <div class="Content">
                                <table class="table table-bordered table-hover Content" id="myTable">
                                    <thead>
                                    <tr class="themeThead">
                                        <th width="50">{{__('SL')}}</th>
                                        <th>{{__('Tax')}}</th>
                                        <th>{{__('Amount')}}</th>
                                        <th>{{__('Description')}}</th>
                                        <th>{{__('Status')}}</th>
                                        @if(Sentinel::hasAccess('tax-show') || Sentinel::hasAccess('tax-edit') || Sentinel::hasAccess('tax-destroy'))
                                            <th width="100">{{__('Action')}}</th>
                                        @endif
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php $i = 0;?>
                                    @foreach($taxs as $tax)
                                        <tr>
                                            <td>{{sprintf('%02d',++$i)}}</td>
                                            <td>
                                                {{ $tax->tax_name }}
                                            </td>
                                            <td>
                                                {{ $tax->tax_amount }}
                                            </td>
                                            <td>{{ Pharma::limit_text($tax->description,15)}}</td>
                                            <td>{{ $tax->status}}</td>
                                            @if(Sentinel::hasAccess('tax-show') || Sentinel::hasAccess('tax-edit') || Sentinel::hasAccess('tax-destroy'))
                                                <td style="display: flex; justify-content: space-evenly;">
                                                    @if(Sentinel::hasAccess('tax-show'))
                                                        <a class="btn waves-effect waves-light btn-xs btn-info" href="{{url('products/tax/'.$tax->slug)}}"><i class="fa fa-eye"></i></a>
                                                    @endif
                                                    @if(Sentinel::hasAccess('tax-edit'))
                                                        <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{url('products/tax/'.$tax->slug.'/edit')}}"><i class="fa fa-edit"></i></a>
                                                    @endif
                                                    @if(Sentinel::hasAccess('tax-destroy'))
                                                        <form action="{{url('products/tax/'.$tax->slug)}}" method="post" style="margin-top:-2px" id="deleteButton{{$tax->id}}">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$tax->id}})"><i class="fa fa-trash-o"></i></button>
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
