@extends('layout.app',['pageTitle' => __('messages.patient_management')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{trans_choice('messages.patient',1)}}
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline">{{trans_choice('messages.patient',10)}}</h4><br>
                <h6 class="card-subtitle d-inline">{{__('messages.see_all')}} {{trans_choice('messages.patient',10)}}</h6>
                <a class="btn float-right bg-theme text-light" href="{{route('patient.create')}}">{{__('messages.new_customer')}}</a>
                <hr class="hr-borderd">

                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="dataTableNoPaging">
                            <thead>
                                <tr class="themeThead">
                                    <th width="50">{{__('messages.sl')}}</th>
                                    <th>{{trans_choice('messages.picture',1)}}</th>
                                    <th>{{trans_choice('messages.patient',1)}}</th>
                                    <th>{{__('messages.phone')}}</th>
                                    <th>{{__('messages.address')}}</th>
                                    <th>{{__('messages.reg_date')}}</th>
                                    <th>{{__('messages.blood_group')}}</th>
                                    <th class="text-right">{{__('messages.due')}}</th>
                                    <th width="100">{{__('messages.action')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i = 0;?>
                                @foreach($patients as $patient)
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>
                                    <td><img style="width: auto;height: 50px;" src="{{ !empty($patient->picture) ? asset($patient->picture) : asset('user-default.png')}}" alt=""></td>
                                    <td><a href="{{url('patient/'.$patient->slug)}}">{{ $patient->patient_name }}</a> <small class="text-muted">{{ $patient->slug }} </small></td>
                                    <td>{{ $patient->phone }}</td>
                                    <td>{{ Pharma::limit_text($patient->address,15) }}</td>
                                    <td>{{ $patient->created_at }}</td>
                                    <td>{{ $patient->blood_group }}</td>
                                    <td class="text-right">{{Pharma::getcustomerBalance($patient->id)}}</td>
                                    <td style="display: flex; justify-content: space-evenly;">
                                        <a class="btn waves-effect waves-light btn-xs btn-info" href="{{url('patient/'.$patient->slug)}}"><i class="fa fa-eye"></i></a>
                                        <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{url('patient/'.$patient->slug.'/edit')}}"><i class="fa fa-edit"></i></a>
                                        {{-- @if(Sentinel::getUser()->inRole('admin')) --}}
                                        {{-- <form action="{{url('patient/'.$patient->slug)}}" method="post" style="margin-top:-2px" id="deleteButton{{$patient->id}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$patient->id}})"><i class="fa fa-trash-o"></i></button>
                                        </form> --}}
                                        {{-- @endif --}}
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
