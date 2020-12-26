@extends('layout.app',['pageTitle' => 'Doctor Department'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Doctor Department
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="col-md-7 d-inline-block">
            <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline">Doctor Department</h4><br>

                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="dataTableNoPagingDesc">
                            <thead>
                                <tr class="themead">
                                    <th width="50"> SL </th>
                                    <th> Department Name </th>
                                    <th> Description </th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i = 0;?>
                                @foreach($department as $row)
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>

                                    <td>
                                       {{ $row->dep_name }}
                                    </td>

                                    <td>
                                       {{ $row->description }}
                                    </td>

                                    <td style="display: flex; justify-content: space-evenly;">

                                    <a class="btn waves-effect waves-light btn-xs btn-info" href="{{  url('departments/'.$row->id) }}"><i class="fa fa-eye"></i></a>

                                    <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('departments/'.$row->id.'/edit') }}"><i class="fa fa-edit"></i></a>

                                    <form action="{{ url('departments/'.$row->id) }}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
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
                    <h4 class="card-title">Doctor Department</h4>
                    <h6 class="card-subtitle">Create New  Doctor Department  </h6>

                    <form class="form-material m-t-40 form" action="{{ url('departments') }}" method="post">
                        @csrf
                        <div class="form-group row {{ $errors->has('dep_name') ? ' has-danger' : '' }}">
                            <label for="dep_name" class="col-sm-2 text-right control-label col-form-label"> Name <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="dep_name" value="{{old('dep_name')}}" class="form-control" id="dep_name" placeholder="Type Name" required autocomplete="off">
                                @include('elements.feedback',['field' => 'dep_name'])
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                            <label for="description" class="col-sm-2 text-right control-label col-form-label">Describe <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="description" value="{{old('description')}}" class="form-control" id="description" placeholder="Type Name" required autocomplete="off">
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
