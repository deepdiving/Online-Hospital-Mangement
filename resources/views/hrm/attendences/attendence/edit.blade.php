@extends('layout.app',['pageTitle' => 'Attendence Edit'])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        Update Attendence
    @endslot
@endcomponent
@push('css')
<link href="{{ asset('material') }}/assets/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
@endpush
@include('elements.alert')
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-lg-8 col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Attendence</h4>
                    <h6 class="card-subtitle">Update Attendence</h6>
                    <hr class="hr-borderd">
                    <form class="form-material m-t-40 form" action="{{ route('attendence.update',$attendence) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row"> 
                            <div class="form-group col-md-6 {{ $errors->has('emp_id') ? ' has-danger' : '' }}">
                                <select name="emp_id" class="form-control" id="emp_id" required autocomplete="off">
                                    <option value="" selected disabled>Select Employee</option>
                                    @foreach ($employees as $row)
                                        <option value="{{ $row->id }}"@if($row->id==$attendence->emp_id) selected @endif>{{$row->name}}</option>
                                    @endforeach
                                </select>
                                @include('elements.feedback',['field' => 'emp_id'])
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="date" value="{{$attendence->date}}" class="form-control datepickerDB" id="date" placeholder="date" required autocomplete="off">
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                    <input type="text" name="time" required class="form-control" value="{{$attendence->time}}"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                                </div> 
                            </div>
                            <div class="form-group col-md-6">      
                                <input name="status" value="In" type="radio" class="with-gap" id="In" {{$attendence->status == 'In' ? 'checked' : ''}}>
                                <label for="In">In</label>
                                <input name="status" value="Out" type="radio" id="Out" class="with-gap"   {{$attendence->status == 'Out' ? 'checked' : ''}}>
                                <label for="Out">Out</label>
                            </div> 
                        </div>       
                        <div class="form-group m-b-0 float-right">
                            <a href="{{url('/attendence')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
