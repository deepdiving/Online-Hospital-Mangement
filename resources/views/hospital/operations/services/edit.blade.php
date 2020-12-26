@extends('layout.app',['pageTitle' => 'Operation Type Name'])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        Update Operation Type Name
    @endslot
@endcomponent
 
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Operation Name</h4>
                    <h6 class="card-subtitle">Update Operation Type</h6>
                    <hr class="hr-borderd">
                    <form class="form-material m-t-40 form" action="{{ route('service.update',$service) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">Operation Name <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="{{old('name',$service->name)}}" class="form-control" id="name" placeholder="Service Name" required autocomplete="off">
                                @include('elements.feedback',['field' => 'name'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('service_category_id') ? ' has-danger' : '' }}">
                            <label for="operation_type_id" class="col-sm-2 text-right control-label col-form-label">Operation Category<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <select name="operation_type_id" class="form-control" id="operation_type_id" required autocomplete="off">
                                 <option value="" selected disabled>Select Operation Category Type</option>
                                {!!Pharma::GetOptions($category,'name',$service->id)!!}
                                </select>
                                @include('elements.feedback',['field' => 'operation_type_id'])
                            </div> 
                        </div>
                        <div class="form-group row {{ $errors->has('price') ? ' has-danger' : '' }}">
                            <label for="price" class="col-sm-2 text-right control-label col-form-label">{{__('messages.price_in')}} <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="number" name="price" value="{{old('price',$service->price)}}" class="form-control" id="price" placeholder="Price" required autocomplete="off">
                                @include('elements.feedback',['field' => 'price'])
                            </div>
                        </div>       
                        <div class="form-group m-b-0 float-right">
                            <a href="{{url('/hospital/operation/service')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
