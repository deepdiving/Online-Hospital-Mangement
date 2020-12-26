@extends('layout.app',['pageTitle' => __('messages.patient_add')])
@section('content')
@component('layout.inc.breadcrumb')
@slot('title')
{{ trans_choice('messages.patient',10) }}
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material form" action="{{ route('patient.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <h3 class="form-title text-themecolor"><span>{{__('messages.personal_information')}}</span></h3>
                    <div class="row m-t-20">
                        <div class="form-group col-md-3 m-t-20">
                            <input type="text" name="patient_name" id="patient" class="form-control form-control-line" placeholder="{{__('messages.patient_name')}} (required)" required autocomplete="off" value="{{old('patient_name')}}"> 
                            @include('elements.feedback',['field' => 'patient_name'])
                        </div>
                        <div class="form-group col-md-3 m-t-20">
                            <input type="number" name="phone" value="{{old('phone')}}" maxlength="11" minlength="11" class="form-control  form-control-line" id="phone" placeholder="{{__('messages.phone_number')}} (required)" required autocomplete="off">
                            @include('elements.feedback',['field' => 'phone']) 
                        </div>
                        <div class="form-group col-md-3 m-t-20">
                            <input type="text" name="address" value="{{old('address')}}" class="form-control  form-control-line" id="address" placeholder="{{__('messages.address')}} (required)" required autocomplete="off">
                            @include('elements.feedback',['field' => 'address'])
                        </div>
                        <div class="form-group col-md-3 m-t-20">
                            <input type="email" name="email" value="{{old('email')}}" class="form-control form-control-line" id="email" placeholder="{{__('messages.email')}}" autocomplete="off">
                            @include('elements.feedback',['field' => 'email'])
                        </div>
                        <div class="form-group col-md-3 m-t-20">
                            <input type="number" name="age" maxlength="2" value="{{old('age')}}" class="form-control  form-control-line" id="age" placeholder="{{__('messages.age')}} (required)" required autocomplete="off">
                            @include('elements.feedback',['field' => 'age'])
                        </div>
                        <div class="form-group col-md-3 m-t-20">
                            <select class="form-control" required name="blood_group">
                                <option value="" selected disabled>Blood Group (required)</option>
                                <?php echo Pharma::getOptionArray(['A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','O+'=>'O+','O-'=>'O-','AB+'=>'AB+','AB-'=>'AB-'],old('blood_group'))?>
                            </select>
                            @include('elements.feedback',['field' => 'blood_group'])
                        </div>
                        <div class="form-group col-md-3 m-t-20"> 
                            <select class="form-control"  name="occupation">
                                <option value="" selected disabled>Occupation</option>
                                <?php echo Pharma::getOptionArray(['Business'=>'Business','Professional'=>'Professional','Student'=>'Student','House Wife'=>'House Wife','Labourers'=>'Labourers','Other'=>'Other'],old('occupation'))?>
                            </select>
                            @include('elements.feedback',['field' => 'occupation'])
                        </div>
                        <div class="form-group col-md-3 m-t-20">
                            <select class="form-control" required name="religion">
                                <option value="" selected disabled>Religion (required)</option>
                                <?php echo Pharma::getOptionArray(['Islam'=>'Islam','Hindu'=>'Hindu','Buddha'=>'Buddha','Christian'=>'Christian','Other'=>'Other'],old('religion'))?> 
                            </select>
                            @include('elements.feedback',['field' => 'religion'])
                        </div> 
                    
                        <div class="form-group col-md-2 m-t-20">
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' id="imageUpload" name="picture" value="{{old('picture')}}" class="form-control" accept=".png, .jpg, .jpeg" />
                                    <label for="imageUpload"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url({{asset('user-default.png')}});"></div>
                                </div>
                            </div>
                            @include('elements.feedback',['field' => 'picture'])
                                
                        </div>
                        <div class="form-group col-md-10 m-t-20">
                            <textarea name="description" class="form-control" rows="9" placeholder="{{__('messages.write_a_note')}}"></textarea>
                        </div>

                        <div class="form-group col-md-12 row">
                            <label for="description" class="col-sm-2 control-label col-form-label">{{__('messages.gender')}} :</label>
                            <div class="col-sm-10">
                                <input name="gender" value="Male" type="radio" class="with-gap" id="Male">
                                <label for="Male">{{__('messages.male')}}</label>
                                <input name="gender" value="Female" type="radio" id="Female" class="with-gap" checked>
                                <label for="Female">{{__('messages.female')}}</label>
                                <input name="gender" value="Other" type="radio" id="Other" class="with-gap">
                                <label for="Other">{{trans_choice('messages.other',1)}}</label>
                            </div>
                        </div>
                        <div class="form-group col-md-12 row">
                            <label for="description" class="col-sm-2 control-label col-form-label">{{__('messages.marital_status')}} :</label>
                            <div class="col-sm-10">
                                <input name="marital_status" value="Married" type="radio" class="with-gap" id="Married" checked>
                                <label for="Married">{{__('messages.married')}}</label>
                                <input name="marital_status" value="Single" type="radio" id="Single" class="with-gap">
                                <label for="Single">{{__('messages.single')}}</label>
                            </div>
                        </div>
                    </div>
                    <h3 class="form-title text-themecolor"><span>{{__('messages.guardian_information')}}</span></h3>
                    <div class="row m-t-20">
                        <div class="form-group col-md-4 m-t-20">
                            <input type="text" name="guardian" id="patient" class="form-control form-control-line" placeholder="{{__('messages.guardian_name')}}" autocomplete="off" value="{{old('guardian')}}"> 
                            @include('elements.feedback',['field' => 'guardian'])
                        </div>
                        <div class="form-group col-md-4 m-t-20">
                            <input type="number" name="guardian_phone" value="{{old('guardian_phone')}}" maxlength="11" minlength="11" class="form-control  form-control-line" id="guardian_phone" placeholder="{{__('messages.guardian_phone')}}" autocomplete="off">
                            @include('elements.feedback',['field' => 'guardian_phone']) 
                        </div>
                        <div class="form-group col-md-4 m-t-20">
                            <input type="text" name="relationship" value="{{old('relationship')}}" class="form-control form-control-line" id="relationship" placeholder="{{__('messages.guardian_rela')}}" autocomplete="off">
                            @include('elements.feedback',['field' => 'relationship'])
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <button type="submit" class="btn btn-themecolor float-right m-t-10">{{__('messages.save')}}</button>
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
