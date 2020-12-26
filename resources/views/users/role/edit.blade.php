@extends('layout.app',['pageTitle' => __('Role Management')])
@section('content')

@component('layout.inc.breadcrumb')
<style>
input[type="checkbox"]:indeterminate + label {
  color: deepPink;
}
</style>
@slot('title')
{{ __('messages.roles') }}
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('messages.role') }}</h4>
                <h6 class="card-subtitle">{{ __('messages.edit_role') }}</h6>
                <hr>
                <form class="form-material m-t-40 form" action="{{url('users/role/'.$role->id.'/update')}}"
                    method="post">
                    @csrf
                    <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.role_name') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" value="{{old('name',$role->name)}}" class="form-control" id="name" placeholder="Last Name">
                            @include('elements.feedback',['field' => 'name'])
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('slug') ? ' has-danger' : '' }}">
                        <label for="slug" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.permission') }}<sup class="text-danger font-bold">*</sup> :</label>
                        <div class="col-sm-10">
                            <div class="accordion" id="myAccordion">
                                @php $i=0; @endphp
                                @foreach($permissions as $permission)
                                <div class="card m-2">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <input type="checkbox" id="{{$permission->slug.$permission->id}}" class="chk-col-purple form-control {{$permission->slug.$permission->id}}">
                                            <label class="" for="{{$permission->slug.$permission->id}}" style="padding-left: 10px; top: 19px;"></label> 
                                            <button type="button" style="text-decoration: blink; collapsed" class="btn btn-link" data-toggle="collapse" data-target="#collapsible-{{$permission->id}}" data-parent="#myAccordion">{{$permission->name}} <i class="fa fa-angle-down" aria-hidden="false"></i></button>
                                        </h5>
                                    </div>
                                    <div id="collapsible-{{$permission->id}}" class="collapse ml-4 pl-3">
                                        <div class="card-body" style="padding-top: 0px; display: contents;">
                                            <input type="checkbox" data-parent="{{$permission->id}}" name="permission[]" value="{{$permission->slug}}" id="{{$permission->id}}" class="filled-in chk-col-purple form-control sub_{{$permission->slug.$permission->id}}"
                                            @if(!empty($role->permissions))
                                                @if(array_key_exists($permission->slug,$role->permissions)) checked="" @endif
                                            @endif
                                            >
                                            <label class="" for="{{$permission->id}}">{{$permission->name}}</label> &nbsp; | &nbsp;
                                            <?php 
                                            $childs = App\Permission::where('parent_id', $permission->id)->orderBy('id','DESC')->get();
                                            $limit =  count($childs);
                                            $j = 1;
                                            foreach ($childs as $child) { ?>
                                            <input type="checkbox" data-parent="{{$child->parent_id}}" name="permission[]" value="{{$child->slug}}" id="{{$child->slug.$child->id}}" class="filled-in chk-col-purple form-control sub_{{$permission->slug.$permission->id}}"
                                            @if(!empty($role->permissions))
                                                @if(array_key_exists($child->slug,$role->permissions)) checked="" @endif
                                            @endif
                                            >
                                            <label class="" for="{{$child->slug.$child->id}}">{{$child->name}}</label> @if($j<$limit)&nbsp; | &nbsp;@endif
                                            <?php $j++;}?>
                                        </div>
                                    </div>
                                </div>
                                
                                @push('js')
                                <script>
                                $(document).ready(function(){  
                                    var checkboxes{{$i}} = document.querySelectorAll('input.sub_{{$permission->slug.$permission->id}}'),
                                    checkall{{$i}} = document.getElementById('{{$permission->slug.$permission->id}}');
                                    
                                        var checkedCount = document.querySelectorAll('input.sub_{{$permission->slug.$permission->id}}:checked').length; 
                                        checkall{{$i}}.checked = checkedCount > 0;
                                        checkall{{$i}}.indeterminate = checkedCount > 0 && checkedCount < checkboxes{{$i}}.length;

                                    for(var i=0; i<checkboxes{{$i}}.length; i++) {
                                        checkboxes{{$i}}[i].onclick = function() {
                                            var checkedCount = document.querySelectorAll('input.sub_{{$permission->slug.$permission->id}}:checked').length; 
                                            checkall{{$i}}.checked = checkedCount > 0;
                                            checkall{{$i}}.indeterminate = checkedCount > 0 && checkedCount < checkboxes{{$i}}.length;
                                            }
                                        }
                                        checkall{{$i}}.onclick = function() {
                                        for(var i=0; i<checkboxes{{$i}}.length; i++) {
                                            checkboxes{{$i}}[i].checked = this.checked;
                                        }
                                    }
                                });
                                </script>
                                @endpush
                                @php $i++; @endphp
                            @endforeach
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <button type="submit" class="btn btn-themecolor waves-effect float-right waves-light m-t-10">{{ __('messages.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
