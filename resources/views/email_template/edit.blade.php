@extends('layout.app',['pageTitle' => __('Add New Template')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ trans_choice('messages.template',10) }}
    @endslot
@endcomponent
 
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ trans_choice('messages.template',10) }}</h4>
                    <h6 class="card-subtitle">{{ __('messages.update_template') }}</h6>
                    <hr>
                    <form class="form-material m-t-40 form" action="{{ route('emailtemplate.update',$emailtemplate) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.template_name') }}<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="{{old('name',$emailtemplate->name)}}" class="form-control" id="name" placeholder="Template name" required autocomplete="off">
                                @include('elements.feedback',['field' => 'name'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('slug') ? ' has-danger' : '' }}">
                            <label for="slug" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.template_slug') }}<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="slug" value="{{old('slug',$emailtemplate->slug)}}" class="form-control" id="slug" placeholder="Template slug should be unique" required autocomplete="off">
                                @include('elements.feedback',['field' => 'slug'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('subject') ? ' has-danger' : '' }}">
                            <label for="subject" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.template_sub') }}<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-10">
                                <input type="text" name="subject" value="{{old('subject',$emailtemplate->subject)}}" class="form-control" id="subject" placeholder="Template subject" required autocomplete="off">
                                @include('elements.feedback',['field' => 'subject'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('content') ? ' has-danger' : '' }}">
                            <label for="content" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.content') }} <sup class="text-danger font-bold">*</sup>:</label>
                            <div class="col-sm-10">
                                <textarea name="content" id="mymce" class="form-control" rows="10" placeholder="Type your email body">{{old('content',$emailtemplate->content)}}</textarea>
                                @include('elements.feedback',['field' => 'content'])
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                            <label for="description" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.description') }} :</label>
                            <div class="col-sm-10">
                                <input type="text" name="description" value="{{old('description',$emailtemplate->description)}}" class="form-control" id="description" placeholder="Tell me about this template (optional)" autocomplete="off">
                                @include('elements.feedback',['field' => 'description'])
                            </div>
                        </div>                         
                        <div class="form-group row {{ $errors->has('from_name') ? ' has-danger' : '' }}">
                            <label for="from_name" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.from_name') }} :</label>
                            <div class="col-sm-10">
                                <input type="text" name="from_name" value="{{old('from_name',$emailtemplate->from_name)}}" class="form-control" id="from_name" placeholder="sending name  (optional)" autocomplete="off">
                                @include('elements.feedback',['field' => 'from_name'])
                            </div>
                        </div>                         
                        <div class="form-group row {{ $errors->has('from_email') ? ' has-danger' : '' }}">
                            <label for="from_email" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.from_email') }} :</label>
                            <div class="col-sm-10">
                                <input type="email" name="from_email" value="{{old('from_email',$emailtemplate->from_email)}}" class="form-control" id="from_email" placeholder="sending email  (optional)" autocomplete="off">
                                @include('elements.feedback',['field' => 'from_email'])
                            </div>
                        </div>                         
                        <div class="form-group row {{ $errors->has('cc_email') ? ' has-danger' : '' }}">
                            <label for="cc_email" class="col-sm-2 text-right control-label col-form-label">{{ __('messages.cc_email') }} :</label>
                            <div class="col-sm-10">
                                <input type="email" name="cc_email" value="{{old('cc_email',$emailtemplate->cc_email)}}" class="form-control" id="cc_email" placeholder="cc email (optional)" autocomplete="off">
                                @include('elements.feedback',['field' => 'cc_email'])
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

@push('js')
<script src="{{ asset('material') }}/assets/plugins/tinymce/tinymce.min.js"></script>
    <script>
    $(document).ready(function() {
        if ($("#mymce").length > 0) {
            tinymce.init({
                selector: "textarea#mymce",
                theme: "modern",
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
            });
        }
    });
</script>
@endpush