@extends('layout.app',['pageTitle' => __('Export Import')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.export_import') }}
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card bg-warning">
                <div class="card-body">
                   <h4 class="text-white">{{ __('messages.importent')}} :</h4>
                   <p class="text-white">
                    {{ __('messages.importent_des') }} .
                   </p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('messages.import_medicin') }} :</h4>
                    <form action="{{url('products/item-import')}}" method="post" class="form-material" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="" class="col-4 col-form-label">{{ __('messages.import_Medicinp') }} :</label>
                            <div class="col-8">
                                <input type="file" class="form-control"  name="productcsv">
                            </div>
                        </div>
                        <div class="float-right">
                            <a href="{{url('products/item-export-form')}}" class="btn bg-theme text-light">{{ __('messages.get_format') }}</a>
                            <button type="submit" class="btn btn-warning">{{ __('messages.import') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('messages.import_batch') }}</h4>
                    <form action="{{url('products/batch-import')}}" method="post" class="form-material" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="" class="col-4 col-form-label">{{ __('messages.import_Medicinp') }}</label>
                            <div class="col-8">
                                <input type="file" class="form-control"  name="batchcsv">
                            </div>
                        </div>
                        <div class="float-right">
                            <a href="{{url('products/batch-export-form')}}" class="btn bg-theme text-light">{{ __('messages.get_format') }}</a>
                            <button type="submit" class="btn btn-warning">{{ __('messages.import') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('messages.ex_medicinp') }} :</h4>
                    <table class="table">
                        <tr>
                            <td>{{ __('messages.ex_medicinp') }} :</td>
                            <td><a href="{{url('products/item-export')}}" class="btn btn-sm bg-theme text-light">{{ __('messages.export') }}</a></td>
                        </tr>
                        <tr>
                            <td>{{ __('messages.ex_medecin_batch') }} :</td>
                            <td><a href="{{url('products/batch-export')}}" class="btn btn-sm bg-theme text-light">{{ __('messages.export') }}</a></td>
                        </tr>
                        <tr>
                            <td>{{ __('messages.ex_categories') }} :</td>
                            <td><a href="{{url('products/category-export')}}" class="btn btn-sm bg-theme text-light">{{ __('messages.export') }}</a></td>
                        </tr>
                        <tr>
                            <td>{{ __('messages.ex_unit') }} :</td>
                            <td><a href="{{url('products/unit-export')}}"" class="btn btn-sm bg-theme text-light">{{ __('messages.export') }}</a></td>
                        </tr>
                        <tr>
                            <td>{{ __('messages.ex_medicin_type') }} :</td>
                            <td><a href="{{url('products/product-type-export')}}" class="btn btn-sm bg-theme text-light">{{ __('messages.export') }}</a></td>
                        </tr>
                        <tr>
                            <td>{{ __('messages.ex_manufac') }} :</td>
                            <td><a href="{{url('products/manufacturer-export')}}" class="btn btn-sm bg-theme text-light">{{ __('messages.export') }}</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        @if(session()->has('csv'))
            <div class="col-lg-12 col-md-12">
                <div class="card bg-danger text-light">
                    <div class="card-body">
                        <h4 class="card-title text-light">{{ __('messages.not_ex_data') }}</h4>
                        <h6 class="card-subtitle text-light">{{ __('messages.check_slug') }}</h6>
                        <table class="table" id="dataTableNoPaging">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.item_name') }}</th>
                                    <th>{{ __('messages.generic_name') }}</th>
                                    <th>{{ __('messages.note') }}</th>
                                    <th>{{ __('messages.box_size')}}</th>
                                    <th>{{ __('messages.purch_price')}}</th>
                                    <th>{{ __('messages.sale_price') }}</th>
                                    <th>{{ __('messages.self_no') }}</th>
                                    <th>{{ __('messages.category_slug')}}</th>
                                    <th>{{ __('messages.unit_slug') }}</th>
                                    <th>{{ __('messages.manufac_slug') }}</th>
                                    <th>{{ __('messages.product_slug') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; @endphp
                                @foreach(session('csv') as $row)
                                    <tr>
                                        <td>{{$row['itemname']}}</td>
                                        <td>{{$row['generic_name']}}</td>
                                        <td>{{$row['note']}}</td>
                                        <td>{{$row['box_size']}}</td>
                                        <td>{{$row['purchase_price']}}</td>
                                        <td>{{$row['sale_price']}}</td>
                                        <td>{{$row['shelf_no']}}</td>
                                        <td>{{$row['category_slug']}}</td>
                                        <td>{{$row['unit_slug']}}</td>
                                        <td>{{$row['manufacturer_slug']}}</td>
                                        <td>{{$row['product_type_slug']}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="font-weight-bold text-center" colspan="11"> {{ __('messages.reload')}}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            @php session()->forget('csv'); @endphp
        @endif

        @if(session()->has('batch'))
            <div class="col-lg-12 col-md-12">
                <div class="card bg-danger text-light">
                    <div class="card-body">
                    <h4 class="card-title text-light">{{ __('messages.no_ex_data') }}</h4>
                        <h6 class="card-subtitle text-light">{{ __('messages.check_slug') }}</h6>
                        <table class="table" id="dataTableNoPaging">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.product_id') }}</th>
                                    <th>{{ __('messages.batch_number') }}</th>
                                    <th>{{ __('messages.batch_stock') }}</th>
                                    <th>{{ __('messages.ex_date')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; @endphp
                                @foreach(session('batch') as $row)
                                    <tr>
                                        <td>{{$row['product_id']}}</td>
                                        <td>{{$row['batch_number']}}</td>
                                        <td>{{$row['batch_stock']}}</td>
                                        <td>{{$row['expiry_date']}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="font-weight-bold text-center" colspan="11"> {{ __('messages.reload') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            @php session()->forget('batch'); @endphp
        @endif
    </div>
    @include('elements.dataTableOne')
@endsection