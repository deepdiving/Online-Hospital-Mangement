@extends('layout.app',['pageTitle' => __('Role Management')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ __('messages.roles') }}
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">{{ __('messages.role') }}</h3>
                <h6 class="card-subtitle">{{ __('messages.new_role') }}</h6>
                <hr class="hr-borderd">
                <form class="form-material m-t-40 form" action="{{route('storeRole')}}" method="post">
                    @csrf
                    <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.role_name') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="New role name">
                            @include('elements.feedback',['field' => 'name'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('slug') ? ' has-danger' : '' }}">
                        <label for="slug" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.permission') }} :</label>
                        <div class="col-sm-10">
                            <div class="accordion" id="myAccordion">
                                @foreach($permissions as $permission)
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <input type="checkbox" id="{{$permission->id}}" class="filled-in chk-col-purple form-control pcheck">
                                            <label class="" for="{{$permission->id}}" style="padding-left: 10px; top: 19px;"></label>
                                            <button type="button" style="text-decoration: blink;" class="btn btn-link" data-toggle="collapse" data-target="#collapsible-{{$permission->id}}" data-parent="#myAccordion">{{$permission->name}} <i  class="fa fa-angle-down" aria-hidden="true"></i></button>
                                        </h5>
                                    </div>
                                    <div id="collapsible-{{$permission->id}}" class="collapse">
                                        <div class="card-body" style="padding-top: 0px;">
                                            <input type="checkbox" data-parent="{{$permission->id}}" name="permission[]" value="{{$permission->slug}}" id="{{$permission->slug.$permission->id}}" class="filled-in chk-col-purple form-control">
                                            <label class="" for="{{$permission->slug.$permission->id}}">{{$permission->name}}</label><br>
                                            <?php foreach (App\Permission::where('parent_id', $permission->id)->get() as $child) { ?>
                                            <input type="checkbox" data-parent="{{$child->parent_id}}" name="permission[]" value="{{$child->slug}}" id="{{$child->slug.$child->id}}" class="filled-in chk-col-purple form-control">
                                            <label class="" for="{{$child->slug.$child->id}}">{{$child->name}}</label><br>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-group m-b-0">
                        <button type="submit" class="btn btn-themecolor waves-effect float-right waves-light m-t-10">{{ __('messages.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('css')

@endpush

@push('js')
<script>
    $(".pcheck").on('change', function (e) {
                var id = $(this).attr('id');
                if ($(this).is(':checked')){
                    $(":checkbox[data-parent=" + id + "]").attr('checked', true);
                }else{
                    $(":checkbox[data-parent=" + id + "]").attr('checked', false);
                }
            });
</script>
@endpush

@endsection
