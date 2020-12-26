@extends('layout.app',['pageTitle' => __('messages.expense_management')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('expenses') }}
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline">{{__('messages.exp_list')}}</h4><br>
                    <h6 class="card-subtitle d-inline">{{__('messages.see_all')}} {{__('messages.exp_list')}}</h6>
                    @if(Sentinel::hasAccess('expense-create'))
                        <a class="btn float-right bg-theme text-light" href="{{route('expense.create')}}">{{__('messages.new_expense')}}</a>
                    @endif
                    <hr class="hr-borderd">
                    <div class="col-lg-12">
                        <div class="Content">
                                <table class="table table-bordered table-hover Content" id="myTable">
                                    <thead>
                                    <tr class="themeThead">
                                        <th width="50">{{__('messages.sl')}}</th>
                                        <th>{{__('messages.date')}}</th>
                                        <th>{{__('messages.expense_hed')}}</th>
                                        <th>{{__('messages.amount')}}</th>
                                        <th>{{__('messages.description')}}</th>
                                        {{-- @if(Sentinel::hasAccess('expense-show') || Sentinel::hasAccess('expense-edit') || Sentinel::hasAccess('expense-destroy')) --}}
                                            <th width="100">{{__('Action')}}</th>
                                        {{-- @endif --}}
                                  </tr>
                                    </thead>

                                    <tbody>
                                    <?php $i = 0;?>
                                    @foreach($expenses as $exp)
                                        <tr>
                                            <td>{{sprintf('%02d',++$i)}}</td>
                                            <td>{{ Pharma::dateFormat($exp->date) }}</td>
                                            <td>{{ $exp->category->category_name}}</td>
                                            <td>{{ Pharma::amountFormatWithCurrency($exp->amount)}}</td>
                                            <td>{{ Pharma::limit_text($exp->description,15)}}</td>
                                            {{-- @if(Sentinel::hasAccess('expense-show') || Sentinel::hasAccess('expense-edit') || Sentinel::hasAccess('expense-destroy')) --}}
                                                <td style="display: flex; justify-content: space-evenly;">
                                                    {{-- @if(Sentinel::hasAccess('unit-show'))
                                                        <a class="btn waves-effect waves-light btn-xs btn-info" href="{{url('expense/'.$exp->id)}}"><i class="fa fa-eye"></i></a>
                                                    @endif --}}
                                                    {{-- @if(Sentinel::hasAccess('unit-edit'))
                                                        <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{url('expense/'.$exp->id.'/edit')}}"><i class="fa fa-edit"></i></a>
                                                    @endif --}}
                                                    {{-- @if(Sentinel::hasAccess('unit-destroy'))
                                                        <form action="{{url('expense/'.$exp->id)}}" method="post" style="margin-top:-2px" id="deleteButton{{$exp->id}}">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$exp->id}})"><i class="fa fa-trash-o"></i></button>
                                                        </form>
                                                    @endif --}}
                                                    <form action="{{url('expense/void/'.$exp->id)}}" method="post" style="margin-top:-2px" id="deleteButton{{$exp->id}}">
                                                        @csrf
                                                        <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$exp->id}})"><i class="mdi mdi-backup-restore"></i> Void</button>
                                                    </form>
                                                </td>
                                            {{-- @endif --}}
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
