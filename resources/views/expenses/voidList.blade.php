@extends('layout.app',['pageTitle' => 'Expences Voide list'])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
    Expences Void list
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline">Void list</h4><br>
                    <h6 class="card-subtitle d-inline">{{__('messages.see_all')}} Void list</h6> 
                    <hr class="hr-borderd">
                    <div class="col-lg-12">
                        <div class="Content">
                                <table class="table table-bordered table-hover Content" id="myTable">
                                    <thead>
                                    <tr class="themeThead">
                                        <th width="80"> {{ __('messages.sl')}}</th>
                                        <th>{{__('messages.date')}}</th>
                                        <th>{{__('messages.expense_hed')}}</th>
                                        <th>{{__('messages.amount')}}</th>
                                        <th>{{__('messages.description')}}</th> 
                                  </tr>
                                    </thead>

                                    <tbody> 
                                        @php $i = 0; @endphp
                                        @foreach($expences as $row)
                                            <tr>
                                                <td>{{sprintf('%02d',++$i)}}</td> 
                                                <td>{{ Pharma::dateFormat($row->date) }}</td>
                                                <td>{{ $row->category->category_name}}</td>
                                                <td>{{ Pharma::amountFormatWithCurrency($row->amount)}}</td>
                                                <td>{{ Pharma::limit_text($row->description,15)}}</td>   
                                            </tr> 
                                        @endforeach  
                                    </tbody> 
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('elements.dataTableOne')
@endsection
