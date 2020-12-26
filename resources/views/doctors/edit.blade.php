@extends('layout.app',['pageTitle' => __('Edit Doctor')])
@section('content')
@component('layout.inc.breadcrumb')
@slot('title')
Doctors
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
  <div class = "col-md-2"></div>
    <div class="col-lg-8 col-md-8">
        <div class="card">
            <div class="card-body">
                <form class="form-material form" action="{{ route('doctor.update',$doctor) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <h3 class="form-title text-themecolor"><span>{{__('messages.personal_information')}}</span></h3>
                    <div class="row m-t-20">

                      <div class="form-group col-md-6 m-t-20">
                          <div class="avatar-upload">
                              <div class="avatar-edit">
                                  <input type='file' id="imageUpload" name="picture" value="{{old('picture')}}" class="form-control" accept=".png, .jpg, .jpeg" />
                                  <label for="imageUpload"></label>
                              </div>
                              <div class="avatar-preview">
                                  <div id="imagePreview" style="background-image: url({{(!empty($doctor->picture))? asset($doctor->picture) : asset('user-default.png')}});"></div>
                              </div>
                          </div>
                          <input type="hidden" value="{{$doctor->picture}}" name="old_image">
                          <input type="hidden" value="{{$doctor->id}}" name="patient_number">
                          @include('elements.feedback',['field' => 'picture'])
                      </div>

                      <div class="form-group col-md-6 m-t-20">
                      <textarea name="biography" class="form-control" rows="9" placeholder="{{__('messages.write_a_note')}}">{{ $doctor->biography }}</textarea>
                      </div>

                        <div class="form-group col-md-6 m-t-20">
                            <input type="text" name="full_name" id="full_name" class="form-control form-control-line" placeholder="Doctor name (required)" required autocomplete="off" value="{{old('full_name',$doctor->full_name)}}">
                            @include('elements.feedback',['field' => 'full_name'])
                        </div>
                        <div class="form-group col-md-6 m-t-20">
                            <input type="text" name="designation" value="{{old('designation',$doctor->designation)}}" class="form-control  form-control-line" id="designation" placeholder="Designation (required)" required autocomplete="off">
                            @include('elements.feedback',['field' => 'designation'])
                        </div>
                        <div class="form-group col-md-6 m-t-20">
                            <input type="number" name="phone_no" value="{{old('phone_no',$doctor->phone_no)}}" maxlength="10" minlength="7" class="form-control  form-control-line" id="phone_no" placeholder="{{__('messages.telephone_number')}} "  autocomplete="off">
                            @include('elements.feedback',['field' => 'phone_no'])
                        </div>
                        <div class="form-group col-md-6 m-t-20">
                            <input type="number" name="mobile_no" value="{{old('mobile_no',$doctor->mobile_no)}}" maxlength="11" minlength="11" class="form-control  form-control-line" id="mobile_no" placeholder="Mobile Number (required)" required autocomplete="off">
                            @include('elements.feedback',['field' => 'mobile_no'])
                        </div>
                        <div class="form-group col-md-6 m-t-20">
                            <input type="text" name="address" value="{{old('address',$doctor->address)}}" class="form-control  form-control-line" id="address" placeholder="{{__('messages.address')}} (required)" required autocomplete="off">
                            @include('elements.feedback',['field' => 'address'])
                        </div>
                        <div class="form-group col-md-6 m-t-20">
                            <input type="email" name="email" value="{{old('email',$doctor->email)}}" class="form-control form-control-line" id="email" placeholder="{{__('messages.email')}}" autocomplete="off">
                            @include('elements.feedback',['field' => 'email'])
                        </div>
                        <div class="form-group col-md-6 m-t-20">
                            <input type="number" name="age" maxlength="2" value="{{old('age',$doctor->age)}}" class="form-control  form-control-line" id="age" placeholder="{{__('messages.age')}} (required)" required autocomplete="off">
                            @include('elements.feedback',['field' => 'age'])
                        </div>
                        <div class="form-group col-md-6 m-t-20">
                            <select name="department_id" class="form-control" id="department_id" required autocomplete="off">
                                <option value="" selected disabled>Select Department</option>
                                    @foreach ($departmets as $row)
                                    <option value="{{ $row->id}}"@if($row->id=$doctor->department_id) selected @endif>{{ $row->dep_name }}</option>
                                    @endforeach
                            </select>
                               @include('elements.feedback',['field' => 'department_id'])
                        </div>

                        <div class="form-group col-md-6 m-t-20">
                            <select class="form-control" required name="blood_group">
                                <option value="" selected disabled>Blood Group (required)</option>
                                 <?php echo Pharma::getOptionArray(['A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','O+'=>'O+','O-'=>'O-','AB+'=>'AB+','AB-'=>'AB-'],old('blood_group',$doctor->blood_group))?>
                            </select>
                            @include('elements.feedback',['field' => 'blood_group'])
                        </div>
                        <div class="form-group col-md-6 m-t-20">
                            <select class="form-control" required name="religion">
                                <option value="" selected disabled>Religion (required)</option>
                                <?php echo Pharma::getOptionArray(['Islam'=>'Islam','Hindu'=>'Hindu','Buddha'=>'Buddha','Christian'=>'Christian','Other'=>'Other'],old('religion',$doctor->religion))?>
                            </select>
                            @include('elements.feedback',['field' => 'religion'])
                        </div>

                        <div class="form-group col-md-6 m-t-20">
                            <label for="description" class="control-label col-form-label">{{__('messages.gender')}} :</label>
                            <input name="gender" value="Male" type="radio" class="with-gap" id="Male" {{$doctor->gender == 'Male' ? 'checked' : ''}}>
                            <label for="Male">{{__('messages.male')}}</label>
                            <input name="gender" value="Female" type="radio" id="Female" class="with-gap" {{$doctor->gender == 'Female' ? 'checked' : ''}}>
                            <label for="Female">{{__('messages.female')}}</label>
                            <input name="gender" value="Other" type="radio" id="Other" class="with-gap" {{$doctor->gender == 'Other' ? 'checked' : ''}}>
                            <label for="Other">{{trans_choice('messages.other',1)}}</label>
                        </div>
                        <div class="form-group col-md-6 m-t-20">
                            <label for="description" class="control-label col-form-label">{{__('messages.marital_status')}} :</label>
                            <input name="marital_status" value="Married" type="radio" class="with-gap" id="Married" {{$doctor->marital_status == 'Married' ? 'checked' : ''}}>
                            <label for="Married">{{__('messages.married')}}</label>
                            <input name="marital_status" value="Single" type="radio" id="Single" class="with-gap" {{$doctor->marital_status == 'Single' ? 'checked' : ''}}>
                            <label for="Single">{{__('messages.single')}}</label>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <button type="submit" class="btn btn-themecolor float-right m-t-10">{{__('messages.update')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/imageupload.css') }}">
@endpush
@push('js')
    <script src="{{ asset('js/imageupload.js') }}"></script>
@endpush
