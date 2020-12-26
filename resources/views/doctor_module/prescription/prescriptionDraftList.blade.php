@extends('layout.app',['pageTitle' => 'Prescription Draft List'])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        prescription 
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">  
           <div class="card">
                <div class="card-body">
                    
                    <div class="col-lg-12">
                        <div class="Content">
                            <table class="table table-bordered table-hover Content" id="myTable">
                                <thead>
                                    <tr class="themeThead">
                                        <th width="50">{{__('messages.sl')}}</th>
                                        <th>Date</th>
                                        <th>#Id</th> 
                                        <th>Patient Name</th>  
                                        <th>Status</th>
                                        {{-- <th width='150'>{{ __('messages.action')}}</th>   --}}
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
                                            <td>{{ $row->status}}</td>
                                            {{-- <td style="display: flex; justify-content: space-evenly;"> 
                                                <form action="{{url('prescription/void/'.$row->id)}}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
                                                    @csrf
                                                    <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$row->id}})"><i class="mdi mdi-backup-restore"></i> Void</button>
                                                </form>
                                            </td>  --}}
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
</div>
@include('elements.dataTableOne')
@endsection
{{-- @push('css')
<style>
    .wd60percent{ width: 60%;}
    .wd15percent{ width: 15%;}
    .wd25percent{ width: 25%;}
</style>
@endpush
@push('js')
<script src='{{ asset('js') }}/print.js'></script>
<script>
    function invoiceprint(){
        $("#printJS-form").print({
            addGlobalStyles : true,
            stylesheet : "{{ asset('css') }}/print.css",
            // rejectWindow : true,
            noPrintSelector : "#printSection,#footer",
            // iframe : false,
            append : null,
            prepend : "#footer"
        });
    }   
</script>
@endpush --}}
