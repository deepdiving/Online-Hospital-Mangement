@extends('layout.app',['pageTitle' => 'Tax Reports'])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.tax_report') }}
    @endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-12" style="display: flex; justify-content: space-between;">
                    Total Tax:
                    <h4>{{Pharma::amountFormatWithCurrency($total)}}</h4> Total Paid:
                    <h4>{{Pharma::amountFormatWithCurrency($paid)}}</h4> Dues:
                    <h4><a href="{{url('taxes/payment')}}">{{Pharma::amountFormatWithCurrency($due)}}</a></h4>
                    <form action="" method="get" class="form-inline search">
                        <div class="form-group">
                            <label for="text">Date From</label>
                            <input type="text" name="start" value="{{$search['start']}}" class="form-control datepickerDB">
                        </div>
                        <div class="form-group">
                            <label for="text">Date To</label>
                            <input type="text" name="end" value="{{$search['end']}}" class="form-control datepickerDB">
                        </div>
                        <div class="form-group">
                            <button class="btn search-btn"><i class="fa fa-search"></i></button>
                            <a class="btn search-btn-reset" href="{{url('taxes')}}"><i class="fa fa-refresh"></i></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Taxes List</h4>
                <div class="Content">
                    <table class="table table-bordered table-hover" id="">
                        <thead>
                            <tr class="">
                                <th width="50">{{__('SL')}}</th>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Sale Invoice')}}</th>
                                <th class="text-right">{{__('Amount')}}</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $i = $sum = 0;?>
                                @foreach($taxes as $tax)
                                @php $sum += $tax->amount @endphp
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>
                                    <td>{{Pharma::dateFormat($tax->date)}}</td>
                                    <td>{{$tax->sale_invoice}}</td>
                                    <td class="text-right Tamount">{{Pharma::amountFormatWithCurrency($tax->amount)}}</td>
                                </tr>
                                @endforeach
                        </tbody>
                        <tfoot>
                            <td colspan="3" class="text-right font-weight-bold">Total:</td>
                            <td class="text-right font-weight-bold"> {{Pharma::amountFormatWithCurrency($sum)}}</td>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Taxes Payments List</h4>
                <div class="Content">
                    <table class="table table-bordered table-hover" id="">
                        <thead>
                            <tr class="">
                                <th width="50">{{__('SL')}}</th>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Description')}}</th>
                                <th class="text-right">{{__('Amount')}}</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $i = $sum = 0;?>
                                @foreach($paidList as $tax)
                                @php $sum += $tax->amount @endphp
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td>
                                    <td>{{Pharma::dateFormat($tax->date)}}</td>
                                    <td>{{$tax->description}}</td>
                                    <td class="text-right Tamount">{{Pharma::amountFormatWithCurrency($tax->amount)}}</td>
                                </tr>
                                @endforeach
                        </tbody>
                        <tfoot>
                            <td colspan="3" class="text-right font-weight-bold">Total:</td>
                            <td class="text-right font-weight-bold"> {{Pharma::amountFormatWithCurrency($sum)}}</td>
                        </tfoot>
                    </table>
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
        var Tamount = 0;
        $(".Tamount").each(function(){
            var v = $(this).text().split('{{Pharma::getCurrency()}}');
            v = v[1];
            if(isNaN(v)){ v = $(this).text();}
            Tamount = parseFloat(Tamount) + parseFloat(v);
        });
        $('#Tamount').text('{{Pharma::getCurrency()}} '+parseFloat(Tamount).toFixed(2));
    }

</script>
@endpush --}}