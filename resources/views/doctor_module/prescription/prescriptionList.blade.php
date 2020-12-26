@extends('layout.app',['pageTitle' => 'Prescription List'])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        prescription 
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-6 col-md-6">
           <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline">Prescriptions</h4>
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="example23">
                            <thead>
                                <tr class="themeThead">
                                    <th width="50">{{__('messages.sl')}}</th>
                                    <th>Date</th>
                                    <th>#Id</th> 
                                    <th>Patient Name</th>
                                    <th width='150'>{{ __('messages.action')}}</th>  
                                </tr>
                            </thead>
    
                                <tbody>
                                <?php $i = 0;?>
                                @foreach($presctiption as $row) 
                                    <tr>
                                        <td>{{sprintf('%02d',++$i)}}</td>
                                        <td>{{  Pharma::dateFormat($row->date) }}
                                        <td>{{ $row->invoice }}</td> 
                                        <td>{{ $row->patient->patient_name }}</td>
                                        <td style="display: flex; justify-content: space-evenly;"> 
                                            <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('prescription/invoice/a4/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> A4</a> 
                                            <form action="{{url('prescription/void/'.$row->id)}}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
                                                @csrf
                                                <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$row->id}})"><i class="mdi mdi-backup-restore"></i> Void</button>
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
        <div class="col-lg-6 col-md-6">
           <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline">Draft Prescription</h4>
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="example22">
                            <thead>
                                <tr class="themeThead">
                                    <th width="50">{{__('messages.sl')}}</th>
                                    <th>Date</th>
                                    <th>#Id</th> 
                                    <th>Patient Name</th>
                                    <th width='150'>{{ __('messages.action')}}</th>  
                                </tr>
                            </thead>
    
                                <tbody>
                                <?php $i = 0;?>
                                @foreach($presctiptionDraft as $row) 
                                    <tr>
                                        <td>{{sprintf('%02d',++$i)}}</td>
                                        <td>{{  Pharma::dateFormat($row->date) }}
                                        <td>{{ $row->invoice }}</td> 
                                        <td>{{ $row->patient->patient_name }}</td>
                                        <td style="display: flex; justify-content: space-evenly;"> 
                                            <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('prescription/invoice/a4/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> A4</a> 
                                            <a class="btn waves-effect waves-light text-light btn-xs btn-info" href="{{url("prescription/{$row->invoice}/edit")}}"><i class="mdi mdi-arrow-right-box"></i> Continue</a> 
                                            <form action="{{url('prescription/void/'.$row->id)}}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
                                                @csrf
                                                <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$row->id}})"><i class="mdi mdi-backup-restore"></i> Void</button>
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
@include('elements.dataTableOne')
@endsection