@extends('layout.app',['pageTitle' =>'Asset Equipment'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
HMS Asset Equipment
@endslot
@endcomponent
@push('css')
<link href="{{ asset('material') }}/assets/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
@endpush
@include('elements.alert')
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Asset Equipment</h4>
                <h6 class="card-subtitle">Update New Asset Equipment</h6>
                <form class="form-meterial m-t-40 form" action="{{  url('asset/equipment/'.$equipment->id)}}" method="post">
                    @csrf                
                    @method('PUT')
                    <div class="row"> 
                        <div class="form-group row col-md-12  {{ $errors->has('item_name') ? ' has-danger' : '' }}">
                            {{-- <label for="item_name" class="col-sm-4 text-right control-label col-form-label">Name<sup class="text-danger font-bold">*</sup> :</label> --}}
                            <div class="col-sm-12 col-md-12">
                                <input type="text" name="item_name" value="{{old('item_name',$equipment->item_name)}}" class="form-control" id="item_name" placeholder="Type Name" required autocomplete="off">                          
                                @include('elements.feedback',['field' => 'item_name'])
                            </div>
                        </div> 

                        <div class="form-group row  col-md-12{{ $errors->has('description') ? ' has-danger' : '' }}">                          
                            {{-- <label for="description" class="col-sm-4 text-right control-label col-form-label">Description<sup class="text-danger font-bold">*</sup> :</label> --}}
                            <div class="col-sm-12 col-md-12">
                                <input type="text" name="description" value="{{old('description',$equipment->description)}}" class="form-control" id="description" placeholder="Description" required autocomplete="off">   
                                @include('elements.feedback',['field' => 'description'])
                            </div>
                        </div>  
                    
                        <div class="form-group row col-md-12 {{ $errors->has('model') ? ' has-danger' : '' }}">                          
                            {{-- <label for="model" class="col-sm-4 text-right control-label col-form-label">Model<sup class="text-danger font-bold">*</sup> :</label> --}}
                            <div class="col-sm-12 col-md-12">
                                <input type="text" name="model" value="{{old('model',$equipment->model)}}" class="form-control" id="model" placeholder="Model" required autocomplete="off">  
                                @include('elements.feedback',['field' => 'model'])
                            </div>
                        </div>  

                        <div class="form-group row col-md-12  {{ $errors->has('identification_no') ? ' has-danger' : '' }}">                          
                            {{-- <label for="identification_no" class="col-sm-4 text-right control-label col-form-label">Identification No<sup class="text-danger font-bold">*</sup> :</label> --}}
                            <div class="col-sm-12 col-md-12">
                                <input type="text" name="identification_no" value="{{old('identification_no',$equipment->identification_no)}}" class="form-control" id="identification_no" placeholder="Identification No" required autocomplete="off">
                                @include('elements.feedback',['field' => 'identification_no'])
                            </div>
                        </div>  

                        <div class="form-group row col-md-12  {{ $errors->has('serial_no') ? ' has-danger' : '' }}">                          
                            {{-- <label for="serial_no" class="col-sm-4 text-right control-label col-form-label">Serial No<sup class="text-danger font-bold">*</sup> :</label> --}}
                            <div class="col-sm-12 col-md-12">
                                <input type="text" name="serial_number" value="{{old('serial_no',$equipment->serial_number)}}" class="form-control" id="serial_no" placeholder="Serial No" required autocomplete="off">
                                @include('elements.feedback',['field' => 'serial_no'])
                            </div>
                        </div>   

                        <div class="form-group row col-md-12  {{ $errors->has('acquisition_cost') ? ' has-danger' : '' }}">                          
                            {{-- <label for="acquisition_cost" class="col-sm-4 text-right control-label col-form-label">Acquisition Cost<sup class="text-danger font-bold">*</sup> :</label> --}}
                            <div class="col-sm-12 col-md-12">
                                <input type="number" name="acquisition_cost" value="{{old('acquisition_cost',$equipment->acquisition_cost)}}" class="form-control" id="Acquisition Cost" placeholder="acquisition_cost" required autocomplete="off">
                                @include('elements.feedback',['field' => 'acquisition_cost'])
                            </div>
                        </div>   
        
                        <div class="form-group row col-md-12  {{ $errors->has('received_date') ? ' has-danger' : '' }}">                          
                            {{-- <label for="received_date" class="col-sm-4 text-right control-label col-form-label">Received Date<sup class="text-danger font-bold">*</sup> :</label> --}}
                            <div class="col-sm-12 col-md-12">
                                <input type="text" name="received_date" value="{{date('Y-m-d')}}" class="form-control datepickerDB" id="date" placeholder="date" required autocomplete="off">
                                @include('elements.feedback',['field' => 'received_date'])
                            </div>
                        </div>  
                                             
                        <div class="form-group col-md-12 {{ $errors->has('category_id') ? ' has-danger' : '' }}">
                            <select name="category_id" class="form-control" id="category_id" required autocomplete="off">
                                <option value="" selected disabled>Select Asset Category</option>
                                @foreach($category as $row)                              
                                <option value="{{ $row->id }}"@if($row->id==$equipment->category_id) selected @endif>{{$row->name}}</option>
                               @endforeach                                  
                            </select>
                            @include('elements.feedback',['field' => 'category_id'])
                        </div>

                        <div class="form-group col-md-12 {{ $errors->has('location_id') ? ' has-danger' : '' }}">
                            <select name="location_id" class="form-control" id="location_id" required autocomplete="off">
                                <option value="" selected disabled>Select Asset Location</option>
                                @foreach($location as $row)                              
                                <option value="{{ $row->id }}"@if($row->id==$equipment->location_id) selected @endif>{{$row->name}}</option>
                               @endforeach                                  
                            </select>
                            @include('elements.feedback',['field' => 'location_id'])
                        </div>
                        <div class="form-group col-md-12  m-t-20">
                            <label for="location_id" class="control-label col-form-label">Current Status :</label>                          
                            <input name="current_status" value="Usable" type="radio" class="with-gap" id="Usable" {{$equipment->current_status == 'Usable' ? 'checked' : ''}}>
                            <label for="Usable">Usable</label>
                            <input name="current_status" value="Not Usable" type="radio" id="Not Usable" class="with-gap" {{$equipment->current_status == 'Not Usable' ? 'checked' : ''}}>
                            <label for="Not Usable">Not Usable</label>
                            <input name="current_status" value="Repairable" type="radio" id="Repairable" class="with-gap" {{$equipment->current_status == 'Repairable' ? 'checked' : ''}}>
                            <label for="Repairable">Repairable</label>
                        </div>

                        <div class="form-group col-md-12  m-t-20">
                            <label for="condition" class="control-label col-form-label">Condition :</label>
                            <input name="condition" value="Good" type="radio" class="with-gap" id="Good" {{$equipment->condition == 'Good' ? 'checked' : ''}}>
                            <label for="Good">Good</label>
                            <input name="condition" value="Average" type="radio" id="Average" class="with-gap" {{$equipment->condition == 'Average' ? 'checked' : ''}}>
                            <label for="Average">Average</label>
                            <input name="condition" value="Damage" type="radio" id="Damage" class="with-gap" {{$equipment->condition == 'Damage' ? 'checked' : ''}}>
                            <label for="Damage">Damage</label>
                        </div>
                    </div> 
                    <div class="form-group m-b-0 float-right">
                        <a href="{{url('asset/equipment')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                        <button type="submit" class="btn bg-theme text-white">{{__('messages.update')}}</button>
                    </div>  
                </form>
            </div>
        </div>

    </div>
   
   
</div>
@include('elements.dataTableOne')
@endsection

