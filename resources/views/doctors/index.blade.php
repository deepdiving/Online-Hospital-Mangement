@extends('layout.app',['pageTitle' => __('Doctors')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Doctors
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline">Doctor</h4><br>
                <h6 class="card-subtitle d-inline">{{__('messages.see_all')}} Doctor</h6>
                <a class="btn float-right bg-theme text-light" href="{{route('doctor.create')}}">New Doctor</a>
                <hr class="hr-borderd">

                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="dataTableNoPaging">
                            <thead>
                                <tr class="themeThead">
                                    <th width="50">{{__('messages.sl')}}</th>
                                    <th>{{trans_choice('messages.picture',1)}}</th>
                                    <th>Doctor</th>
                                    <th>Designation</th>
                                    <th>{{__('messages.phone')}}</th>
                                    <th>{{__('messages.address')}}</th>
                                    <th>{{__('messages.blood_group')}}</th>
                                    <th width="100">{{__('messages.action')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i = 0;?>
                                @foreach($doctors as $row)
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>
                                    <td><img style="width: auto;height: 50px;" src="{{ !empty($row->picture) ? asset($row->picture) : asset('user-default.png')}}" alt=""></td>
                                    <td><a href="{{url('doctor/'.$row->id)}}">{{ $row->full_name }}</a></td>
                                    <td>{{ $row->designation }}</td>
                                    <td>{{ $row->phone_no }}</td>
                                    <td>{{ Pharma::limit_text($row->address,15) }}</td>
                                    <td>{{ $row->blood_group }}</td>
                                    <td style="display: flex; justify-content: space-evenly;">
                                        <a class="btn waves-effect waves-light btn-xs btn-info" href="{{url('doctor/'.$row->id)}}"><i class="fa fa-eye"></i></a>
                                        <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{url('doctor/'.$row->id.'/edit')}}"><i class="fa fa-edit"></i></a>

                                        {{-- <form action="{{url('doctor/'.$row->id)}}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$row->id}})"><i class="fa fa-trash-o"></i></button>
                                        </form>  --}}
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
