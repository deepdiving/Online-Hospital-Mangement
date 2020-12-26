
@extends('layout.app',['pageTitle' => 'Salary Slip'])
@section('content')

@push('css')

@endpush   
<div class="row  m-t-40"> 
    <div class="col-md-2"></div>
    <div class="col-lg-8 col-md-8"> 
        <button class="btn btn-success m-t-40 buttonstyle" onclick="invoiceprint()">Print</button>
        <div class="card m-t-20">
            <div class="card-body"> 
                <div id="printArea">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <h4 class="text-center font-weight-bold">HRM {{session()->get('settings')[0]['site_name']}}</h4>
                            <p class="text-center">{{session()->get('settings')[0]['address']}} {{session()->get('settings')[0]['phone_number']}} <br> Salary Slip</p>
                            <p class="text-left font-weight-bold">
                                ID: # {{ $slip->employee->id }} <br>
                                Employee Name:  {{ $slip->employee->name }} <br>
                                Employee Position: {{ $slip->employee->position->name }}<br>
                                Employee Addres:  {{ $slip->employee->address }} <br>
                                Mobile No: {{ $slip->employee->phone_no }}
                            </p>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8 py-4 my-4">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Particular</th>
                                                <th class="text-right">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Basic</td>
                                                <td class="text-right">{{Pharma::amountFormatWithCurrency($basic=$slip->basic_salary)}}</td>
                                            </tr>
                                            @php $TotalAdditon = $TotalDeduct = 0; @endphp
                                            @foreach($slip->employee->empSalaryStr as $row)
                                            @if($row->salarystr->type == 'Add')
                                                <tr>
                                                    <td>{{$row->salarystr->title}} <b>({{$row->amount}}%)</b></td>
                                                    <td class="text-right"><i class="mdi mdi-plus-box-outline"></i> {{Pharma::amountFormatWithCurrency($TotalAdditon += $row->amount/100*$basic)}}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{$row->salarystr->title}} <b>({{$row->amount}}%)</b> </td>
                                                    <td class="text-right"><i class="mdi mdi-minus-box-outline"></i> {{Pharma::amountFormatWithCurrency($TotalDeduct += $row->amount/100*$basic)}}</td>
                                                </tr>
                                            @endif

                                            @endforeach

                                            <tr>
                                                <td>Extra Addtions</td>
                                                <td class="text-right"><i class="mdi mdi-plus-box-outline"></i> {{Pharma::amountFormatWithCurrency($TotalAdditon += $slip->addamount)}}</td>
                                            </tr>
                                            <tr>
                                                <td>Extra Subtraction</td>
                                                <td class="text-right"><i class="mdi mdi-minus-box-outline"></i> {{Pharma::amountFormatWithCurrency($TotalDeduct += $slip->deductamount)}}</td>
                                            </tr>
                                            <tr class="bg-theme text-white font-weight-bold display-6">
                                                <td>Total </td>
                                                <td class="text-right display-6">{{Pharma::amountFormatWithCurrency($salary = $basic + $TotalAdditon - $TotalDeduct)}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="my-4 pb-4">
                        <b>In Word: </b> {{Pharma::convertNumberToWord($salary)}}
                    </div>
                    <div class="d-flex justify-content-between pt-3">
                        <div> 
                            <p>Employee Signature......................................</p>
                        </div> 
                        <div> 
                            <p>Reference Signature......................................</p>
                        </div> 
                        <div> 
                            <p>paid By.................................................</p>
                        </div>
                    </div> 
                </div>      
            </div>
        </div>  
   </div>
</div>
@endsection
@push('js')
<script src='{{ asset('js') }}/print.js'></script>
<script>
    function invoiceprint(){
        $("#printArea").print();
    }   
</script>
@endpush