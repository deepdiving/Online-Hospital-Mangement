@extends('layout.app',['pageTitle' =>' Medicine Routine '])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Medicine Routine
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="col-md-7 d-inline-block">
            <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline">Medicine Routine</h4><br>
                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="dataTableNoPagingDesc">
                            <thead>
                                <tr class="">
                                    <th width="50">SL</th>
                                    <th>Medicine Type</th>  
                                    <th>Medicine Routine</th>                                                                                                      
                                    <th width="100">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php $i = 0;?>
                               @foreach($routine as $row)
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>
                                    <td>
                                        {{ $row->premedicinetype->name}}
                                    </td>
                                    <td>
                                        {{ $row->name }}
                                    </td>                                                                    
                                    <td style="display: flex; justify-content: space-evenly;">
                                    <a class="btn waves-effect waves-light btn-xs btn-info" href="{{ url('doctor/medicine/routine/'.$row->id) }}"><i class="fa fa-eye"></i></a>  
                                    <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('doctor/medicine/routine/'.$row->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                    <form action="{{  url('doctor/medicine/routine/'.$row->id) }}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$row->id}})"><i class="fa fa-trash-o"></i></button>
                                        </form>
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
                    <h4 class="card-title">Medicine Routine</h4>
                    <h6 class="card-subtitle">Create New Routine </h6>
                    <form class="form-material m-t-40 form" action="{{ url('doctor/medicine/routine') }}" method="post">
                        @csrf
                        <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name" class="col-sm-4 text-right control-label col-form-label">{{__('messages.name')}} <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="service name " required autocomplete="off">
                                @include('elements.feedback',['field' => 'name'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('pre_medicine_type_id') ? ' has-danger' : '' }}">
                            <label for="pre_medicine_type_id" class="col-sm-4 text-right control-label col-form-label">Medicine Type<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-8">
                                <select name="pre_medicine_type_id" class="form-control" id="pre_medicine_type_id" required autocomplete="off">
                                 <option value="" selected disabled>Select Medicine Type</option>
                                 @foreach ($type as $row)
                                 <option value="{{ $row->id}}">{{ $row->name }}</option>
                                 @endforeach
                                </select>
                                @include('elements.feedback',['field' => 'pre_medicine_type_id'])
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
