@extends('layout.app',['pageTitle' =>'Operation Service Name'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Operation Service
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="col-md-7 d-inline-block">
            <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline">Operation Service</h4><br>
                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="dataTableNoPagingDesc">
                            <thead>
                                <tr class="">
                                    <th width="50">SL</th>
                                    <th>Service Name</th>
                                    <th>Operation Type</th>
                                    <th>Price</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php $i = 0;?>
                               @foreach($services as $row)
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>
                                    <td>
                                        {{ $row->name }}
                                    </td>
                                    <td>
                                        {{ $row->category->name }}
                                    </td>
                                    <td>
                                        {{ $row->price }}
                                    </td>
                                    <td style="display: flex; justify-content: space-evenly;">
                                    <a class="btn waves-effect waves-light btn-xs btn-info" href="{{ url('hospital/operation/service/'.$row->id) }}"><i class="fa fa-eye"></i></a>  
                                    <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('hospital/operation/service/'.$row->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                    <form action="{{  url('hospital/operations/operationtypes/'.$row->id) }}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
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
                    <h4 class="card-title">Operation Service</h4>
                    <h6 class="card-subtitle">Create New Operation Service</h6>
                    <form class="form-material m-t-40 form" action="{{ route('service.store') }}" method="post">
                        @csrf
                        <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name" class="col-sm-3 text-right control-label col-form-label">{{__('messages.name')}} <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="service name " required autocomplete="off">
                                @include('elements.feedback',['field' => 'name'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('service_category_id') ? ' has-danger' : '' }}">
                            <label for="service_category_id" class="col-sm-3 text-right control-label col-form-label">{{trans_choice('messages.category',1)}}<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-9">
                                <select name="operation_type_id" class="form-control" id="operation_type_id" required autocomplete="off">
                                 <option value="" selected disabled>Select Operation Type</option>
                                 @foreach ($types as $row)
                                 <option value="{{ $row->id}}">{{ $row->name }}</option>
                                 @endforeach
                                </select>
                                @include('elements.feedback',['field' => 'operation_type_id'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('price') ? ' has-danger' : '' }}">
                            <label for="price" class="col-sm-3 text-right control-label col-form-label">{{__('messages.price_in')}} <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-9">
                                <input type="number" name="price" value="{{old('price')}}" class="form-control" id="price" placeholder="Price" required autocomplete="off">
                                @include('elements.feedback',['field' => 'price'])
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
