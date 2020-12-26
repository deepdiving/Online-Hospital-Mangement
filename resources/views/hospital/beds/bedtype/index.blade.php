@extends('layout.app',['pageTitle' => __('messages.bed_type')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{__('messages.bed_type')}}
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="col-md-7 d-inline-block">
            <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline">{{__('messages.bed_type')}}</h4><br>

                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="dataTableNoPagingDesc">
                            <thead>
                                <tr class="themead">
                                    <th width="50">{{__('messages.sl')}}</th>
                                    <th>{{__('messages.bed_name')}}</th>   
                                    <th width="100">{{__('messages.action')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i = 0;?>
                               @foreach($beds as $bed)
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>
                                    <td>
                                        {{ $bed->name }}
                                    </td> 
                                    
                                    <td style="display: flex; justify-content: space-evenly;">
                                        
                                    <a class="btn waves-effect waves-light btn-xs btn-info" href="{{ url('hospital/beds/bedtype/'.$bed->slug) }}"><i class="fa fa-eye"></i></a>
                                       
                                        <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('hospital/beds/bedtype/'.$bed->slug.'/edit') }}"><i class="fa fa-edit"></i></a>
                                       
                                        <form action="{{ url('hospital/beds/bedtype/'.$bed->slug) }}" method="post" style="margin-top:-2px" id="deleteButton{{$bed->id}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$bed->id}})"><i class="fa fa-trash-o"></i></button>
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
    <div class="col-md-5 float-right">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{__('messages.bed_type')}}</h4>
                    <h6 class="card-subtitle">{{ __('messages.create_new') }} {{__('messages.bed_type')}}</h6>
                    
                    <form class="form-material m-t-40 form" action="{{ url('/hospital/beds/bedtype') }}" method="post">
                        @csrf
                        <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.name')}} <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="Bed type name" required autocomplete="off">
                                @include('elements.feedback',['field' => 'name'])
                            </div>
                        </div>   
                        <div class="form-group m-b-0 float-right"> 
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>      
</div>
</div>
@include('elements.dataTableOne')
@endsection
