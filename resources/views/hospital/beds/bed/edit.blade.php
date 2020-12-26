@extends('layout.app',['pageTitle' => $bed->bedtype->name])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{__('messages.update')}} {{trans_choice('messages.bed',10)}}
    @endslot
@endcomponent
 
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{trans_choice('messages.bed',10)}}</h4>
                    <h6 class="card-subtitle">{{__('messages.update')}} {{trans_choice('messages.bed',10)}}</h6>
                    <hr class="hr-borderd">
                    <form class="form-material m-t-40 form" action="{{ url('/hospital/beds/bed/'.$bed->slug) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group row {{ $errors->has('bed_type_id') ? ' has-danger' : '' }}">
                            <label for="test_category_id" class="col-sm-2 text-right control-label col-form-label">{{__('messages.bed_type')}}<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <select name="bed_type_id" class="form-control" id="bed_type_id" required autocomplete="off">
                                 <option value="" selected disabled>Select Bed Type</option>
                                 @foreach ($bedtype as $row)
                                 <option value="{{ $row->id}}"@if($row->id==$bed->bed_type_id) selected @endif>{{ $row->name }}</option>
                                 @endforeach   
                                </select>
                                @include('elements.feedback',['field' => 'bed_type_id'])
                            </div> 
                        </div> 
                        <div class="form-group row {{ $errors->has('price') ? ' has-danger' : '' }}">
                            <label for="price" class="col-sm-2 text-right control-label col-form-label">{{__('messages.price_in')}} <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="number" name="price" value="{{old('price',$bed->price)}}" class="form-control" id="price" placeholder="Price" required autocomplete="off">
                                @include('elements.feedback',['field' => 'price'])
                            </div>
                        </div> 
                        <div class="form-group row {{ $errors->has('bed_no') ? ' has-danger' : '' }}">
                            <label for="bed_no" class="col-sm-2 text-right control-label col-form-label">{{__('messages.bed_no')}} <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="bed_no" value="{{old('bed_no',$bed->bed_no)}}" class="form-control" id="bed_no" placeholder="Bed No" required autocomplete="off">
                                @include('elements.feedback',['field' => 'bed_no'])
                            </div>
                        </div>      
                        <div class="form-group m-b-0 float-right">
                            <a href="{{url('/hospital/beds/bed')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
