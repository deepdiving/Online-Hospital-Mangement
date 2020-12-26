
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
                            <div class="d-flex justify-content-between">
                                <p>
                                    <b>ID :</b> #{{ sprintf('%04d',$slip->employee->id) }} <br>
                                    <b>Name :</b>  {{ $slip->employee->name }} <br>
                                    <b>Position :</b> {{ $slip->employee->position->name }}
                                </p>
                                <p>
                                    <b>Id :</b> #{{sprintf('%04d',$slip->id)}} <br>
                                    <b>Date :</b> {{$slip->date}} <br>
                                    <b>Salary For :</b> {{date('F Y',strtotime($slip->year.'-'.$slip->month.'-01'))}}
                                </p>
                            </div>
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
                                            @foreach($slip->empPaidSalaryStr as $row)
                                            @if($row->type == 'Add')
                                                @php $TotalAdditon += $row->amount @endphp
                                                <tr>
                                                    <td>{{$row->structure}} <b>({{$row->percent}}%)</b></td>
                                                    <td class="text-right"><i class="mdi mdi-plus-box-outline"></i> {{Pharma::amountFormatWithCurrency($row->amount)}}</td>
                                                </tr>
                                            @else
                                                @php $TotalDeduct += $row->amount @endphp
                                                <tr>
                                                    <td>{{$row->structure}} <b>({{$row->percent}}%)</b> </td>
                                                    <td class="text-right"><i class="mdi mdi-minus-box-outline"></i> {{Pharma::amountFormatWithCurrency($row->amount)}}</td>
                                                </tr>
                                            @endif

                                            @endforeach

                                            <tr>
                                                <td>Extra Addtions</td>
                                                <td class="text-right"><i class="mdi mdi-plus-box-outline"></i> {{Pharma::amountFormatWithCurrency($slip->addamount)}}</td>
                                            </tr>
                                            <tr>
                                                <td>Extra Subtraction</td>
                                                <td class="text-right"><i class="mdi mdi-minus-box-outline"></i> {{Pharma::amountFormatWithCurrency($slip->deductamount)}}</td>
                                            </tr>
                                            <tr class="bg-theme text-white font-weight-bold display-6">
                                                <td>Total </td>
                                                <td class="text-right display-6">{{Pharma::amountFormatWithCurrency($salary = ($basic + $TotalAdditon + $slip->addamount) - ($TotalDeduct + $slip->deductamount))}}</td>
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