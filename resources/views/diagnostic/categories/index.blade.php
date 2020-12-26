@extends('layout.app',['pageTitle' => __('messages.test_category')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ trans_choice('messages.test',1) }} {{ trans_choice('messages.category',1) }}
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline">{{ trans_choice('messages.test',1) }} {{ trans_choice('messages.category',1) }}</h4><br>
                <h6 class="card-subtitle d-inline">{{__('messages.see_all')}} {{__('messages.test_category')}}</h6>
               
                <a class="btn float-right bg-theme text-light" href="{{url('diagnostic/categories/create')}}">{{ __('messages.new') }} {{trans_choice('messages.test_category',1)}}</a>
               
                <hr class="hr-borderd">

                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="myTable">
                            <thead>
                                <tr class="themeThead">
                                    <th width="50">{{__('messages.sl')}}</th>
                                    <th>{{__('messages.name')}}</th>
                                    <th>{{__('messages.comission')}}</th>  
                                    <th width="100">{{__('messages.action')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i = 0;?>
                               @foreach($diagontestcategories as $diagonstest)
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>
                                    <td>
                                        {{ $diagonstest->category }}
                                    </td>
                                    <td>
                                        {{ sprintf('%0.2f',$diagonstest->commission) }} %
                                    </td> 
                                    
                                    <td style="display: flex; justify-content: space-evenly;">
                                        
                                        <a class="btn waves-effect waves-light btn-xs btn-info" href="{{ url('/diagnostic/categories/'.$diagonstest->id) }}"><i class="fa fa-eye"></i></a>
                                       
                                        <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('/diagnostic/categories/'.$diagonstest->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                       
                                        <form action="{{ url('/diagnostic/categories/'.$diagonstest->id) }}" method="post" style="margin-top:-2px" id="deleteButton{{$diagonstest->id}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$diagonstest->id}})"><i class="fa fa-trash-o"></i></button>
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
