@extends('layout.app',['pageTitle' => trans_choice('messages.bed',10)])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{trans_choice('messages.bed',10)}}
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="col-md-7 d-inline-block">
            <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline">{{trans_choice('messages.bed',10)}}</h4><br>
                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="dataTableNoPagingDesc">
                            <thead>
                                <tr class="">
                                    <th width="50">{{__('messages.sl')}}</th>
                                    <th>{{__('messages.bed_type')}}</th>
                                    <th>{{__('messages.price_in')}}</th>
                                    <th>{{__('messages.bed_no')}}</th>   
                                    <th width="100">{{__('messages.action')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i = 0;?>
                               @foreach($beds as $bed)
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>
                                    <td>
                                        {{ $bed->bedtype->name }}
                                    </td> 
                                    <td>
                                        {{ $bed->price }}
                                    </td> 
                                    <td>
                                        {{ $bed->bed_no }}
                                    </td>
                                    
                                    <td style="display: flex; justify-content: space-evenly;">
                                        
                                    <a class="btn waves-effect waves-light btn-xs btn-info" href="{{ url('hospital/beds/bed/'.$bed->slug) }}"><i class="fa fa-eye"></i></a>
                                       
                                        <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('hospital/beds/bed/'.$bed->slug.'/edit') }}"><i class="fa fa-edit"></i></a>
                                       
                                        <form action="{{ url('hospital/beds/bed/'.$bed->slug) }}" method="post" style="margin-top:-2px" id="deleteButton{{$bed->id}}">
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
                    <h4 class="card-title">{{trans_choice('messages.bed',10)}}</h4>
                    <h6 class="card-subtitle">{{ __('messages.create_new') }} {{trans_choice('messages.bed',10)}} </h6> 
                    <form class="form-material m-t-40 form" action="{{ url('/hospital/beds/bed') }}" method="post">
                        @csrf
                        <div class="form-group row {{ $errors->has('bed_type_id') ? ' has-danger' : '' }}">
                            <label for="test_category_id" class="col-sm-3 text-right control-label col-form-label">{{__('messages.bed_type')}}<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-9">
                                <select name="bed_type_id" class="form-control" id="bed_type_id" required autocomplete="off">
                                 <option value="" selected disabled>Select Bed Type</option>
                                 @foreach ($bedtype as $row)
                                 <option value="{{ $row->id}}">{{ $row->name }}</option>
                                 @endforeach   
                                </select>
                                @include('elements.feedback',['field' => 'bed_type_id'])
                            </div> 
                        </div> 
                        <div class="form-group row {{ $errors->has('price') ? ' has-danger' : '' }}">
                            <label for="price" class="col-sm-3 text-right control-label col-form-label">{{__('messages.price_in')}} <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-9">
                                <input type="number" name="price" value="{{old('price')}}" class="form-control" id="price" placeholder="Price" required autocomplete="off">
                                @include('elements.feedback',['field' => 'price'])
                            </div>
                        </div> 
                        <div class="form-group row {{ $errors->has('bed_no') ? ' has-danger' : '' }}">
                            <label for="bed_no" class="col-sm-3 text-right control-label col-form-label">{{__('messages.bed_no')}} <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="bed_no" value="{{old('bed_no')}}" class="form-control" id="bed_no" placeholder="Bed No" required autocomplete="off">
                                @include('elements.feedback',['field' => 'bed_no'])
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
