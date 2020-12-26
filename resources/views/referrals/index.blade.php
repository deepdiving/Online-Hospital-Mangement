@extends('layout.app',['pageTitle' => 'Referrals'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Referrals
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline">Referrals</h4><br>
                <h6 class="card-subtitle d-inline">{{__('messages.see_all')}} Refferels</h6>
               
                <a class="btn float-right bg-theme text-light" href="{{url('referral/create')}}">New Referrals</a>
               
                <hr class="hr-borderd">

                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="myTable">
                            <thead>
                                <tr class="themeThead">
                                    <th width="50">{{__('messages.sl')}}</th>
                                    <th>{{__('messages.name')}}</th>
                                    <th>{{__('messages.designation')}}</th>
                                    <th>{{ __('messages.contact') }}</th>
                                    <th>{{__('messages.email')}}</th>   
                                    <th width="100">{{__('messages.action')}}</th>
                                </tr>
                            </thead>

                             <tbody>
                                <?php $i = 0;?>
                               @foreach($referrals as $referral)
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>
                                    <td>
                                        <a href="{{ url('referral/'.$referral->id) }}"> {{ $referral->name }}</a>
                                    </td>
                                    <td>
                                        {{ $referral->designation }}
                                    </td> 
                                    <td>
                                        {{ $referral->contact }}
                                    </td> 
                                    <td>
                                        {{ $referral->email }}
                                    </td> 
                                    
                                    <td style="display: flex; justify-content: space-evenly;">
                                        
                                        <a class="btn waves-effect waves-light btn-xs btn-info" href="{{ url('referral/'.$referral->id) }}"><i class="fa fa-eye"></i></a>
                                       
                                        <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('referral/'.$referral->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                       
                                        <form action="{{ url('/referral/'.$referral->id) }}" method="post" style="margin-top:-2px" id="deleteButton{{$referral->id}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$referral->id}})"><i class="fa fa-trash-o"></i></button>
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
