@extends('layout.app',['pageTitle' => __('messages.bank_management')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ __('messages.bank_management') }}
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline">{{trans_choice('messages.bank_account',10)}}</h4><br>
                <h6 class="card-subtitle d-inline">{{__('messages.see_all')}} {{trans_choice('messages.bank_account',10)}}</h6>
                @if(Sentinel::hasAccess('bankaccount-create'))
                <a class="btn float-right bg-theme text-light" href="{{route('bankaccount.create')}}">{{__('messages.new_bank_account')}}</a>
                @endif
                <hr class="hr-borderd">
                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="myTable">
                            <thead>
                                <tr class="themeThead">
                                    <th width="50" class="text-center">{{__('SL')}}</th>
                                    <th>{{__('messages.bank_name')}}</th>
                                    <th>{{__('messages.account_number')}}</th>
                                    <th>{{__('messages.account_name')}}</th>
                                    <th>{{__('messages.branch_name')}}</th>
                                    <th class="text-right">{{__('messages.balance')}}</th>
                                    @if(Sentinel::hasAccess('bankaccount-show') || Sentinel::hasAccess('bankaccount-edit') || Sentinel::hasAccess('bankaccount-destroy'))
                                        <th width="100">{{__('Action')}}</th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i = 0;?>
                                @foreach($bankaccounts as $bank)
                                <tr>
                                    <td class="text-center">{{sprintf('%02d',++$i)}}</td>
                                    <td>{{ $bank->bank_name}}</td>
                                    <td>{{ $bank->account_number}}</td>
                                    <td>{{ $bank->account_name}}</td>
                                    <td>{{ $bank->branch_name}}</td>
                                    <td class="text-right">{{ Pharma::getBankAccountBalance($bank->id,$bank->balance)}}</td>
                                    @if(Sentinel::hasAccess('bankaccount-show') || Sentinel::hasAccess('bankaccount-edit') || Sentinel::hasAccess('bankaccount-destroy'))
                                    <td style="display: flex; justify-content: space-evenly;">
                                        @if(Sentinel::hasAccess('bankaccount-edit'))
                                            <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{url('/bankaccount/'.$bank->id.'/edit')}}"><i class="fa fa-edit"></i></a>
                                        @endif
                                        {{-- @if(Sentinel::hasAccess('bankaccount-destroy'))
                                        <form action="{{url('/bankaccount/'.$bank->id)}}" method="post" style="margin-top:-2px" id="deleteButton{{$bank->id}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$bank->id}})"><i class="fa fa-trash-o"></i></button>
                                        </form>
                                        @endif --}}
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