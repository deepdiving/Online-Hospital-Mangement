<style>
    .disabled{
        pointer-events: none;
    }
</style>
<div class="row">
    <div class="col-md-6">
        <div class="card card-outline-inverse">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><i class="mdi mdi-food-variant"> </i> &nbsp;Diagnostic</h4>
            </div>
            <div class="card-body">
                <h4 class="card-title">Dues: <span class="text-danger font-weight-bold diagonTotalDue">{{Pharma::getDiagnosticDue($patient_id)}}</span></h4>
                <span data-toggle="modal" data-target=".diagnostic-due-collect-modal" class="btn btn-primary float-right diagon {{Pharma::getDiagnosticDue($patient_id) > 0 ? '':'disabled'}}">Collect</span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-outline-inverse">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><i class="mdi  mdi-pill"></i> &nbsp;Pharmecy</h4>
            </div>
            <div class="card-body">
                <h4 class="card-title">Dues: <span class="text-danger font-weight-bold pharmatotalDue">{{Pharma::getPharmecyDue($patient_id)}}</span></h4>
                    <span data-toggle="modal" data-target=".pharmacy-due-collect-modal" class="btn btn-primary float-right pharma  {{Pharma::getPharmecyDue($patient_id) > 0 ? '':'disabled'}}">Collect</span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-outline-inverse">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><i class="mdi mdi-clock-start"> </i> &nbsp;Operations</h4>
            </div>
            <div class="card-body">
                <h4 class="card-title">Dues: <span class="text-danger font-weight-bold operationTotalDue">{{Pharma::getOperationDue($patient_id)}}</span></h4>
                <span data-toggle="modal" data-target=".oparation-due-collect-modal" class="btn btn-primary float-right operation  {{Pharma::getOperationDue($patient_id) > 0 ? '':'disabled'}}">Collect</span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-outline-inverse">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><i class="mdi mdi-clock-start"> </i> &nbsp;Emergency</h4>
            </div>
            <div class="card-body">
                <h4 class="card-title">Dues: <span class="text-danger font-weight-bold emergencyTotalDue">{{Pharma::getEmergencyDue($patient_id)}}</span></h4>
                <span data-toggle="modal" data-target=".emergency-due-collect-modal" class="btn btn-primary float-right emergen  {{Pharma::getEmergencyDue($patient_id) > 0 ? '':'disabled'}}">Collect</span>
            </div>
        </div>
    </div>
    @if(!empty($patient->admission))
    <div class="col-md-6">
        <div class="card card-outline-inverse">
            @php
                $servicedue = Pharma::getAdmissionDue($patient_id);
                // $beddue = Pharma::bedChargeDue($patient_id);
            @endphp
            <div class="card-header">
                <h4 class="m-b-0 text-white"><i class="mdi mdi-bulletin-board"> </i> &nbsp;Admission</h4>
            </div>
            <div class="card-body">
                <h4 class="card-title">Dues: <span class="text-danger font-weight-bold admissionTotalDue">{{$ad_due = $servicedue}}</span></h4>
                <span data-toggle="modal" data-target=".admission-due-collect-modal" class="btn btn-primary float-right admit  {{$ad_due > 0 ? '':'disabled'}}">Collect</span>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-outline-inverse">
            @php
                $beddue = Pharma::getBedChargeCollection($patient_id);
            @endphp
            <div class="card-header">
                <h4 class="m-b-0 text-white"><i class="mdi mdi-bulletin-board"> </i> &nbsp;Bed Service</h4>
            </div>
            <div class="card-body">
                <h4 class="card-title">Dues: <span class="text-danger font-weight-bold bedTotalDue">{{$ad_due = $beddue}}</span></h4>
                <span data-toggle="modal" data-target=".bed-due-collect-modal" class="btn btn-primary float-right admit  {{$ad_due > 0 ? '':'disabled'}}">Collect</span>
            </div>
        </div>
    </div>

    @endif
</div>

@if(!empty($patient->admission))
<div class="modal fade admission-due-collect-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{route('dues.store')}}" class="form-material form" method="post">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Admission Dues History</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th class="">Items</th>
                            <th width="150" class="text-right">Due</th>
                        </tr>
                        <tr>
                            <td>Service Due</td>
                            <td><input type="number" readonly class="form-control text-right diagnoDue" value="{{number_format($totalDue = $servicedue +  $patient->admission->due_collection,2)}}"></td>
                        </tr>
                        {{-- <tr>
                            <td>Bed Charge</td>
                            <td><input type="number" readonly class="form-control text-right diagnoDue" value="{{$beddue}}"></td>
                        </tr> --}}
                        {{-- <tr>
                            <td>Total</td>
                            <td><input type="number" readonly class="form-control text-right" value="{{$servicedue}}"></td>
                        </tr> --}}
                        <tr>
                            <td>Collection</td>
                            <td><input type="number" readonly class="form-control text-right" value="{{number_format($patient->admission->due_collection,2)}}"></td>
                        </tr>
                        <tr>
                            <td>Due</td>
                            <td><input type="number" readonly class="form-control text-right" value="{{number_format($totalDue - $patient->admission->due_collection,2)}}"></td>
                        </tr>
                        <tr>
                            <td>Collect Amount</td>
                            <td><input type="number" name="amount[]" class="form-control text-right" value="{{$totalDue - $patient->admission->due_collection}}"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="invoice[]" value="{{$patient->admission->id}}">
                    <input type="hidden" name="module" value="Hospital">
                    <input type="hidden" name="sub_module" value="Hospital-Admission">
                    <input type="hidden" name="table" value="hms_admissions">
                    <input type="hidden" name="patient_id" value="{{$patient_id}}">
                    <button type="submit" class="btn btn-danger waves-effect text-left">Collect Due</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bed-due-collect-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{route('bedcharge.store')}}" class="form-material form" method="post">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Bed Dues History</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td>SL</td>
                            <th>Date</th>
                            <th class="text-right">Amount</th>
                        </tr>
                        @php 
                            $total = $j = 0 ;
                            $bedPrice = $patient->admission->bed->price;
                            $bedId = $patient->admission->bed->id;
                            $discount = ($patient->bedchargecollection)?$patient->bedchargecollection->discount:0;
                            $stayDay = Pharma::two_date_diff($patient->admission->date, date('Y-m-d'));
                        @endphp

                        @for($i = 0; $i < $stayDay; $i++)
                            <tr>
                                <td>{{sprintf('%02d',++$j)}}</td>
                                <td>{{date('M d Y',strtotime("+".$i." day",strtotime($patient->admission->date)))}}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($bedPrice)}}</td>
                            </tr>
                            <input type="hidden" name="collection_dates[]" value="{{date('Y-m-d',strtotime("+".$i." day",strtotime($patient->admission->date)))}}">
                        @endfor
                            <input type="hidden" name="bed_charge" value="{{$bedPrice}}">
                        <tr class="font-weight-bold">
                            <td rowspan="7" class="text-right">
                                <textarea name="remark" class="form-control" rows="8" placeholder="Remark"></textarea>
                            </td>
                            <td class="text-right">Total</td>
                            <td><input type="number" class="form-control text-right" id="bed_sub_total" name="sub_total" readonly value="{{$i*$bedPrice}}"></td>
                        </tr>
                        <tr class="font-weight-bold">
                            <td class="text-right">Discount</td>
                            <td><input type="number" class="form-control text-right" name="discount" id="bed_discount" value="{{$discount}}"></td>
                        </tr>
                        <tr class="font-weight-bold">
                            <td class="text-right">Grand Total</td>
                            <td><input type="number" class="form-control text-right" name="grand_total" id="bed_grand_total" readonly value="{{$i*$bedPrice - $discount}}"></td>
                        </tr>
                        @if(!empty($patient->bedchargecollection))
                            <tr class="font-weight-bold">
                                <td class="text-right">Collection</td>
                                <td><input type="number" class="form-control text-right" name="collection" id="bed_collection" readonly value="{{$patient->bedchargecollection->paid_amount}}"></td>
                            </tr>
                        @else
                            <input type="hidden" id="bed_collection" value="0">
                        @endif
                        <tr class="font-weight-bold">
                            <td class="text-right">Paid Amount</td>
                            <td><input type="number" class="form-control text-right" name="paid_amount" id="bed_paid_amount" value="0"></td>
                        </tr>

                        <tr class="font-weight-bold d-none" id="bed_due_field">
                            <td class="text-right">Due</td>
                            <td><input type="number" class="form-control text-right" name="due" id="bed_due" readonly value="0"></td>
                        </tr>

                        <tr class="font-weight-bold d-none" id="bed_advange_field">
                            <td class="text-right">Advance</td>
                            <td><input type="number" class="form-control text-right" name="advance" id="bed_advange" readonly value="0"></td>
                        </tr>

                    </table>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="admission_id" value="{{$patient->admission->id}}">
                    <input type="hidden" name="patient_id" value="{{$patient_id}}">
                    <input type="hidden" name="bed_id" value="{{$bedId}}">
                    <button type="submit" class="btn btn-danger waves-effect text-left">Collect Due</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endif

<div class="modal fade diagnostic-due-collect-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{route('dues.store')}}" class="form-material form" method="post">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Diagnostic Dues History</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th>Date</th>
                            <th>Invoice</th>
                            <th class="text-right">Grand Total</th>
                            <th class="text-right">Discount</th>
                            <th class="text-right">Paid</th>
                            <th width="120" class="text-right">Due</th>
                            <th class="text-right">Collection</th>
                        </tr>
                        @php $total=0 @endphp
                        @foreach ($DueDiagnosticBill as $bill)
                            <tr>
                                <td>{{Pharma::dateFormat($bill->date)}}</td>
                                <td>{{$bill->invoice}}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($bill->grand_total)}}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($bill->discount_total)}}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($bill->paid_amount)}}</td>
                                <td><input type="number" name="amount[]" data-row="{{$bill->id}}" class="form-control text-right diagnoDue" value="{{($bill->due - $bill->due_collection)}}"></td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($bill->due_collection)}}</td>
                            </tr>
                            <input type="hidden" name="invoice[]" value="{{$bill->id}}">
                            <input type="hidden" id="bill{{$bill->id}}" value="{{($bill->due - $bill->due_collection)}}"/>
                            @php $total += $bill->due - $bill->due_collection @endphp
                        @endforeach
                        <tr class="font-weight-bold">
                            <td colspan="4" class="text-right">
                                <textarea name="description" class="form-control" rows="3" placeholder="Remark"></textarea>
                            </td>
                            <td class="text-right">Total</td>
                            <td><input type="number" class="form-control text-right" id="diagnoDueTotal" readonly value="{{$total}}"></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="module" value="Diagnostic">
                    <input type="hidden" name="sub_module" value="">
                    <input type="hidden" name="table" value="diagon_bills">
                    <input type="hidden" name="patient_id" value="{{$patient_id}}">
                    <button type="submit" class="btn btn-danger waves-effect text-left">Collect Due</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade pharmacy-due-collect-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{route('dues.store')}}" class="form-material form" method="post">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Pharmacy Dues History</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th>Date</th>
                            <th>Invoice</th>
                            <th class="text-right">Grand Total</th>
                            <th class="text-right">Discount</th>
                            <th class="text-right">Paid</th>
                            <th width="120" class="text-right">Due</th>
                            <th class="text-right">Collection</th>
                        </tr>
                        @php $total=0 @endphp
                        @foreach ($DuePharmacy as $sale)
                            <tr>
                                <td>{{Pharma::dateFormat($sale->date)}}</td>
                                <td>{{$sale->invoice}}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($sale->grand_total)}}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($sale->total_discount)}}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($sale->paid_amount)}}</td>
                                <td><input type="number" name="amount[]" data-row="{{$sale->id}}" class="form-control text-right pharmaSaleDue" value="{{($sale->new_balance - $sale->due_collection)}}"></td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($sale->due_collection)}}</td>
                            </tr>
                            <input type="hidden" name="invoice[]" value="{{$sale->id}}">
                            <input type="hidden" id="pharma{{$sale->id}}" value="{{($sale->new_balance - $sale->due_collection)}}"/>
                            @php $total += $sale->new_balance - $sale->due_collection @endphp
                        @endforeach
                        <tr class="font-weight-bold">
                            <td colspan="4" class="text-right">
                                <textarea name="description" class="form-control" rows="3" placeholder="Remark"></textarea>
                            </td>
                            <td class="text-right">Total</td>
                            <td><input type="number" class="form-control text-right" id="pharmaSaleDue" readonly value="{{$total}}"></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="module" value="Pharmacy">
                    <input type="hidden" name="sub_module" value="">
                    <input type="hidden" name="table" value="pharma_sales">
                    <input type="hidden" name="patient_id" value="{{$patient_id}}">
                    <button type="submit" class="btn btn-danger waves-effect text-left">Collect Due</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade oparation-due-collect-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{route('dues.store')}}" class="form-material form" method="post">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Operation Dues History</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th>Date</th>
                            <th>Invoice</th>
                            <th class="text-right">Grand Total</th>
                            <th class="text-right">Discount</th>
                            <th class="text-right">Paid</th>
                            <th width="120" class="text-right">Due</th>
                            <th class="text-right">Collection</th>
                        </tr>
                        @php $total=0 @endphp
                        @foreach ($DueOperation as $opa)
                            <tr>
                                <td>{{Pharma::dateFormat($opa->date)}}</td>
                                <td>{{$opa->invoice}}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($opa->grand_total)}}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($opa->discount)}}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($opa->paid_amount)}}</td>
                                <td><input type="number" name="amount[]" data-row="{{$opa->id}}" class="form-control text-right oparationSaleDue" value="{{($opa->due - $opa->due_collection)}}"></td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($opa->due_collection)}}</td>
                            </tr>
                            <input type="hidden" name="invoice[]" value="{{$opa->id}}">
                            <input type="hidden" id="oparation{{$opa->id}}" value="{{($opa->due - $opa->due_collection)}}"/>
                            @php $total += $opa->due - $opa->due_collection @endphp
                        @endforeach
                        <tr class="font-weight-bold">
                            <td colspan="4" class="text-right">
                                <textarea name="description" class="form-control" rows="3" placeholder="Remark"></textarea>
                            </td>
                            <td class="text-right">Total</td>
                            <td><input type="number" class="form-control text-right" id="oparationSaleDue" readonly value="{{$total}}"></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="module" value="Hospital">
                    <input type="hidden" name="sub_module" value="Hospital-Operation">
                    <input type="hidden" name="table" value="hms_operations">
                    <input type="hidden" name="patient_id" value="{{$patient_id}}">
                    <button type="submit" class="btn btn-danger waves-effect text-left">Collect Due</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade emergency-due-collect-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{route('dues.store')}}" class="form-material form" method="post">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Emergency Dues History</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th>Date</th>
                            <th>Invoice</th>
                            <th class="text-right">Grand Total</th>
                            <th class="text-right">Discount</th>
                            <th class="text-right">Paid</th>
                            <th width="120" class="text-right">Due</th>
                            <th class="text-right">Collection</th>
                        </tr>
                        @php $total=0 @endphp
                        @foreach ($DueEmergency as $emr)
                            <tr>
                                <td>{{Pharma::dateFormat($emr->date)}}</td>
                                <td>{{$emr->invoice}}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($emr->grand_total)}}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($emr->discount)}}</td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($emr->paid_amount)}}</td>
                                <td><input type="number" name="amount[]" data-row="{{$emr->id}}" class="form-control text-right emergencyDue" value="{{($emr->due - $emr->due_collection)}}"></td>
                                <td class="text-right">{{Pharma::amountFormatWithCurrency($emr->due_collection)}}</td>
                            </tr>
                            <input type="hidden" name="invoice[]" value="{{$emr->id}}">
                            <input type="hidden" id="emergency{{$emr->id}}" value="{{($emr->due - $emr->due_collection)}}"/>
                            @php $total += $emr->due - $emr->due_collection @endphp
                        @endforeach
                        <tr class="font-weight-bold">
                            <td colspan="4" class="text-right">
                                <textarea name="description" class="form-control" rows="3" placeholder="Remark"></textarea>
                            </td>
                            <td class="text-right">Total</td>
                            <td><input type="number" class="form-control text-right" id="emergencyDue" readonly value="{{$total}}"></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="module" value="Hospital">
                    <input type="hidden" name="sub_module" value="Hospital-Emergency">
                    <input type="hidden" name="table" value="hms_emergencies">
                    <input type="hidden" name="patient_id" value="{{$patient_id}}">
                    <button type="submit" class="btn btn-danger waves-effect text-left">Collect Due</button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('js')
<script>

    //BEd CHarge Collection Module

    $('#bed_discount').on('change keyup',function(){
        const subTotal = $('#bed_sub_total').val();
        const dis = $(this).val();
        const collection = $('#bed_collection').val();
        const grandTotal = parseFloat(subTotal) - parseFloat(dis);
        const paidAmount = parseFloat(grandTotal) - parseFloat(collection);
        $('#bed_grand_total').val(grandTotal);
        $('#bed_paid_amount').val(paidAmount);
        findDueandChangeBedCharge(grandTotal,paidAmount);
    });

    $('#bed_paid_amount').on('change keyup',function(){
        const paidAmount = parseFloat($(this).val())||0;
        const grandTotal = $('#bed_grand_total').val();
        const collection = $('#bed_collection').val();
        findDueandChangeBedCharge(grandTotal,parseFloat(paidAmount)+parseFloat(collection));
    });

    $(document).ready(function(){
        const grandTotal = $('#bed_grand_total').val();
        const paidAmount = $('#bed_paid_amount').val();
        const collection = $('#bed_collection').val();
        findDueandChangeBedCharge(grandTotal,collection);
    });


    function findDueandChangeBedCharge(grand_total,paid_amount){
        const due   = parseFloat(grand_total).toFixed(2) - parseFloat(paid_amount).toFixed(2);
        if(parseFloat(grand_total) < parseFloat(paid_amount)){
            $('#bed_due').val('0.00');
            $('#bed_advange').val(parseFloat(parseFloat(paid_amount)-parseFloat(grand_total)).toFixed(2));
            $('#bed_advange_field').removeClass('d-none');
            $('#bed_due_field').addClass('d-none');
        }else{
            $('#bed_advange_field').addClass('d-none');
            $('#bed_due_field').removeClass('d-none');
            $('#bed_due').val(parseFloat(due).toFixed(2));
            $('#bed_advange').val('0.00');
        }
    }


















    $('.diagnoDue').on('keyup change keypress',function(){
        var row = $(this).data('row');
        var amount = parseFloat($(this).val())||0;
        var max = parseFloat($('#bill'+row).val())||0;

        if(max < amount){
            alert('Please enter right figure..');
            $(this).val(max);
        }
        var total = 0;
        $('.diagnoDue').each(function(){
            total = parseFloat(total) + parseFloat($(this).val());
        });
        $('#diagnoDueTotal').val(total);
    });

    $('.pharmaSaleDue').on('keyup change keypress',function(){
        var row = $(this).data('row');
        var amount = parseFloat($(this).val())||0;
        var max = parseFloat($('#pharma'+row).val())||0;

        if(max < amount){
            alert('Please enter right figure..');
            $(this).val(max);
        }

        var total = 0;
        $('.pharmaSaleDue').each(function(){
            total = parseFloat(total) + parseFloat($(this).val()||0);
        });
        $('#pharmaSaleDue').val(total);
    });

    $('.oparationSaleDue').on('keyup change keypress',function(){
        var row = $(this).data('row');
        var amount = parseFloat($(this).val())||0;
        var max = parseFloat($('#oparation'+row).val())||0;

        if(max < amount){
            alert('Please enter right figure..');
            $(this).val(max);
        }

        var total = 0;
        $('.oparationSaleDue').each(function(){
            total = parseFloat(total) + parseFloat($(this).val()||0);
        });
        $('#oparationSaleDue').val(total);
    });

    $('.emergencyDue').on('keyup change keypress',function(){
        var row = $(this).data('row');
        var amount = parseFloat($(this).val())||0;
        var max = parseFloat($('#emergency'+row).val())||0;

        if(max < amount){
            alert('Please enter right figure..');
            $(this).val(max);
        }

        var total = 0;
        $('.emergencyDue').each(function(){
            total = parseFloat(total) + parseFloat($(this).val()||0);
        });
        $('#emergencyDue').val(total);
    }); 














//   $('.diagonTotalDue').ready(function(){ 
//       var diagonDue = $('.diagonTotalDue').text();   
//       //alert(diagonDue);
//       if(diagonDue == 0){
//          $('.diagon').prop('disabled', true);
//       }else{
//          $('.diagon').prop('disabled', false); 
//       } 
//   });

//   $('.pharmatotalDue').ready(function(){ 
//       var pharmaDue = $('.pharmatotalDue').text();   
//       //alert(pharmaDue);
//       if(pharmaDue == 0){
//          $('.pharma').prop('disabled', true);
//       }else{
//          $('.pharma').prop('disabled', false); 
//       }
      
//   });

//   $('.operationTotalDue').ready(function(){ 
//       var operationDue = $('.operationTotalDue').text();   
//       //alert(operationDue);
//       if(operationDue == 0){
//          $('.operation').prop('disabled', true);
//       }else{
//          $('.operation').prop('disabled', false); 
//       }
      
//   });

//   $('.emergencyTotalDue').ready(function(){ 
//       var emergenDue = $('.emergencyTotalDue').text();   
//       //alert(pharmaDue);
//       if(emergenDue == 0){
//          $('.emergen').prop('disabled', true);
//       }else{
//          $('.emergen').prop('disabled', false); 
//       }
      
//   });

//   $('.admissionTotalDue').ready(function(){ 
//       var admitDue = $('.admissionTotalDue').text();   
//       //alert(pharmaDue);
//       if(admitDue == 0){
//          $('.admit').prop('disabled', true);
//       }else{
//          $('.admit').prop('disabled', false); 
//       }
      
//   });

</script>
@endpush
