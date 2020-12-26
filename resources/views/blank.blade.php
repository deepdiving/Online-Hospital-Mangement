@extends('layout.app',['pageTitle' => __('Main Dashboard'),'activeMenu' => 'Event Organiser'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ __('Blank Page') }}
@endslot
@endcomponent

@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h3 class="card-title">Sales Overview</h3>
                        <h6 class="card-subtitle">Ample Admin Vs Pixel Admin</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
<link href="{{ asset('material') }}/assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
@endpush

@push('js')
<script src="{{ asset('material') }}/assets/plugins/toast-master/js/jquery.toast.js"></script>
<script src="{{ asset('material') }}/js/toastr.js"></script>
@endpush

@endsection
