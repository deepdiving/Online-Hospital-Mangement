@extends('layout.app',['pageTitle' =>'Operation Service'])
@section('content')

@include('elements.alert')

<div class="row p-t-30">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Operation Service</h4>
                    <hr class="hr-borderd">
                    <form class="form-material m-t-10 form" action="{{ route('operation.update',$operation) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group row {{ $errors->has('patient_id') ? ' has-danger' : '' }}">
                            <label for="patient_id" class="col-sm-3 text-right control-label col-form-label">Patient<sup class="text-danger font-bold">*</sup> :</label>      
                            <div class="col-sm-9">
                                <input type="text" readonly value="{{old('patient_id',$operation->patient->patient_name)}}" class="form-control">
                                @include('elements.feedback',['field' => 'patient_id'])
                            </div> 
                        </div>

                        <div class="form-group row {{ $errors->has('operation_type_id') ? ' has-danger' : '' }}">
                            <label for="operation_type_id" class="col-sm-3 text-right control-label col-form-label">Date<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-6">
                                <input type="text" name="date" value="{{$operation->date}}" class="form-control datepickerDB" id="date" placeholder="Delivary date" required autocomplete="off">
                            </div> 
                            <div class="col-sm-3">
                                <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                    <input type="text" name="time" required class="form-control" value="{{$operation->time}}"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                                    </div>
                            </div> 
                        </div>

                        <div class="form-group row {{ $errors->has('operation_service_id') ? ' has-danger' : '' }}">
                            <label for="operation_service_id" class="col-sm-3 text-right control-label col-form-label">Oparation<sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-9">
                                <input type="text" readonly value="{{old('operation_service_id',$operation->operation_service_name)}}" class="form-control">
                                @include('elements.feedback',['field' => 'operation_service_id'])
                            </div> 
                        </div> 
                        <div class="form-group row {{ $errors->has('price') ? ' has-danger' : '' }}">
                            <label for="price" class="col-sm-3 text-right control-label col-form-label">{{__('messages.price_in')}} <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-9">
                                <input type="number" name="price" value="{{old('price',$operation->operation_service_price)}}" readonly class="form-control" id="price" placeholder="Price" required autocomplete="off">
                                @include('elements.feedback',['field' => 'price'])
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('discount') ? ' has-danger' : '' }}">
                            <label for="discount" class="col-sm-3 text-right control-label col-form-label">Discount <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-9">
                                <input type="number" name="discount" value="{{old('discount',$operation->discount)}}" class="form-control" id="discount" placeholder="Discount Amount" required autocomplete="off">
                                @include('elements.feedback',['field' => 'discount'])
                            </div>
                        </div>       
                        <div class="form-group row {{ $errors->has('grand_total') ? ' has-danger' : '' }}">
                            <label for="grand_total" class="col-sm-3 text-right control-label col-form-label">Grand Total <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-9">
                                <input type="number" name="grand_total" readonly value="{{old('grand_total',$operation->grand_total)}}" class="form-control" id="grand_total" placeholder="grand_total" required autocomplete="off">
                                @include('elements.feedback',['field' => 'grand_total'])
                            </div>
                        </div>       
                        <div class="form-group row {{ $errors->has('paid_amount') ? ' has-danger' : '' }}">
                            <label for="paid_amount" class="col-sm-3 text-right control-label col-form-label">Pay Amount <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-9">
                                <input type="number" name="paid_amount" value="{{old('paid_amount',$operation->paid_amount)}}" class="form-control" id="paid_amount" placeholder="Paid Amount" required autocomplete="off">
                                @include('elements.feedback',['field' => 'paid_amount'])
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('due') ? ' has-danger' : '' }} d-none" id="due-field">
                            <label for="due" class="col-sm-3 text-right control-label col-form-label">Due <sup class="text-danger font-bold">*</sup> :</label>
                            <div class="col-sm-9">
                                @if($operation->due_collection > 0)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" readonly value="{{ $was_due =  $operation->grand_total - $operation->paid_amount}}" class="form-control" placeholder="0.00" required autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="due_collection" readonly value="{{$operation->due_collection}}" class="form-control" id="due_collection" placeholder="0.00" required autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="due" value="{{$was_due - $operation->due_collection}}" class="form-control" id="due" placeholder="0.00" required autocomplete="off">
                                        </div>
                                    </div>
                                @else
                                    <input type="text" name="due" value="0.00" class="form-control" id="due" placeholder="0.00" required autocomplete="off">
                                    <input type="hidden" value="0" id="due_collection">
                                @endif
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
                                <textarea name="remark" id="remark" class="form-control" rows="3"> {{$operation->remark}}</textarea>
                                @include('elements.feedback',['field' => 'remerk'])
                            </div>
                        </div>

                        <div class="form-group m-b-0 float-right"> 
                            <a href="{{url('/hospital/operation/')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                            <button type="submit" class="btn bg-theme text-white">{{__('messages.update')}}</button>
                        </div>
                    </form>
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

        $('#discount').on('change keyup', function(){
            const discount = parseFloat($(this).val())||0;
            const price = parseFloat($('#price').val())||0;
            const due_collection       = parseFloat($('#due_collection').val())||0;
            const afterDis = parseFloat(price)-parseFloat(discount);
            
            $('#grand_total').val(parseFloat(afterDis));
            $('#paid_amount').val(parseFloat(afterDis)-parseFloat(due_collection));
        });

        $('#paid_amount').on('change keyup', function(){
            const paid_amount = parseFloat($(this).val())||0;            
            const grand_total = $('#grand_total').val();
            findDueandChange(grand_total,paid_amount);
            
        });
        $(document).ready(function(){
            const paid_amount = $('#paid_amount').val();
            const grand_total = $('#grand_total').val();
            findDueandChange(grand_total,paid_amount);
        });
        function findDueandChange(grand_total,paid_amount){

            const due   = parseFloat(grand_total).toFixed(2) - parseFloat(paid_amount).toFixed(2);
            const due_collection       = parseFloat($('#due_collection').val())||0;
            const total_pay = paid_amount + due_collection;
            if(grand_total < total_pay){
                $('#due').val('0.00');
                $('#change').val(parseFloat(parseFloat(total_pay)-parseFloat(grand_total)).toFixed(2));
                $('#change-field').removeClass('d-none');
                $('#due-field').removeClass('d-none');
            }else{
                $('#change-field').addClass('d-none');
                $('#due-field').removeClass('d-none');
                $('#due').val(parseFloat(due-due_collection).toFixed(2));
                $('#change').val('0.00');
            }

        }
    </script>
@endpush
