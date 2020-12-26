@extends('layout.app',['pageTitle' => 'New Addmission','sidebarStyle' => 'mini-sidebar','noFooter' => 'true'])
@section('content')
<style>
    .container-fluid {
        padding: 0 30px 0px 30px;
    }
    .page-wrapper {
        padding-bottom: 0px;
    }
    .noneState{
        opacity: .5;
        pointer-events: none;
    }
    .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
    .test-list-scroll{
        width: 100%;
        height: 644px;
        overflow: auto
    }
    .medicine-list-scroll{
        width: 100%;
        height: 758px;
        overflow: auto
    }
    .invoice-box{
        width: 100%;
        height: 308px;
        overflow: auto
    }
    .form-group {
        margin-bottom: 15px;
    }
    .display_none{
        display: none;
    }
    .table-hover tbody tr:hover {
        background: #f62d51;
        color: #fff;
    }
    .unselectable{
        background-color: #ddd;
        cursor: not-allowed;
    }
    .table td, .table th {
        padding: 0rem;
        vertical-align: middle;
        border-top: 1px solid #e9ecef;
        cursor: pointer;
    }

    span.select2.select2-container.select2-container--default{
        width: 100% !important;
    }
</style>

@include('elements.alert')
<form action="{{ route('prescription.store') }}" method="post" class="form-material" id="deleteButton1">
    @csrf
    <div class="row p-t-30" style="font-family: cursive; font-size: 15px;color:#000;">
        <div class="col-lg-3 col-md-3">

            <div class="card card-outline-inverse">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa fa-user-o"> </i> &nbsp;Appointmented Patient</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12 {{ $errors->has('appointment_id') ? ' has-danger' : '' }}">
                            <select name="appointment_id" class="form-control js-example-basic-single" id="appointment_id" required autocomplete="off">
                                <option value="" selected disabled>Select Paitent</option>
                                @foreach ($appointPatient as $row)
                                    <option value="{{ $row->id }}" data-patient="{{ $row->patient->id }}">#{{ $row->invoice }} {{$row->patient->patient_name}}</option>
                                @endforeach
                            </select>
                            @include('elements.feedback',['field' => 'appointment_id'])
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="card card-outline-inverse">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa fa-user-o"> </i> &nbsp;Diagnosis List</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <input type="text" name="" class="form-control form-control-line" id="search" placeholder="Search here" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <select class="form-control form-control-line" required name="" id="categories">
                                <option value="0" selected>All Categories</option>
                                <?php echo Pharma::GetOptions($testCategories,'category')?>
                            </select>
                        </div>
                    </div>
                    <div class="test-list-scroll">
                        <table class="table table-striped table-hover" id="example23">
                            <tbody id="listBody">
                                @foreach($testLists as $row) 
                                    <tr>
                                        <td onclick="addTest({{$row->id}},'{{$row->name}}')">{{$row->name}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    
        </div>

        <div class="col-lg-3 col-md-3">
            <div class="card card-outline-inverse">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa fa-user-o"> </i> &nbsp;Medecine List</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-9">
                            <select class="form-control form-control-line" required name="" id="name">
                                <option value="0" selected>All Type</option>
                                <?php echo Pharma::GetOptions($types,'name')?>
                            </select>
                        </div>

                        <div class="form-group col-md-3 text-right">
                            <span class="btn btn-info" onclick="clearMedicine()"><i class="mdi mdi-eraser"></i> Clear</span>
                        </div>

                        <div class="form-group col-md-9">
                            <input type="text" name="" class="form-control form-control-line" id="searchMedicine" placeholder="Search here" autocomplete="off">
                        </div>

                        <div class="form-group col-md-3 text-right">
                            <span class="btn btn-info" onclick="newMedicine()"> <i class="mdi mdi-plus-outline"></i> Add</span>
                        </div>
                    </div>
                        
                    <div class="medicine-list-scroll">
                        <table class="table table-striped table-hover" id="example24">
                            <tbody id="listBodymedicine">
                                @foreach($medecineLists as $row) 
                                    <tr>
                                        <td>{{sprintf('%02d',$row->id)}}</td>
                                        <td onclick="addToPrescriptioin({{$row->id}})">{{$row->name}}</td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <div class="card card-outline-inverse">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa fa-user-o"> </i> &nbsp;Prescreption</h4>
                </div>
                <div class="card-body">
                    <div class="pre-head d-flex justify-content-between">
                        <div class="patient">
                            <p id="prescription_patient_id">#0000</p>
                            <h3 id="prescription_patient">Patient Name</h3>
                            <p id="prescription_patient_age">00 Years</p>
                            <p id="prescription_patient_mob">+880 0000000000</p>
                            <input type="hidden" value="" id="patient_id" name="patient_id">
                        </div>
                        <div class="doctor">
                            <p>#{{$invoice}}</p>
                            <h3>{{$doctor->full_name}}</h3>
                            <p>{{$doctor->designation}}</p>
                            <p>{{$doctor->phone_no}}</p>
                        </div>
                    </div>

                    <div class="row m-t-40 b-t-2">
                        <div class="col-md-3 pb-4 b-r-2 pt-2">
                            <b>Symptoms :</b>
                            <textarea name="symptoms" id="" class="form-control" rows="6"></textarea>
                            <b>Diagnosis :</b>
                            <textarea name="diagnosis" id="" class="form-control" rows="6"></textarea>
                            <hr>
                            <table class="table table-striped">
                                <thead> 
                                <tr>
                                    <th>Test :</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="prescriptionTest">

                                </tbody>
                                
                            </table>
                            <br>
                            <b>Next Visit :</b>
                            <input type="text" name="next_appointment" autocomplete="off" class="form-control datepickerDB" placeholder="Next Visited Date" required>
                            
                        </div>
                        <div class="col-md-9 pb-4 pt-2">
                            <img src="{{asset('rx.png')}}" alt="" height="50" width="50">
                            <br>
                            <br>
                            <div style="min-height:395px">
                            <table class="table table-striped">
                                <tbody id="presctibeItems">
                                    <tr>
                                        <th width="30">SL</th>
                                        <th>Medicine</th>
                                        <th width="120"></th>
                                        <th width="80"></th>
                                        <th width="120"></th>
                                        <th width="50"></th>
                                    </tr>
                                    {{-- <tr>
                                        <td class="sl">1</td>
                                        <td>
                                            fNapa asdf asdf asdfasdf
                                            <input type="hidden" value="mdf" name="medicine[]">
                                        </td>
                                        <td>
                                            <select name="dos[]" class="form-control" id="">
                                                <option value="">1+0+1</option>
                                                <option value="">1+0+1</option>
                                                <option value="">#new</option>
                                            </select>
                                        </td>
                                        
                                        <td><input type="number" name="days[]" class="form-control" placeholder="Days only"></td>
                                        <td>
                                            <select name="usetime[]" class="form-control" id="">
                                                <option value="">খাবার আগে</option>
                                                <option value="">খাবার পরে</option>
                                                <option value="">খাবার মাঝে</option>
                                            </select>
                                        </td>
                                        <td><span class="btn btn-warning">X</span></td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                            <b>Advices :</b>
                            <textarea name="advices" id="" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" name="save" value ="savePrint" class="btn btn-lg btn-info"> <i class="mdi mdi-printer-3d"></i> Save & Print</button>
                    <button type="submit" name="save" value ="saveMore" class="btn btn-lg btn-success"><i class="mdi mdi-plus-circle-multiple-outline"></i> Save & More</button>
                    <button type="submit" name="save" value ="draft" class="btn btn-lg btn-primary"> <i class="icon-bag"></i> Save & Draft</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('css')
    <link href="{{ asset('material') }}/css/select2.min.css" rel="stylesheet" />
@endpush

@push('js')
    @include('elements.prescription'); 
    <script src="{{ asset('material') }}/js/select2.min.js"></script>
    <script src="{{ asset('js') }}/sweetalert.min.js"></script>

    <script>
        $('.js-example-basic-single').select2();
    </script>
@endpush