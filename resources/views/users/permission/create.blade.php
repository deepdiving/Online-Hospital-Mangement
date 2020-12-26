@extends('layout.app',['pageTitle' => __('Permission Management')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ __('messages.permissions') }}
@endslot
@endcomponent

@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h3 class="card-title">{{ __('messages.permissions')}}</h3>
                        <h6 class="card-subtitle">{{ __('messages.new_permission')}}</h6>
                        <hr class="hr-borderd">
                        <div class="card card-body">
                            <form class="form-horizontal form" action="{{ route('permission.store') }}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="first_name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.permission_type')}}<sup class="text-danger font-bold">*</sup> :</label>
                                    <div class="col-sm-10">
                                        <select name="type" id="type" class="form-control">
                                            <option value="parent">{{ __('messages.parent')}}</option>
                                            <option value="child">{{ __('messages.child')}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('parent_id') ? ' has-danger' : '' }}" style="display:none" id="permission_parent">
                                    <label for="parent_id" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.select_parent')}}<sup class="text-danger font-bold">*</sup> :</label>
                                    <div class="col-sm-10">
                                        <select name="parent_id" id="type" class="form-control">
                                            @foreach ($parent_ids as $parent_id)
                                            <option value="{{$parent_id->id}}">{{$parent_id->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.permission_name')}}<sup class="text-danger font-bold">*</sup> :</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="Permission name">
                                        @include('elements.feedback',['field' => 'name'])
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('slug') ? ' has-danger' : '' }}">
                                    <label for="description" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.description')}}<sup  class="text-danger font-bold">*</sup> :</label>
                                    <div class="col-sm-10">
                                        <textarea name="description" class="form-control" rows="5"></textarea>
                                        @include('elements.feedback',['field' => 'slug'])
                                    </div>
                                </div>


                                <div class="form-group m-b-0">
                                    <button type="submit" class="btn btn-themecolor waves-effect float-right waves-light m-t-10">{{ __('messages.save')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
    $(document).ready(function(){
            $('#type').on('change',function(){
                const permissionType = $(this).val();
                if(permissionType === "child"){
                    $('#permission_parent').slideDown();
                }else{
                $('#permission_parent').slideUp();
                }
            });
        });
</script>
@endpush

@endsection
