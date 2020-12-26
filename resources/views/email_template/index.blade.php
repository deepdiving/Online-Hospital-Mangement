@extends('layout.app',['pageTitle' => __('Template Management')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.email_templates') }}
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline">{{ __('messages.template_list') }}</h4>
                    <h6 class="card-subtitle d-inline">{{ __('messages.all_template_li') }}..</h6>
                        <a class="btn float-right bg-theme text-light" href="{{route('emailtemplate.create')}}">{{ __('messages.new_template') }}</a>
                        <hr class="hr-borderd">
                    <div class="col-lg-12">   
                        <div class="Content">
                                <table class="table table-bordered table-hover Content" id="myTable">
                                    <thead>
                                    <tr class="themeThead">
                                        <th width="50">{{__('messages.sl')}}</th>
                                        <th style="width: 20%" >{{__('messages.template_name')}}</th>
                                        <th>{{__('messages.content')}}</th>
                                        <th>{{__('messages.slug')}}</th>
                                        <th width="100">{{__('messages.action')}}</th>
                                    </tr>
                                    </thead>
                            
                                    <tbody>
                                    <?php $i = 0;?>
                                    @foreach($templates as $tem)
                                        <tr>
                                            <td>{{sprintf('%02d',++$i)}}</td>
                                            <td>{{ $tem->name }}</td>
                                            <td>{{ strip_tags (Pharma::limit_text($tem->content,15))}}</td>
                                            <td>{{ $tem->slug}}</td>
                                            <td style="display: flex; justify-content: space-evenly;">
                                                <a class="btn waves-effect waves-light btn-xs btn-info" href="{{url('emailtemplate/'.$tem->slug)}}"><i class="fa fa-eye"></i></a>
                                                <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{url('emailtemplate/'.$tem->slug.'/edit')}}"><i class="fa fa-edit"></i></a>
                                                <form action="{{url('emailtemplate/'.$tem->slug)}}" method="post" style="margin-top:-2px" id="deleteButton{{$tem->id}}">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$tem->id}})"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </td>
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