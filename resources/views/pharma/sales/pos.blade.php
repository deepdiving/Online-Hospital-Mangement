@extends('layout.app',['pageTitle' => 'POS','sidebarStyle' => 'mini-sidebar'])
@section('content')
@include('elements.alert')
<div class="row pt-4">
    <div class="col-lg-8 col-md-8">
        <div class="card">
            <div class="card-body">
                <h6 class="card-subtitle">{{ __('messages.new_category')}}</h6>
                <a href="https://spos.tecdiary.net/pos">https://spos.tecdiary.net/pos</a><br>
                <a href="https://demo.phppointofsale.com/index.php/sales">https://demo.phppointofsale.com/index.php/sales</a>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-subtitle">{{ __('messages.new_category')}}</h6>
            </div>
        </div>
    </div>
</div>
@endsection
