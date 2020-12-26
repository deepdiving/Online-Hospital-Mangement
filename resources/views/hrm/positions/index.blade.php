@extends('layout.app',['pageTitle' =>'Position'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Position
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="col-md-7 d-inline-block">
            <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline">Position</h4><br>
                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="myTable">
                            <thead>
                                <tr class="">
                                    <th width="50">SL</th>
                                    <th>Position Name</th>  
                                    <th>Description</th>                                                                   
                                    <th width="100">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php $i = 0;?>
                               @foreach($positions as $row)
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>
                                    <td>
                                      {{ $row->name}}
                                    </td>
                                    <td>
                                        {{ $row->description }}
                                    </td>                                                                    
                                    <td style="display: flex; justify-content: space-evenly;">
                                    <a class="btn waves-effect waves-light btn-xs btn-info" href="{{ url('position/'.$row->id) }}"><i class="fa fa-eye"></i></a>  
                                    <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('position/'.$row->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                    <form action="{{  url('position/'.$row->id) }}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$row->id}})"><i class="fa fa-trash-o"></i></button>
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
                    <h4 class="card-title">Position Name</h4>
                    <h6 class="card-subtitle">Create New Position </h6>
                    <form class="form-material m-t-40 form" action="{{ route('position.store') }}" method="post">
                        @csrf
                        <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name" class="col-sm-4 text-right control-label col-form-label">{{__('messages.name')}} <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="Service name " required autocomplete="off">
                                @include('elements.feedback',['field' => 'name'])
                            </div>
                        </div> 
                        <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                            <label for="description" class="col-sm-4 text-right control-label col-form-label">Description <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-8">
                                <textarea name="description" class="form-control" rows="9" placeholder="{{__('messages.write_a_note')}}"></textarea>
                                @include('elements.feedback',['field' => 'description'])
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
