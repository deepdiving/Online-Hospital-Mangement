@extends('layout.app',['pageTitle' => __('Template Management')]) @section('content') @component('layout.inc.breadcrumb') @slot('title') {{ __('Email Templates') }} @endslot @endcomponent @include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="btn-group m-b-10 m-r-10" role="group" aria-label="Button group with nested dropdown">
                    <button type="button" class="btn btn-secondary font-18 text-dark"><i class="mdi mdi-inbox-arrow-down"></i></button>
                    <button type="button" class="btn btn-secondary font-18 text-dark"><i class="mdi mdi-alert-octagon"></i></button>
                    <button type="submit" class="btn btn-secondary font-18 text-dark" id="mailDelete"><i class="mdi mdi-delete"></i></button>


                </div>
                <div class="btn-group m-b-10 m-r-10" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary text-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-folder font-18 "></i> </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"> <a class="dropdown-item" href="#">Dropdown link</a> <a class="dropdown-item" href="#">Dropdown link</a> </div>
                    </div>
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn text-dark btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-label font-18"></i> </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"> <a class="dropdown-item" href="#">Dropdown link</a> <a class="dropdown-item" href="#">Dropdown link</a> </div>
                    </div>
                </div>
                <button type="button " class="btn btn-secondary m-r-10 m-b-10 text-dark"><i class="mdi mdi-reload font-18"></i></button>
                <div class="btn-group m-b-10" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn m-b-10 text-dark btn-secondary p-10 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> More </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"> <a class="dropdown-item" href="#">Mark as all read</a> <a class="dropdown-item" href="#">Dropdown link</a> </div>
                </div>
            </div>
            <div class="card-body p-t-0">
                <div class="card b-all shadow-none">
                    <div class="inbox-center table-responsive">
                        <table class="table table-hover no-wrap">
                            <tbody>
                                <form action="{{ route('maildelete') }}" method="post" id="submitfrom">
                                {{ csrf_field() }}
                                @foreach($mails as $mail)
                                <tr class="{{$mail->status}}">
                                    <td style="width:40px">
                                        <div class="checkbox">
                                            <input type="checkbox" id="checkbox{{$mail->id}}" name="chackMail[]" value="{{$mail->id}}">
                                            <label for="checkbox{{$mail->id}}"></label>
                                        </div>
                                    </td>
                                    <td>@if($mail->status == 'unread')<span style="color: #1e88e5;font-size: 10px;"><i class="fa fa-circle"></i></span> @endif</td>
                                    <td class="hidden-xs-down">
                                        {{$mail->to}}
                                    </td>
                                    <td class="max-texts">
                                        <a href="{{ url('settings/mailbox/detail/'.$mail->id) }}"><span class="label label-info m-r-10">{{$mail->template}}</span>
                                            {{Pharma::limit_text(strip_tags($mail->message),19)}}
                                        </a>
                                    </td>
                                <td class="text-right"> {{date('M d, H:i A',strtotime($mail->created_at))}} </td>
                                </tr>
                                @endforeach
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        $('#mailDelete').click(function(){
            $('#submitfrom').submit();
        });
    </script>
@endpush
