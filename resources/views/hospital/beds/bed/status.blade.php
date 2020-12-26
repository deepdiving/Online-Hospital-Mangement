@extends('layout.app',['pageTitle' => 'Assigning Bed'])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
    Assigning Bed
    @endslot
@endcomponent
<style>
    .bed{
        text-align: center;
        background: #ddd !important;
        padding: 10px 20px;
    }
</style>
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        @foreach($bedtypes as $type)
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{$type->name}}</h4>
                <div class="row">
                    @foreach($type->bed as $row)
                        @if($row->patient != 0)
                            <div class="col-md-2 mt-3"
                                data-container="body" title=""
                                data-toggle="popover"
                                data-placement="top"
                                data-content="From : {{Pharma::dateformat($row->updated_at)}}"
                                data-html="true"                                                         
                                data-original-title="<a href='{{url('/patient/'.$row->admission->patient->slug)}}'>{{$row->rpatient->patient_name}}</a>">
                                <div class="bed my-1 py-3">
                               <i class="fa fa-bed text-danger" style="font-size:50px"></i> <br>
                               {{$row->bed_no}}
                                </div>
                            </div>
                        @else
                        <div class="col-md-2 mt-3"
                            data-container="body" title=""
                            data-toggle="popover"
                            data-placement="top"
                            data-content="From : --"
                            data-original-title="The Bed is Empty">
                                <div class="bed my-1 py-3">
                                    <i class="fa fa-bed text-primary" style="font-size:50px"></i> <br>
                                    {{$row->bed_no}}
                                </div>
                            </div>

                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
@include('elements.dataTableOne')
@endsection
