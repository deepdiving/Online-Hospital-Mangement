@extends('layout.app',['pageTitle' => __('User Management')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ __('messages.activity') }}
@endslot
@endcomponent

@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('messages.activity') }}</h4>
                <h6 class="card-subtitle">{{ __('messages.all_activity') }}..</h6>
                <hr class="hr-borderd">
                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="myTable">
                            <thead>
                                <tr class="themeThead">
                                    <th>{{__('messages.sl')}}</th>
                                    <th>{{__('messages.name')}}</th>
                                    <th>{{__('messages.module')}}</th>
                                    <th>{{__('messages.action')}}</th>
                                    <th>{{trans_choice('messages.note',1)}}</th>
                                    @if(Pharma::isAdmin())
                                        <th width="80">{{__('messages.action')}}</th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i = 0;?>
                                @foreach($data as $key)
                                <tr>
                                    <td>{{ sprintf('%02d',++$i)}}</td>
                                    <td>{{ $key->name}}</td>
                                    <td>{{ $key->module}}</td>
                                    <td>{{ $key->action}}</td>
                                    <td>{{ $key->notes}}</td>
                                    @if(Pharma::isAdmin())
                                    <td>
                                        <form action="{{url('users/activities/'.$key->id.'/delete')}}" id="deleteButton{{$key->id}}" method="GET">
                                            <button class="btn btn-danger" name="archive" type="submit" onclick="sweetalertDelete({{$key->id}})"><i class="fa fa-trash"></i></button>
                                        </form>
                                        {{-- <a class="btn waves-effect waves-light text-light btn-xs btn-danger delete"  data-id="{{url('users/activites/'.$key->id.'/delete')}}"
                                        id="delete" href="#"><i class="fa fa-trash"></i></a> --}}
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
    @include('elements.dataTableOne')
    @endsection
