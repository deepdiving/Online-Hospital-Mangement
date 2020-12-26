@extends('layout.app',['pageTitle' => trans_choice('messages.test_list',1)])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{trans_choice('messages.test_list',1)}}
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline">{{trans_choice('messages.test_list',1)}}</h4><br>
                <h6 class="card-subtitle d-inline">{{__('messages.see_all')}} {{trans_choice('messages.test_list',10)}}</h6>
               
                <a class="btn float-right bg-theme text-light" href="{{url('diagnostic/testlists/create')}}">{{ __('messages.new_test_list')}}</a>
               
                <hr class="hr-borderd">

                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="example23">
                            <thead>
                                <tr class="themeThead">
                                    <th width="50">{{__('messages.sl')}}</th>
                                    <th>{{trans_choice('messages.test',1)}} {{__('messages.name')}}</th>
                                    <th>{{trans_choice('messages.test',1)}} {{trans_choice('messages.category',1)}}</th>
                                    <th class="text-right">{{ __('messages.price_in')}}</th>  
                                    <th width="100">{{__('messages.action')}}</th>
                                </tr>
                            </thead>

                             <tbody>
                                <?php $i = 0;?>
                               @foreach($testLists as $testList)
                                 <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>
                                    <td>
                                        {{ $testList->name }}
                                    </td>
                                    <td>
                                        {{ $testList->category->category }}
                                    </td> 
                                    <td class="text-right">
                                        {{ Pharma::amountFormatWithCurrency($testList->price) }}
                                    </td> 
                                    <td style="display: flex; justify-content: space-evenly;">
                                        
                                        <a class="btn waves-effect waves-light btn-xs btn-info" href="{{ url('/diagnostic/testlists/'.$testList->id) }}"><i class="fa fa-eye"></i></a>
                                       
                                        <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('/diagnostic/testlists/'.$testList->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                       
                                        <form action="{{ url('/diagnostic/testlists/'.$testList->id) }}" method="post" style="margin-top:-2px" id="deleteButton{{$testList->id}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$testList->id}})"><i class="fa fa-trash-o"></i></button>
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
</div>
@include('elements.dataTableOne')
@endsection
