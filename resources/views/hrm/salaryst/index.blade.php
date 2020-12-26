@extends('layout.app',['pageTitle' => 'Salary Structure'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
HRM Salary Structure
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="col-md-7 d-inline-block">
            <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline"> Salary Structure </h4><br>

                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="dataTableNoPagingDesc">
                            <thead>
                                <tr class="themead">
                                    <th width="50">SL</th>                                   
                                    <th>Title</th>  
                                    <th>Type</th>  
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>                              
                                <?php $i = 0;?>
                                @foreach($salaryst as $row)
                                 <tr>
                                     <td>{{sprintf('%02d',++$i)}}</td>                                    
                                     <td>
                                        {{ $row->title  }}
                                    </td> 
                                    <td>
                                        {{ $row->type  }}
                                    </td> 
                                     
                                     <td style="display: flex; justify-content: space-evenly;">
                                     <a class="btn waves-effect waves-light btn-xs btn-info" href="{{ url('salary/structure/'.$row->id) }}"><i class="fa fa-eye"></i></a>    
                                     <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('salary/structure/'.$row->id.'/edit') }}"><i class="fa fa-edit"></i></a>  
                                     
                                     <form action="{{  url('salary/structure/'.$row->id) }}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
                                         @csrf
                                         @method('delete')
                                         <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$row->id}})"><i class="fa fa-trash-o"></i></button>
                                     </form>  
                                     </td> 
                                 </tr> 
                                 @endforeach
                            
                        </table>
                    </div>
                </div>
            </div>
        </div> 
    </div> 
    <div class="col-md-5 float-right">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Salary Structure </h4>
                    <h6 class="card-subtitle">Create New Salary Structure </h6>                   
                    <form class="form-material m-t-40 form" action="{{ url('salary/structure/') }}" method="post">
                        @csrf  
                        <div class="form-group row {{ $errors->has('title') ? ' has-danger' : '' }}">
                            <label for="title" class="col-sm-2 text-right control-label col-form-label">Title <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" value="{{old('title')}}" class="form-control" id="title" placeholder="Type Title" required autocomplete="off">
                                @include('elements.feedback',['field' => 'title'])
                            </div>
                        </div> 
                        <div class="form-group row {{ $errors->has('type') ? ' has-danger' : '' }}">
                            <label for="type" class="col-sm-2 text-right control-label col-form-label">Type <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <select name="type" class="form-control" id="type" required autocomplete="off">
                                 <option value="" selected disabled>Select salary Structure </option>                     
                                 <option value="Added">Added</option>
                                 <option value="Detuct">Detuct</option>                               
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


