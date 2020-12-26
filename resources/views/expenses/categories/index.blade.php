@extends('layout.app',['pageTitle' => __('messages.expense_management')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.expense_category') }}
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline">{{ __('messages.expense_category') }}</h4><br>
                    <h6 class="card-subtitle d-inline">{{ __('messages.all_expense_category_list_here') }}..</h6>
                    {{-- @if(Sentinel::hasAccess('expenseCategory-create'))
                        <a class="btn float-right bg-primary text-light" href="{{url()}}">New expenseCategory</a>
                    @endif --}}
                    <hr class="hr-borderd">
                    <div class="col-lg-12">
                        <div class="Content">
                                <table class="table table-bordered table-hover Content" id="myTable">
                                    <thead>
                                    <tr class="themeThead">
                                        <th width="50">{{__('messages.sl')}}</th>
                                        <th>{{__('messages.expense_category')}}</th>
                                        <th>{{__('messages.amount')}}</th>
                                        @if(Sentinel::hasAccess('expenseCategory-show') || Sentinel::hasAccess('expenseCategory-edit') || Sentinel::hasAccess('expenseCategory-destroy'))
                                            <th width="100">{{__('messages.action')}}</th>
                                        @endif
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php $i = 0;?>
                                    @foreach($expenseCategorys as $expenseCategory)
                                        <tr>
                                            <td>{{sprintf('%02d',++$i)}}</td>
                                            <td>{{$expenseCategory->category_name}}</td>
                                            <td class="text-left">{{Pharma::amountFormatWithCurrency(App\Expense::where('expense_category_id',$expenseCategory->id)->sum('amount'))}}</td>
                                            @if(Sentinel::hasAccess('expenseCategory-show') || Sentinel::hasAccess('expenseCategory-edit') || Sentinel::hasAccess('expenseCategory-destroy'))
                                                <td style="display: flex; justify-content: space-evenly;">
                                                    @if(Sentinel::hasAccess('expenseCategory-edit'))
                                                        <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{url('/expenses/category/'.$expenseCategory->slug.'/edit')}}"><i class="fa fa-edit"></i></a>
                                                    @endif
                                                </td>
                                            @endif
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
