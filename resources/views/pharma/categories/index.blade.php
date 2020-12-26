@extends('layout.app',['pageTitle' => __('messages.category_management')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.category_management') }}
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline">{{trans_choice('messages.category',10)}}</h4>
                    <h6 class="card-subtitle d-inline">{{__('messages.see_all')}} {{trans_choice('messages.category',10)}}</h6>
                    @if(Sentinel::hasAccess('category-create'))
                        <a class="btn float-right bg-theme text-light" href="{{route('category.create')}}">{{__('messages.new_category')}}</a>
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
                                        @if(Sentinel::hasAccess('category-show') || Sentinel::hasAccess('category-edit') || Sentinel::hasAccess('category-destroy'))
                                            <th width="100">{{__('messages.action')}}</th>
                                        @endif
                                    </tr>
                                    </thead>
                            
                                    <tbody>
                                    <?php $i = 0;?>
                                    @foreach($categories as $cat)
                                        <tr>
                                            <td>{{sprintf('%02d',++$i)}}</td>
                                            <td>
                                                @if($cat->parent_id!=0)
                                                    |_
                                                @endif
                                                {{ $cat->name }}
                                            </td>
                                            <td>{{ Pharma::limit_text($cat->description,15)}}</td>
                                            <td>{{ $cat->status}}</td>
                                            @if(Sentinel::hasAccess('category-show') || Sentinel::hasAccess('category-edit') || Sentinel::hasAccess('category-destroy'))
                                                <td style="display: flex; justify-content: space-evenly;">
                                                    @if(Sentinel::hasAccess('category-show'))
                                                        <a class="btn waves-effect waves-light btn-xs btn-info" href="{{url('products/category/'.$cat->slug)}}"><i class="fa fa-eye"></i></a>
                                                    @endif
                                                    @if(Sentinel::hasAccess('category-edit'))
                                                        <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{url('products/category/'.$cat->slug.'/edit')}}"><i class="fa fa-edit"></i></a>
                                                    @endif
                                                    @if(Sentinel::hasAccess('category-destroy'))
                                                        <form action="{{url('products/category/'.$cat->slug)}}" method="post" style="margin-top:-2px" id="deleteButton{{$cat->id}}">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$cat->id}})"><i class="fa fa-trash-o"></i></button>
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