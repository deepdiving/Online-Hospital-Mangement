@extends('layout.app',['pageTitle' =>'Attendence'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
Attendence
@endslot
@endcomponent
@push('css')
<link href="{{ asset('material') }}/assets/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
@endpush
@include('elements.alert')
<div class="row">
    <div class="col-lg-5 col-md-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Attendence</h4>
                <h6 class="card-subtitle">Create New Attendence</h6>
                <form class="form-meterial m-t-40 form" action="{{ route('attendence.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row"> 
                        <div class="form-group col-md-6 {{ $errors->has('emp_id') ? ' has-danger' : '' }}">
                            <select name="emp_id" class="form-control" id="emp_id" required autocomplete="off">
                                <option value="" selected disabled>Select Employee</option>
                                @foreach ($employees as $row)
                                    <option value="{{ $row->id }}">{{$row->name}}</option>
                                @endforeach
                            </select>
                            @include('elements.feedback',['field' => 'emp_id'])
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" name="date" value="{{date('Y-m-d')}}" class="form-control datepickerDB" id="date" placeholder="date" required autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                <input type="text" name="time" required class="form-control" value="9:00"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                            </div> 
                        </div>
                        <div class="form-group col-md-6">                            
                                <input name="status" value="In" type="radio" class="with-gap" id="In" checked>
                                <label for="In">In</label>
                                <input name="status" value="Out" type="radio" id="Out" class="with-gap">
                                <label for="Out">Out</label>                            
                        </div> 
                    </div> 
                    <div class="form-group m-b-0 float-right">
                        <button type="submit" class="btn bg-theme text-white">{{__('messages.save')}}</button>
                    </div>
                </form>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Import Attendance :</h4>
                <form action="{{url('attendance-form/import')}}" method="post" class="form-material" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="" class="col-4 col-form-label">Import Attendance :</label>
                        <div class="col-8">
                            <input type="file" class="form-control"  name="attendancecsv">
                        </div>
                    </div>
                    <div class="float-right">
                        <a href="{{url('attendance-form/')}}" class="btn bg-theme text-light">{{ __('messages.get_format') }}</a>
                        <button type="submit" class="btn btn-warning">{{ __('messages.import') }}</button>
                    </div>
                </form>
            </div>
        </div>
        

        @if(session()->has('attendance'))
        <div class="col-lg-12 col-md-12 ">
            <div class="card bg-danger text-light">
                <div class="card-body">
                    <h4 class="card-title text-light">{{ __('messages.not_ex_data') }}</h4>
                    <h6 class="card-subtitle text-light">{{ __('messages.check_slug') }}</h6>
                    <table class="table" id="dataTableNoPaging">
                        <thead>
                            <tr>
                                <th width="50">SL</th>
                                <th>Date</th> 
                                <th>Employee Id</th> 
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; @endphp
                            @foreach(session('attendance') as $row)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$row['date']}}</td>
                                    <td>{{$row['employee_id']}}</td>
                                    <td>{{$row['time']}}</td>
                                    <td>{{$row['status']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="font-weight-bold text-center" colspan="11"> {{ __('messages.reload')}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @php session()->forget('attendance'); @endphp
    @endif  
    </div>

    <div class="col-lg-7 col-md-7 ">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline">Attendence</h4><br>
                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="myTable">
                            <thead>
                                <tr class="">
                                    <th width="50">SL</th>
                                    <th>Date</th> 
                                    <th>Employee Name</th> 
                                    <th>Time</th>
                                    <th>Check</th>                                                                      
                                    <th width="100">Action</th>
                                </tr>
                            </thead> 

                            <tbody>
                            <?php $i = 0;?>
                               @foreach($attendence as $row)
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>
                                    <td>{{date('d M',strtotime($row->date)) }}</td>
                                    <td>{{ $row->employee->name}}</td>
                                    <td>{{ date('h:i A', strtotime($row->time)) }}</td> 
                                    <td>{{ $row->status}}</td>                                                                  
                                    <td style="display: flex; justify-content: space-evenly;">
                                    <a class="btn waves-effect waves-light btn-xs btn-info" href="{{ url('attendence/'.$row->id) }}"><i class="fa fa-eye"></i></a>  
                                    <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('attendence/'.$row->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                    <form action="{{  url('attendence/'.$row->id) }}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$row->id}})"><i class="fa fa-trash-o"></i></button>
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
@push('js') 
<script src="{{ asset('js') }}/sweetalert.min.js"></script> 
<script src="{{ asset('material') }}/assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>     
<script>
    $('#single-input').clockpicker({
           placement: 'bottom',
           align: 'left',
           autoclose: true,
           'default': 'now'
       });
       $('.clockpicker').clockpicker({
           donetext: 'Done',
       }).find('input').change(function() {
           console.log(this.value);
       });
       $('#check-minutes').click(function(e) {
           // Have to stop propagation here
           e.stopPropagation();
           input.clockpicker('show').clockpicker('toggleView', 'minutes');
       });
       if (/mobile/i.test(navigator.userAgent)) {
           $('input').prop('readOnly', true);
       }
   </script>
@endpush
