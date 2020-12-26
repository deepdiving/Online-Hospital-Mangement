@extends('layout.app',['pageTitle' => __('Add Medicine')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.medicin') }}
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">{{ trans_choice('messages.medicin',1) }}</h4>
                <h6 class="card-subtitle">{{ __('messages.creat_new_madic') }}</h6>
                <hr class="hr-borderd">
                <form class="form-material m-t-40 form" action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row {{ $errors->has('title') ? ' has-danger' : '' }}">
                        <label for="title" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.medi_name') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" value="{{old('title')}}" class="form-control" id="title" placeholder="Medicines title" required autocomplete="off">
                            @include('elements.feedback',['field' => 'title'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('generic_name') ? ' has-danger' : '' }}">
                    <label for="generic_name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.medi_genegic') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="generic_name" value="{{old('generic_name')}}" class="form-control" id="generic_name" placeholder="Medicines generic name" required autocomplete="off">
                            @include('elements.feedback',['field' => 'generic_name'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('note') ? ' has-danger' : '' }}">
                    <label for="note" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.medi_note') }}</label>
                        <div class="col-sm-10">
                            <textarea name="note" id="note" class="form-control" rows="10" placeholder="Tell me about this description."></textarea>
                            <small>Write a short description;</small>
                            @include('elements.feedback',['field' => 'note'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-2 text-right control-label col-form-label"></label>
                        <div class="col-sm-10">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="form-group {{ $errors->has('box_size') ? ' has-danger' : '' }}">
                                    <label for="box_size">{{ __('messages.box_size') }}<sup class="text-danger font-bold">*</sup> :</label>
                                        <input type="number" name="box_size" value="{{old('box_size',0)}}" class="form-control" id="box_size" placeholder="Medicines box size" required autocomplete="off">
                                        @include('elements.feedback',['field' => 'box_size'])
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group row {{ $errors->has('shelf_no') ? ' has-danger' : '' }}">
                                    <label for="shelf_no">{{ __('messages.self_no') }} :</label>
                                            <input type="text" name="shelf_no" value="{{old('shelf_no')}}" class="form-control" id="shelf_no" placeholder="Medicines shelf No" autocomplete="off">
                                            @include('elements.feedback',['field' => 'shelf_no'])
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group {{ $errors->has('purchase_price') ? ' has-danger' : '' }}">
                                    <label for="purchase_price">{{ __('messages.purch_price') }}<sup class="text-danger font-bold">*</sup> :</label>
                                        <div class="md-form input-group">
                                            <div class="input-group-prepend"><span class="input-group-text md-addon">{{Pharma::getCurrency()}}</span></div>
                                            <input type="number" name="purchase_price" value="{{old('purchase_price',0)}}" class="form-control" id="purchase_price" placeholder="Medicines box size" required autocomplete="off">
                                            <div class="input-group-append"><span class="input-group-text md-addon">.00</span></div>
                                        </div>
                                        @include('elements.feedback',['field' => 'purchase_price'])
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group {{ $errors->has('sale_price') ? ' has-danger' : '' }}">
                                        <label for="sale_price">{{ __('messages.price') }}<sup class="text-danger font-bold">*</sup> :</label>
                                        <div class="md-form input-group">
                                            <div class="input-group-prepend"><span class="input-group-text md-addon">{{Pharma::getCurrency()}}</span></div>
                                            <input type="number" name="sale_price" value="{{old('sale_price',0)}}" class="form-control" id="sale_price" placeholder="Medicines shelf No" required autocomplete="off">
                                            <div class="input-group-append"><span class="input-group-text md-addon">.00</span></div>
                                        </div>
                                            @include('elements.feedback',['field' => 'sale_price'])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('manufacturer_id') ? ' has-danger' : '' }}">
                        <label for="manufacturer_id" class="col-sm-2 text-right control-label col-form-label"> {{ __('messages.manufacturer') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <select name="manufacturer_id" id="manufacturer_id" class="form-control">
                                <?php echo Pharma::GetOptions($manufacturers,'manufacturer_name',old('manufacturer_id'));?>
                            </select>
                            @include('elements.feedback',['field' => 'manufacturer_id'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('category_id') ? ' has-danger' : '' }}">
                        <label for="category_id" class="col-sm-2 text-right control-label col-form-label"> {{ trans_choice('messages.category', 1) }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <select name="category_id" id="category_id" class="form-control">
                                <?php echo Pharma::GetOptions($categories,'name',old('category_id'));?>
                            </select>
                            @include('elements.feedback',['field' => 'category_id'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('unit_id') ? ' has-danger' : '' }}">
                        <label for="unit_id" class="col-sm-2 text-right control-label col-form-label">Unit<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <select name="unit_id" id="unit_id" class="form-control">
                                <?php echo Pharma::GetOptions($units,'unit_name',old('unit_id'));?>
                            </select>
                            @include('elements.feedback',['field' => 'unit_id'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('type_id') ? ' has-danger' : '' }}">
                        <label for="type_id" class="col-sm-2 text-right control-label col-form-label">Type<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <select name="type_id" id="type_id" class="form-control">
                                <?php echo Pharma::GetOptions($types,'type_name',old('type_id'));?>
                            </select>
                            @include('elements.feedback',['field' => 'type_id'])
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('image') ? ' has-danger' : '' }}">
                        <label for="" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.image') }} :</label>
                        <div class="col-sm-10">
                            {{-- <input type="file" name="image" value="{{old('image')}}" class="form-control" id="image" placeholder="Medicines image" required autocomplete="off"> --}}
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' id="imageUpload" name="medicine_image" value="{{old('medicine_image')}}" class="form-control" accept=".png, .jpg, .jpeg" />
                                    <label for="imageUpload"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url({{url('default.png')}});">
                                    </div>
                                </div>
                            </div>
                            @include('elements.feedback',['field' => 'medicine_image'])
                        </div>
                    </div> 
                    <div class="form-group m-b-0 float-right">
                        <a href="{{url('products/product')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                        <button type="submit" class="btn bg-theme text-white">{{__('messages.save')}}</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/imageupload.css') }}">
@endpush
@push('js')
    <script src="{{ asset('js/imageupload.js') }}"></script>
@endpush
