@extends('layout.app',['pageTitle' => __('All Transactions')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.transaction') }}
    @endslot
@endcomponent
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <form action="" method="get" class="form-inline float-right search">
                            <div class="form-group">
                                <label for="text">{{ __('messages.date_from') }}</label>
                                <input type="text" name="start" value="{{$search['start']}}" class="form-control datepickerDB">
                            </div>
                            <div class="form-group">
                                <label for="text">{{ __('messages.date_to') }}</label>
                                <input type="text" name="end" value="{{$search['end']}}" class="form-control datepickerDB">
                            </div>
                            <div class="form-group">
                                <label for="text">{{ __('messages.payment_type') }}</label>
                                <select name="type" class="form-control">
                                    <option value="All" {{($search['type'] == 'All')?'Selected':''}}>All</option>
                                    <option value="Payment" {{($search['type'] == 'Payment')?'Selected':''}}>OnPayment</option>
                                    <option value="Received" {{($search['type'] == 'Received')?'Selected':''}}>OnSale</option>
                                    <option value="Collection" {{($search['type'] == 'Collection')?'Selected':''}}>Due Collection</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary">Search</button>
                                <a href="{{url('reports/cash-flow')}}" class="btn btn-success ml-2">See All</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="Content">
                                <table class="table table-bordered table-hover Content" id="dataTableNoPaging">
                                    <thead>
                                    <tr class="tableHead">
                                        <th width="50">{{__('SL')}}</th>
                                        <th>{{__('messages.date')}}</th>
                                        <th>{{__('messages.trans_id')}}</th>
                                        <th>{{__('messages.vendor_name')}}</th>
                                        <th class="text-right" width="150px">{{__('messages.payment')}}</th>
                                        <th class="text-right" width="150px">{{__('messages.received')}}</th>
                                        <th width="25%">{{__('messages.description')}}</th>
                                    </tr>
                                    </thead>
                            
                                    <tbody>
                                    <?php $i = $Tpayment = $Treceived = 0;?>
                                    @foreach($transactions as $trans)
                                        <tr>
                                            <td>{{sprintf('%02d',++$i)}}</td>
                                            <td>{{date('M d, Y',strtotime($trans->date))}}</td>
                                            <td>{{$trans->trans_id}}</td>
                                            <td>
                                                @if($trans->vendor == 'Patient')
                                                    {{$trans->patient->patient_name}}
                                                @elseif($trans->vendor == 'Manufacturer')
                                                    {{$trans->manufacturer->manufacturer_name}}
                                                @else
                                                    {{$trans->expenseCat->category_name}}
                                                @endif
                                            </td>
                                            @if($trans->transaction_type == 'Payment')
                                                <td class="text-right singlepayment">{{Pharma::amountFormatWithCurrency($trans->amount,'-')}}</td>
                                                @php $Tpayment += $trans->amount @endphp  
                                                <td class="text-right singlereceived">-</td>
                                            @else
                                                <td class="text-right singlepayment">-</td>
                                                <td class="text-right singlereceived">{{Pharma::amountFormatWithCurrency($trans->amount,'-')}}</td>
                                                @php $Treceived += $trans->amount @endphp
                                            @endif
                                            <td><?php echo Pharma::limit_text($trans->description,20)?></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <td colspan="4" class="text-right font-weight-bold">{{__('messages.total')}}:</td>
                                        <td class="text-right font-weight-bold" id="TotalPayment">{{Pharma::amountFormatWithCurrency($Tpayment)}}</td>
                                        <td class="text-right font-weight-bold" id="TotalReceived">{{Pharma::amountFormatWithCurrency($Treceived)}}</td>
                                        <td></td>
                                    </tfoot>
                            </table>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    @include('elements.dataTableOne')
@endsection
{{-- @push('js')
<script>
    $(document).ready(function(){
        getTotalAmount();
    });

    $('div#dataTableNoPaging_filter input').on('keyup keypress change',function(){
        setTimeout(function(){
            getTotalAmount();
        },100);
    });
    function getTotalAmount(){
        var tpayment = 0;
        var treceived = 0;
        $(".singlepayment").each(function(){
            var v = $(this).text().split('{{Pharma::getCurrency()}}');
            v = v[1];
            if(isNaN(v)){ v = parseFloat($(this).text())||0;}
            tpayment = parseFloat(tpayment) + parseFloat(v);
        });
        $(".singlereceived").each(function(){
            var v = $(this).text().split('{{Pharma::getCurrency()}}');
            v = v[1];
            if(isNaN(v)){ v = parseFloat($(this).text())||0;}
            treceived = parseFloat(treceived) + parseFloat(v);
        });
        $('#TotalPayment').text('{{Pharma::getCurrency()}}'+parseFloat(tpayment).toFixed(2));
        $('#TotalReceived').text('{{Pharma::getCurrency()}}'+parseFloat(treceived).toFixed(2));
    }

</script>
@endpush --}}