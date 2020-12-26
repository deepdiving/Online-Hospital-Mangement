@extends('layout.app',['pageTitle' => __('Edit Employee')])
@section('content')
@component('layout.inc.breadcrumb')
@slot('title')
Upload Employees
@endslot
@endcomponent
@include('elements.alert')
<form class="form-material form" action="{{ route('employee.update',$employee) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
<div class="row"> 
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="card-body"> 
                    <h3 class="form-title text-themecolor"><span>Update Employee Information</span></h3> 
                    <div class="from-group col-md-4 m-t-40 m-l-20">
                        <div class="avatar-upload">
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' id="imageUpload" name="picture" value="{{old('picture')}}" class="form-control" accept=".png, .jpg, .jpeg" />
                                    <label for="imageUpload"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url({{(!empty($employee->picture))? asset($employee->picture) : asset('user-default.png')}});"></div>
                                </div>
                            </div>
                            <input type="hidden" value="{{$employee->picture}}" name="old_image">
                            <input type="hidden" value="{{$employee->id}}" name="patient_number">
                            @include('elements.feedback',['field' => 'picture']) 
                        </div>    
                    </div>
                    <div class="row m-l-20">
                        <div class="form-group col-md-6 m-t-20">
                            <input type="text" name="name" value="{{old('name',$employee->name)}}" class="form-control" id="name" placeholder="Name (required)" required autocomplete="off">
                            @include('elements.feedback',['field' => 'designation'])
                        </div>
                        <div class="form-group col-md-6 m-t-20">
                            <input type="text" name="date_of_birth" value="{{$employee->date_of_birth}}" class="form-control datepickerDB" id="date_of_birth" placeholder="Date Of Birth (required)" required autocomplete="off">
                            @include('elements.feedback',['field' => 'date_of_birth'])
                        </div> 
                        <div class="form-group col-md-6 m-t-20">
                            <input type="number" name="phone_no" value="{{old('phone_no',$employee->phone_no)}}" maxlength="11" minlength="11" class="form-control" id="phone_no" placeholder="Phone number"  required autocomplete="off">
                            @include('elements.feedback',['field' => 'phone_no'])
                        </div>
                        <div class="form-group col-md-6 m-t-20">
                            <input type="email" name="email" value="{{old('email',$employee->email)}}" class="form-control" id="email" placeholder="Email" autocomplete="off">
                            @include('elements.feedback',['field' => 'email'])
                        </div>
                        <div class="form-group col-md-6 m-t-20{{ $errors->has('department_id') ? ' has-danger' : '' }}">
                            <select name="department_id" class="form-control" id="department_id" required autocomplete="off">
                                <option value="" selected disabled>Select Department</option>
                                @foreach ($departmetn as $row)
                                    <option value="{{ $row->id }}"@if($row->id==$employee->department_id) selected @endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                            @include('elements.feedback',['field' => 'department_id'])
                        </div>
                        <div class="form-group col-md-6 m-t-20{{ $errors->has('position_id') ? ' has-danger' : '' }}">
                            <select name="position_id" class="form-control" id="position_id" required autocomplete="off">
                                <option value="" selected disabled>Select Position</option>
                                @foreach ($position as $row)
                                    <option value="{{ $row->id }}"@if($row->id==$employee->position_id)selected @endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                            @include('elements.feedback',['field' => 'position_id'])
                        </div>
                        <div class="form-group col-md-6 m-t-20">
                            <input type="text" name="joining_date" value="{{$employee->joining_date}}" class="form-control datepickerDB" id="joining_date" placeholder="Joining Date" autocomplete="off">
                            @include('elements.feedback',['field' => 'joining_date'])
                        </div> 
                        <div class="form-group col-md-6 m-t-20">
                            <input type="text" name="address" value="{{old('address',$employee->address)}}" class="form-control" id="address" placeholder="Address (required)" required autocomplete="off">
                            @include('elements.feedback',['field' => 'address'])
                        </div>   
                        <div class="form-group col-md-6 m-t-20"> 
                            <label for="description" class="control-label col-form-label">{{__('messages.gender')}} :</label>
                                <input name="gender" value="Male" type="radio" class="with-gap" id="Male" {{$employee->gender == 'Male' ? 'checked' : ''}}>
                                <label for="Male">{{__('messages.male')}}</label>
                                <input name="gender" value="Female" type="radio" id="Female" class="with-gap" {{$employee->gender == 'Female' ? 'checked' : ''}}>
                                <label for="Female">{{__('messages.female')}}</label>
                                <input name="gender" value="Other" type="radio" id="Other" class="with-gap" {{$employee->gender == 'Other' ? 'checked' : ''}}>
                                <label for="Other">{{trans_choice('messages.other',1)}}</label>
                            
                        </div>
                        <div class="form-group col-md-6 m-t-20">
                            <label for="description" class="control-label col-form-label">{{__('messages.marital_status')}} :</label>
                            <input name="marital_status" value="Married" type="radio" class="with-gap" id="Married" {{$employee->marital_status == 'Married' ? 'checked' : ''}}>
                            <label for="Married">{{__('messages.married')}}</label>
                            <input name="marital_status" value="Single" type="radio" id="Single" class="with-gap" {{$employee->marital_status == 'Single' ? 'checked' : ''}}>
                            <label for="Single">{{__('messages.single')}}</label>
                        </div> 
                     </div> 
                     <h3 class="form-title text-themecolor"><span>Emergency Information</span></h3> 
                     <div class="row m-t-20 m-l-20">
                        <div class="form-group col-md-6 m-t-20">
                            <input type="number" name="emergency_contact" value="{{old('emergency_contact',$employee->emergency_contact)}}" maxlength="11" minlength="11" class="form-control" id="emergency_contact" placeholder="Emenrgency Contact" autocomplete="off">
                            @include('elements.feedback',['field' => 'phone_no'])
                        </div>
                        <div class="form-group col-md-6 m-t-20">
                            <input type="text" name="emergency_address" value="{{old('emergency_address',$employee->emergency_address)}}" class="form-control" id="emergency_address" placeholder="Emergency Address" autocomplete="off">
                            @include('elements.feedback',['field' => 'address'])
                        </div> 
                     </div>               
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="card-body">
                <h3 class="form-title text-themecolor"><span>Employee Salary Structure</span></h3> 
                <div class="form-group row m-t-20 ">
                    <label for="basic_salary" class="col-sm-3 text-right control-label col-form-label"><b>Basic Salary</b><sup class="text-danger font-bold">*</sup> :</label>
                    <div class="col-sm-9">
                        <input type="number" name="basic_salary" value="{{old('basic_salary',$employee->basic_salary)}}"   class="form-control" id="basic_salary" placeholder="0.00" required autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="gross_salary" class="col-sm-3 text-right control-label col-form-label"><b>Gross Salary</b><sup class="text-danger font-bold">*</sup> :</label>
                    <div class="col-sm-9">
                        <input type="number" readonly name="gross_salary" value="{{old('gross_salary',$employee->gross_salary)}}"   class="form-control" id="gross_salary" placeholder="0.00" required autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="gross_salary" class="col-sm-3 text-right control-label col-form-label"><b>Additions</b><sup class="text-danger font-bold">*</sup> :</label>
                    <div class="col-sm-9">
                        @php $i = 0 @endphp
                        @foreach($empsalarystructure as $str)
                            @if($str->salarystr->type == 'Add')
                            <div class="form-group row">
                                <label for="gross_salary" class="col-sm-4 text-right control-label col-form-label"><b>{{$str->salarystr->title}}</b><sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-4">
                                    <input type="number" name="amount[]" value="{{$str->amount}}" class="form-control addpercent" id="addPercent" placeholder="0.00%" required autocomplete="off">
                                </div>
                                <div class="col-sm-4">
                                    <input type="number" readonly name="" value="{{old('gross_salary')}}" class="form-control addition" id="addamount{{++$i}}" placeholder="0.00" required autocomplete="off">
                                    <input type="hidden" name="salary_structure_id[]" value="{{$str->id}}">
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="form-group row">
                    <label for="gross_salary" class="col-sm-3 text-right control-label col-form-label"><b>Deduction</b><sup class="text-danger font-bold">*</sup> :</label>
                    <div class="col-sm-9">
                        @php $i = 0 @endphp
                        @foreach($empsalarystructure as $str)
                            @if($str->salarystr->type == 'Deduct')
                                <div class="form-group row">
                                    <label for="gross_salary" class="col-sm-4 text-right control-label col-form-label"><b>{{$str->salarystr->title}}</b><sup class="text-danger font-bold">*</sup> :</label>
                                    <div class="col-sm-4">
                                        <input type="number" name="amount[]" value="{{$str->amount}}" class="form-control deductpercent" id="deductPercent" placeholder="0.00%" required autocomplete="off">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="number" readonly name="" value="{{old('gross_salary')}}" class="form-control deduct" id="deductamount{{++$i}}" placeholder="0.00" required autocomplete="off">
                                        <input type="hidden" name="salary_structure_id[]" value="{{$str->id}}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div> 
  </div>   
</div> 
<div class="row">
    <div class="col-lg-12 col-md-12"> 
        <div class="form-group m-b-0">
            <button type="submit" class="btn btn-lg btn-themecolor m-t-10">{{__('messages.update')}}</button>
        </div>  
    </div> 
</div>
</div>
</form> 
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/imageupload.css') }}">
@endpush
@push('js')
    <script src="{{ asset('js/imageupload.js') }}"></script>
    <script>
        $(document).ready(function(){
            const basic = parseFloat($('#basic_salary').val())||0;
            grossSalary(basic);
        });

        $('#basic_salary').on('change keyup',function(){
            grossSalary($(this).val());
        });

        $('.addpercent,.deductpercent').on('change keyup',function(){
            const basic  = $('#basic_salary').val();
            grossSalary(basic);
        });

        function additions(basic){
            var i = 0;
            $('.addpercent').each(function(){
                var percentAmount = parseFloat($(this).val()) / 100 * parseFloat(basic);
                i = i+1;  
                $('#addamount'+i).val(parseFloat(percentAmount).toFixed());
            });

            var sum = 0;
            $('.addition').each(function(){
                sum += parseFloat($(this).val());  
            });
            return sum;
        }

        function deducttion (basic){
            var i = 0;
            $('.deductpercent').each(function(){
                var percentAmount = parseFloat($(this).val()) / 100 * parseFloat(basic);
                i = i+1;  
                $('#deductamount'+i).val(parseFloat(percentAmount).toFixed(2));
            });

            var sum = 0;
            $('.deduct').each(function(){
                sum += parseFloat($(this).val());  
            });
            return sum;
        }

        function grossSalary(basic){
            if(isNaN(basic)) { basic = 0 };
            var aAmount = additions(basic);
            var dAmount = deducttion(basic);
            const TAdition = parseFloat(basic) + parseFloat(aAmount);
            const gross_salary = parseFloat(TAdition) - parseFloat(dAmount);
            $('#gross_salary').val(parseFloat(gross_salary).toFixed(2));
        }

    </script>
@endpush
