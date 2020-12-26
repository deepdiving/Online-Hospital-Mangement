@extends('layout.app',['pageTitle' => __('Template Management')]) @section('content') @component('layout.inc.breadcrumb') @slot('title') {{ __('Email Templates') }} @endslot @endcomponent @include('elements.alert')
<div class="row">
    <div class="col-xlg-12 col-lg-12 col-md-12">
        <div class="card-body pt-0">
            <div class="card border shadow-none">
                <div class="card-body">
                    <h3 class="card-title mb-0">{{$mail->subject}}</h3>
                </div>
                <div>
                    <hr class="mt-0">
                </div>
                <div class="card-body">
                    <div class="d-flex mb-5">
                        <div>
                            <a href="javascript:void(0)"><img src="http://127.0.0.1:8000/material/assets/images/users/1.jpg" alt="user" width="40" class="rounded-circle"></a>
                        </div>
                        <div class="pl-2">
                            <h4 class="mb-0">{{$mail->to}}</h4>
                            <small class="text-muted">From: {{$mail->from}}</small>
                        </div>
                    </div>
                    {!!$mail->message!!}
                </div>
                <div>
                    <hr class="mt-0">
                </div>
                <div class="card-body">
                    <h4><i class="fa fa-paperclip mr-2 mb-2"></i> Attachments <span>(0)</span></h4>
                    <div class="row">
                        {{-- <div class="col-md-2">
                            <a href="#"> <img class="img-thumbnail img-fluid" alt="attachment" src="../assets/images/big/img1.jpg"> </a>
                        </div>
                        <div class="col-md-2">
                            <a href="#"> <img class="img-thumbnail img-fluid" alt="attachment" src="../assets/images/big/img2.jpg"> </a>
                        </div>
                        <div class="col-md-2">
                            <a href="#"> <img class="img-thumbnail img-fluid" alt="attachment" src="../assets/images/big/img3.jpg"> </a>
                        </div> --}}
                    </div>
                    <div class="border mt-3 p-3">
                        <p class="pb-3">click here to <a href="#">Reply</a> or <a href="#">Forward</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
