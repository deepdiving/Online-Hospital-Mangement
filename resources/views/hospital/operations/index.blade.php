@extends('layout.app',['pageTitle' =>'Operation Service'])
@section('content')

@include('elements.alert')
<div class="row p-t-30">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Operation Service</h4>
                    <hr class="hr-borderd">
                    <form class="form-material m-t-10 form" action="{{ route('operation.store') }}" method="post">
                        @csrf
                        <div class="form-group row {{ $errors->has('patient_id') ? ' has-danger' : '' }}">
                            <label for="patient_id" class="col-sm-3 text-right control-label col-form-label">Patient<sup class="text-danger font-bold">*</sup> :</label>      
                            <div class="col-sm-9">
                                <select name="patient_id" class="form-control" id="patient_id" required autocomplete="off">
                                    <option value="" selected disabled>Select Patient</option>       
                                    @foreach ($patient_id as $row)
                                        <option value="{{ $row->patient_id}}">{{ App\Patient::find($row->patient_id)->patient_name }}</option>
                                    @endforeach                                 
                                </select>
                                @include('elements.feedback',['field' => 'patient_id'])
                            </div> 
                        </div>
                        <div id="operation_field" class="disabled">

                            <div class="form-group row {{ $errors->has('operation_type_id') ? ' has-danger' : '' }}">
                                <label for="operation_type_id" class="col-sm-3 text-right control-label col-form-label">Date<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-6">
                                    <input type="text" name="date" value="{{date('Y-m-d')}}" class="form-control datepickerDB" id="date" placeholder="Delivary date" required autocomplete="off">
                                </div> 
                                <div class="col-sm-3">
                                    <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                        <input type="text" name="time" required class="form-control" value="12:00"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                                     </div>
                                </div> 
                            </div>

                            <div class="form-group row {{ $errors->has('operation_type_id') ? ' has-danger' : '' }}">
                                <label for="operation_type_id" class="col-sm-3 text-right control-label col-form-label">Type<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <select name="operation_type_id" class="form-control" id="operation_type_id" required autocomplete="off">
                                        <option value="" selected disabled>Select Operation Type</option>                      
                                        @foreach ($types as $row)
                                            <option value="{{ $row->id}}">{{ $row->name }}</option>
                                        @endforeach                                 
                                    </select>
                                    @include('elements.feedback',['field' => 'operation_type_id'])
                                </div> 
                            </div> 
                            <div class="form-group row {{ $errors->has('operation_service_id') ? ' has-danger' : '' }}">
                                <label for="operation_service_id" class="col-sm-3 text-right control-label col-form-label">Oparation<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <select name="operation_service_id" class="form-control" id="operation_service_id" required autocomplete="off">
                                        <option value="" selected disabled>Select Operation Service</option>                      
                                        @foreach ($services as $row)
                                            <option value="{{ $row->id}}">{{ $row->name }}</option>
                                        @endforeach                                 
                                    </select>
                                    @include('elements.feedback',['field' => 'operation_service_id'])
                                </div> 
                            </div> 
                            <div class="form-group row {{ $errors->has('price') ? ' has-danger' : '' }}">
                                <label for="price" class="col-sm-3 text-right control-label col-form-label">{{__('messages.price_in')}} <sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="number" name="price" value="{{old('price')}}" readonly class="form-control" id="price" placeholder="Price" required autocomplete="off">
                                    @include('elements.feedback',['field' => 'price'])
                                </div>
                            </div>       
                            <div class="form-group row {{ $errors->has('discount') ? ' has-danger' : '' }}">
                                <label for="discount" class="col-sm-3 text-right control-label col-form-label">Discount <sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="number" name="discount" value="{{old('discount',0)}}" class="form-control" id="discount" placeholder="Discount Amount" required autocomplete="off">
                                    @include('elements.feedback',['field' => 'discount'])
                                </div>
                            </div>       
                            <div class="form-group row {{ $errors->has('grand_total') ? ' has-danger' : '' }}">
                                <label for="grand_total" class="col-sm-3 text-right control-label col-form-label">Grand Total <sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="number" name="grand_total" readonly value="{{old('grand_total')}}" class="form-control" id="grand_total" placeholder="grand_total" required autocomplete="off">
                                    @include('elements.feedback',['field' => 'grand_total'])
                                </div>
                            </div>       
                            <div class="form-group row {{ $errors->has('paid_amount') ? ' has-danger' : '' }}">
                                <label for="paid_amount" class="col-sm-3 text-right control-label col-form-label">Pay Amount <sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="number" name="paid_amount" value="{{old('paid_amount')}}" class="form-control" id="paid_amount" placeholder="Paid Amount" required autocomplete="off">
                                    @include('elements.feedback',['field' => 'paid_amount'])
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('due') ? ' has-danger' : '' }} d-none" id="due-field">
                                <label for="due" class="col-sm-3 text-right control-label col-form-label">Due <sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="number" name="due" value="{{old('due')}}" readonly class="form-control" id="due" placeholder="Due Amount" required autocomplete="off">
                                    @include('elements.feedback',['field' => 'due'])
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('change') ? ' has-danger' : '' }} d-none" id="change-field">
                                <label for="change" class="col-sm-3 text-right control-label col-form-label">Change<sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                    <input type="number" name="change" value="{{old('change')}}" readonly class="form-control" id="change" placeholder="change Amount" required autocomplete="off">
                                    @include('elements.feedback',['field' => 'change'])
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('remerk') ? ' has-danger' : '' }}">
                                <label for="remerk" class="col-sm-3 text-right control-label col-form-label">Remerk <sup class="text-danger font-bold">*</sup> :</label>
                                <div class="col-sm-9">
                                   <textarea name="remark" id="remark" class="form-control" rows="3" placeholder="Type a short description"></textarea>
                                    @include('elements.feedback',['field' => 'remerk'])
                                </div>
                            </div>

                            <div class="form-group m-b-0 float-right"> 
                                <button type="submit" class="btn bg-theme text-white">{{__('messages.save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline">Operations</h4>
                    <hr class="hr-borderd">
                    <div class="col-lg-12">
                        <div class="Content">
                            <table class="table table-bordered table-hover Content" id="dataTableNoPagingDesc">
                                <thead>
                                    <tr class="">
                                        <th width="50">SL</th>
                                        <th>Operation Date</th>
                                        <th>Patient Name</th>
                                        <th>Operation Name</th>
                                        <th class="text-right">Grand Total</th> 
                                        <th class="text-right">Due</th>  
                                        <th width="100">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php $i = 0; @endphp
                                @foreach($opertions as $row)
                                    <tr>
                                        <td>{{sprintf('%02d',++$i)}}</td>
                                        <td>{{Pharma::dateFormat($row->date) }} {{ date('g:i a', strtotime($row->time)) }}</td>
                                        <td>{{ $row->patient->patient_name }}</td> 
                                        <td>{{ $row->operation_service_name }}</td> 
                                        <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->grand_total) }}</td> 
                                        <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->due)}}</td>  
                                        <td style="display: flex; justify-content: space-evenly;">  
                                        <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/operation/invoice/a4/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> A4</a> 
                                        <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/operation/invoice/pos/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> Pos</a>   
                                        <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('hospital/operation/'.$row->slug.'/edit') }}"><i class="fa fa-edit"></i></a>   
                                        <form action="{{url('hospital/operation/void/'.$row->slug)}}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
                                            @csrf
                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$row->id}})"><i class="mdi mdi-backup-restore"></i> Void</button>
                                        </form>
                                    </tr> 
                                    @endforeach                        
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
@include('elements.dataTableOne')
@endsection

@push('css')
<link href="{{ asset('material') }}/assets/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
    <style>
        .disabled{
            opacity: .5;
            pointer-events: none;
        }
    </style>
@endpush

@push('js')
<script src="{{ asset('material') }}/assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>
    <script>
        $('#single-input').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
            'default': 'now'
        });
        $('.clockpicker').clockpicker({
            donetext: 'Done',
        }).find('input').change(function() {
            console.log(this.value);
        });
        $('#check-minutes').click(function(e) {
            // Have to stop propagation here
            e.stopPropagation();
            input.clockpicker('show').clockpicker('toggleView', 'minutes');
        });
        if (/mobile/i.test(navigator.userAgent)) {
            $('input').prop('readOnly', true);
        }

        $('#patient_id').change(function(){
            const patient_id = parseFloat($(this).val())||0;
            if(patient_id > 0){
                $('#operation_field').removeClass('disabled');
            }
        });

        $('#operation_type_id').change(function(){
            const type_id = parseFloat($(this).val())||0;
            $.ajax({
                type: "GET",
                url: "{{url('hospital/hmstypeservice')}}/"+type_id,
                data: "data",
                dataType: "text",
                success: function (response) {
                    $('#operation_service_id').html(response);
                    $('#price').val(0);
                    $('#grand_total').val(0);
                    $('#paid_amount').val(0);
                }
            });
        });

        $('#operation_service_id').change(function(){
            const operation_service_id = parseFloat($(this).val())||0;
            $.ajax({
                type: "GET",
                url: "{{url('hospital/hmsoperationprice')}}/"+operation_service_id,
                data: "data",
                dataType: "text",
                success: function (response) {
                    $('#price').val(response);
                    $('#grand_total').val(response);
                    $('#paid_amount').val(response);
                }
            });
        });

        $('#discount').on('change keyup', function(){
            const discount = parseFloat($(this).val())||0;
            const price = parseFloat($('#price').val())||0;
            const afterDis = parseFloat(price)-parseFloat(discount);
            
            $('#grand_total').val(parseFloat(afterDis));
            $('#paid_amount').val(parseFloat(afterDis));
        });

        $('#paid_amount').on('change keyup', function(){
            const paid_amount = parseFloat($(this).val())||0;            
            const grand_total = $('#grand_total').val();
            findDueandChange(grand_total,paid_amount);
            
        });

        function findDueandChange(grand_total,paid_amount){
            const due   = parseFloat(grand_total).toFixed(2) - parseFloat(paid_amount).toFixed(2);
            if(grand_total < paid_amount){
                $('#due').val('0.00');
                $('#change').val(parseFloat(parseFloat(paid_amount)-parseFloat(grand_total)).toFixed(2));
                $('#change-field').removeClass('d-none');
                $('#due-field').addClass('d-none');
            }else{
                $('#change-field').addClass('d-none');
                $('#due-field').removeClass('d-none');
                $('#due').val(parseFloat(due).toFixed(2));
                $('#change').val('0.00');
            }
        }
    </script>
@endpush
