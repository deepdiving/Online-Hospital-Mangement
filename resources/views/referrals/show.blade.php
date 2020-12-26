@extends('layout.app',['pageTitle' => $DiagonReferral->name])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
       {{trans_choice('messages.referral',1)}}
    @endslot
@endcomponent
<style>
    .m-t{
        margin-top: -5%;
    }
</style>

@include('elements.alert')

    <div class="row">
        
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{trans_choice('messages.referral',1)}}</h4>
                    <hr class="hr-borderd">
                    <div class="row pt-3">
                        <div class="col-md-4 text-right">
                            <img src="{{asset('user-default.png')}}" class="img-thumbnail" alt="">
                        </div>
                        <div class="col-md-8 text-left">
                            <h3 class="display-5 pt-1">{{ucfirst($DiagonReferral->name)}}</h3>
                            <table class="table table-striped m-t-40">
                                <tr>
                                    <td width='200'>Registration Date</td>
                                    <td  width='5'>:</td>
                                    <td>{{Pharma::dateFormat($DiagonReferral->created_at)}}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td>{{$DiagonReferral->email}}</td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td>:</td>
                                    <td>{{$DiagonReferral->contact}}</td>
                                </tr>
                                <tr>
                                    <td>Designation</td>
                                    <td>:</td>
                                    <td>{{$DiagonReferral->designation}}</td>
                                </tr>
                            </table>
                            <a href="{{url('diagnostic/referrals/'.$DiagonReferral->id.'/edit')}}" class="btn bg-theme text-white">Edit</a>
                            <a href="{{route('referral.index')}}" class="btn bg-theme text-white">{{__('messages.back')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" id="paymentForm" class="form form-material">
                                @csrf
                                <input type="hidden" name="id" value="{{$DiagonReferral->id}}">
                                <input type="hidden" name="name" value="{{$DiagonReferral->name}}">
                            <table class="table">
                                <tr>
                                    <td width="50">Date</td>
                                    <td width="5">:</td>
                                    <td>
                                        <input type="text" required name="date" id="date" class="form-control datepickerDB" value="{{date('Y-m-d')}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50">Amount</td>
                                    <td width="5">:</td>
                                    <td>
                                        <input type="number" required name="amount" id="amount" value="0" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50">Narration</td>
                                    <td width="5">:</td>
                                    <td>
                                        <textarea class="form-control" name="description" required id="description" placeholder="Write a short note about the payment." rows="5"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50">Module</td>
                                    <td width="5">:</td>
                                    <td>
                                        <select name="module" required class="form-control" id="">
                                            <option value="Diagnostic">Diagnostic</option>
                                            <option value="Hospital">Hospital</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right">
                                        <button id="payment" class="btn bg-theme text-white">Payment</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 ">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Payment History</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="themeThead">
                                        <th width="80" class="text-center"> {{ __('messages.sl')}}</th>
                                        <th>Date</th>
                                        <th>Transaction Id</th>
                                        <th class="text-right">{{ __('messages.paid_amount')}}</th>
                                        <th>Narration</th>
                                    </tr>
                                </thead>
                                <tbody id="paymentBody">
                                    <?php $i = $total = 0;?>
                                    @forelse($DiagonReferral->payments as $payment)
                                    @php $total += $payment->amount @endphp
                                    <tr>
                                        <td class="text-center">{{sprintf('%02d',++$i)}}</td>
                                        <td>{{Pharma::dateFormat($payment->date)}}</td>
                                        <td>{{$payment->transation->trans_id}}</td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($payment->amount)}}</td>
                                        <td>{{$payment->description}}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4">No Payment</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr class="font-weight-bold">
                                        <td class="text-right" colspan="3">Total</td>
                                        <td class="text-right" id="totalPayment">{{Pharma::amountFormatWithCurrency($total)}}</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-6 col-md-6">
            <div class="row">
                <div class="col-lg-12 col-md-12 ">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Diagnostic Reference History</h4>
                            <div class="searcfield d-flex mb-2"> <form action="" method="get" class="form-inline float-right search">
                                    <div class="form-group">
                                        <label for="text">{{ __('messages.date_from')}}</label>
                                        <input type="text" name="start" value="{{$search['start']}}" class="form-control datepickerDB">
                                    </div>
                                    <div class="form-group" style="margin-left:-15px;">
                                        <label for="text">{{ __('messages.date_to')}}</label>
                                        <input type="text" name="end" value="{{$search['end']}}" class="form-control datepickerDB">
                                    </div>
                                    <button class="btn ml-1 bg-theme text-white">Search</button>
                                    <a href="{{url('diagnostic/referrals/'.$DiagonReferral->id)}}" class="btn bg-theme text-white ml-1">Clear</a>
                                </form>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="themeThead">
                                        <th width="80" class="text-center"> {{ __('messages.sl')}}</th>
                                        <th>Date</th>
                                        <th>Invoice</th>
                                        <th class="text-right">{{ __('messages.grand_total')}}</th>
                                        <th>Patient Name</th>
                                        <th width='150'>{{ __('messages.action')}}</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                    <?php $i = $total = 0;?>
                                    @foreach($ref_data as $row)
                                    @php $total += $row->grand_total @endphp
                                    <tr>
                                        <td class="text-center">{{ sprintf("%02s",++$i) }}</td>
                                        <td>{{ Pharma::dateFormat($row->date) }}</td>
                                        <td>{{ $row->invoice }}</td>
                                        <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->grand_total) }}</td>
                                        <td>{{ $row->patient->patient_name }}</td>
                                        <td style="display: flex; justify-content: space-evenly;">
                                            <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('diagnostic/bill/invoice/a4/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> A4</a>
                                            <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('diagnostic/bill/invoice/pos/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> Pos</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="font-weight-bold">
                                        <td colspan="3" class="text-right">Total:</td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($total)}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            <h4 class="card-title">Hospital Reference History</h4>
                            <div class="searcfield d-flex mb-5"> <form action="" method="get" class="form-inline float-right search">
                                    <div class="form-group">
                                        <label for="text">{{ __('messages.date_from')}}</label>
                                        <input type="text" name="s_start" value="{{$searches['s_start']}}" class="form-control datepickerDB">
                                    </div>
                                    <div class="form-group" style="margin-left:-15px;">
                                        <label for="text">{{ __('messages.date_to')}}</label>
                                        <input type="text" name="s_end" value="{{$searches['s_end']}}" class="form-control datepickerDB">
                                    </div>
                                    <button class="btn ml-1 bg-theme text-white">Search</button>
                                    <a href="{{url('diagnostic/referrals/'.$DiagonReferral->id)}}" class="btn bg-theme text-white ml-1">Clear</a>
                                </form>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="themeThead">
                                        <th width="80" class="text-center"> {{ __('messages.sl')}}</th>
                                        <th>Date</th>
                                        <th>Invoice</th>
                                        <th>Grand Total</th>
                                        <th>Patient Name</th>
                                        <th width='150'>{{ __('messages.action')}}</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                    <?php $i = $total =  0;?>
                                    @foreach($referralhospital as $row)
                                    @php $total += $row->grand_total @endphp
                                    <tr>
                                        <td class="text-center">{{ sprintf("%02s",++$i) }}</td>
                                        <td>{{Pharma::dateFormat($row->admit_date) }} </td>
                                        <td>{{ $row->invoice }}</td>
                                        <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->grand_total) }}</td>
                                        <td>{{ $row->patient->patient_name }}</td>
                                        <td style="display: flex; justify-content: space-evenly;">
                                            <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/admission/invoice/a4/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> A4</a>
                                            <a class="btn waves-effect waves-light text-light btn-xs btn-primary" href="{{url('hospital/admission/invoice/pos/'.$row->invoice)}}"><i class="mdi mdi-format-align-justify"></i> Pos</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="font-weight-bold">
                                        <td colspan="3" class="text-right">Total:</td>
                                        <td class="text-right">{{Pharma::amountFormatWithCurrency($total)}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
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
<script src="{{ asset('js') }}/sweetalert.min.js"></script>
<script>
    $('#paymentForm').submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        var date = $('#date').val();
        var amount = parseFloat($('#amount').val())||0;
        var description = $('#description').val();
        if(date != "" && amount != "" && description != ""){
            console.log(data);
            $.ajax({
                type: "POST",
                url: "{{url('diagnostic/referral/payment')}}",
                data: data,
                dataType: "json",
                beforeSend: function(){
                    swal("Stock added Successed", {icon: "success",buttons: false,timer: 1000});
                },
                success: function (response) {
                    if(response.status === 'OK'){
                        $('#paymentBody').html(response.paymentData);
                        $('#totalPayment').html(response.total);
                        $('#paymentForm')[0].reset();
                    }
                }
            });
        }
    });
</script>
@endpush
