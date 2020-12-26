@extends('layout.app',['pageTitle' => 'Received Reports'])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.received_report') }}
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
                                <label for="text">{{ __('messages.manufacturer') }}</label>
                                <select name="customer" class="form-control">
                                    <option value="All">All</option>
                                    <?php echo Pharma::getOptions($customers,'patient_name',$search['customer'],'slug')?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn search-btn"><i class="fa fa-search"></i></button>
                                <a class="btn search-btn-reset" href="{{url('reports/received')}}"><i class="fa fa-refresh"></i></a>
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
                                        <th width="50" class="text-center">{{__('messages.sl')}}</th>
                                        <th>{{__('messages.date')}}</th>
                                        <th>{{__('messages.invoice')}}</th>
                                        <th>{{ __('messages.customer') }}</th>
                                        <th class="text-right">{{__('messages.received_amount')}}</th>
                                        <th class="text-right">{{__('messages.transaction_Way')}}</th>
                                        <th class="text-right">{{__('messages.description')}}</th>
                                    </tr>
                                    </thead>
                            
                                    <tbody>
                                    @php $i = $Tamount = 0;@endphp
                                    @foreach($received as $rec)
                                    @php $Tamount += $rec->amount @endphp
                                    <tr>
                                        <td class="text-center">{{sprintf('%02d',++$i)}}</td>
                                        <td>{{Pharma::dateFormat($rec->date)}}</td>
                                        <td>{{$rec->trans_id}}</td>
                                        <td>{{$rec->patient->patient_name}}</td>
                                        <td class="text-right payAmount">{{Pharma::amountFormatWithCurrency($rec->amount,'-')}}</td>
                                        <td class="text-right">{{$rec->transaction_way}}</td>
                                        <td class="text-right"><?php echo $rec->description?></td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <td colspan="4" class="text-right font-weight-bold">{{ __('messages.total') }}:</td>
                                        <td class="text-right font-weight-bold" id="payAmount">{{Pharma::amountFormatWithCurrency($Tamount)}}</td>
                                        <td class="text-right font-weight-bold" colspan="2"></td>
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
        var payAmount = 0;
        $(".payAmount").each(function(){
            var v = $(this).text().split('{{Pharma::getCurrency()}}');
            v = v[1];
            if(isNaN(v)){ v = $(this).text();}
            payAmount = parseFloat(payAmount) + parseFloat(v);
        });
        $('#payAmount').text('{{Pharma::getCurrency()}}'+parseFloat(payAmount).toFixed(2));
    }

</script>
@endpush --}}