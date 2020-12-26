@extends('layout.app',['pageTitle' => 'Referral Category'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Referral Category
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="col-md-7 d-inline-block">
            <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline">Referral Category</h4><br>

                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="dataTableNoPagingDesc">
                            <thead>
                                <tr class="themead">
                                    <th width="50">SL</th>
                                    <th> Name</th>
                                    <th> Price %</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i = 0;?>
                                @foreach($category as $row)
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>

                                    <td>
                                       {{ $row->cat_name }}
                                    </td>

                                    <td>
                                       {{ $row->price }}
                                    </td>

                                    <td style="display: flex; justify-content: space-evenly;">

                                    <a class="btn waves-effect waves-light btn-xs btn-info" href="{{  url('referral/category/'.$row->slug) }}"><i class="fa fa-eye"></i></a>

                                    <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('referral/category/'.$row->slug.'/edit') }}"><i class="fa fa-edit"></i></a>

                                    <form action="{{ url('referral/category/'.$row->slug) }}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
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
                    <h4 class="card-title">Referral Category</h4>
                    <h6 class="card-subtitle">Create New  Referral Category  </h6>

                    <form class="form-material m-t-40 form" action="{{ url('referral/category') }}" method="post">
                        @csrf
                        <div class="form-group row {{ $errors->has('cat_name') ? ' has-danger' : '' }}">
                            <label for="cat_name" class="col-sm-2 text-right control-label col-form-label">Name <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="cat_name" value="{{old('cat_name')}}" class="form-control" id="name" placeholder="Type Name" required autocomplete="off">
                                @include('elements.feedback',['field' => 'cat_name'])
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('price') ? ' has-danger' : '' }}">
                            <label for="price" class="col-sm-2 text-right control-label col-form-label">Price <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                            <div class="md-form input-group ">
                                <input type="number" name="price" value="0.00" class="form-control form-control-line" id="price"  autocomplete="off">
                                <div class="input-group-append "><span class="input-group-text md-addon">%</span></div>
                            </div>
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
