@extends('layout.app',['pageTitle' => trans_choice('messages.new_referral',1)])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
       {{__('messages.create_new')}} {{trans_choice('messages.new_referral',10)}}
    @endslot
@endcomponent

@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{trans_choice('messages.referral',1)}}</h4>
                    <h6 class="card-subtitle">{{__('messages.create_new')}} {{trans_choice('messages.new_referral',10)}}</h6>
                    <hr class="hr-borderd">
                    <form class="form-material m-t-40 form" action="{{ url('/referral') }}" method="post">
                        @csrf
                        <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{__('messages.name_of')}} {{trans_choice('messages.referral',1)}}<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="{{__('messages.name_of')}} {{trans_choice('messages.referral',1)}}" required autocomplete="off">
                                @include('elements.feedback',['field' => 'name'])
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('referral_category_id') ? ' has-danger' : '' }}">
                            <label for="referral_category_id" class="col-sm-2 text-right control-label col-form-label">Referral Category<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <select name="referral_category_id" class="form-control" id="referral_category_id" required autocomplete="off">
                                 <option value="" selected disabled>Select Referral Category</option>
                                 @foreach ($refCategory as $row)
                                 <option value="{{ $row->id}}">{{ $row->cat_name }}</option>
                                 @endforeach   
                                </select>
                                @include('elements.feedback',['field' => 'referral_category_id'])
                            </div> 
                        </div>


                      <div class="form-group row {{ $errors->has('designation') ? ' has-danger' : '' }}">
                          <label for="designation" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.designation') }}<sup class="text-danger font-bold"></sup> :</label>
                          <div class="col-sm-10">
                              <input type="text" name="designation" value="{{old('designation')}}" class="form-control" id="designation" placeholder="designation" required autocomplete="off">
                              @include('elements.feedback',['field' => 'designation'])
                          </div>
                      </div>


                        <div class="form-group row {{ $errors->has('contact') ? ' has-danger' : '' }}">
                            <label for="contact" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.contact') }}<sup class="text-danger font-bold"></sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="contact" value="{{old('contact')}}" class="form-control" id="contact" placeholder="Contact" required autocomplete="off">
                                @include('elements.feedback',['field' => 'contact'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label for="email" class="col-sm-2 text-right control-label col-form-label">{{__('messages.email')}}<sup class="text-danger font-bold"></sup> :</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" value="{{old('email')}}" class="form-control" id="email" placeholder="Email"  autocomplete="off">
                                @include('elements.feedback',['field' => 'email'])
                            </div>
                        </div>
                        <div class="form-group m-b-0 float-right">
                            <a href="{{url('diagnostic/referrals')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
