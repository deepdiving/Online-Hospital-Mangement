@extends('layout.app',['pageTitle' => 'Expense Reports'])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.expence_report') }}
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
                                <label for="text">{{ trans_choice('messages.category',1) }}</label>
                                <select name="category" class="form-control">
                                    <option value="All">All</option>
                                    <?php echo Pharma::getOptions($categories,'category_name',$search['category'],'slug')?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn search-btn"><i class="fa fa-search"></i></button>
                                <a class="btn search-btn-reset" href="{{url('reports/expense')}}"><i class="fa fa-refresh"></i></a>
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
                                        <th width="50">{{ __('messages.sl') }}</th>
                                        <th>{{ __('messages.date') }}</th>
                                        <th>{{ trans_choice('messages.category',10) }}</th>
                                        <th class="text-right">{{ __('messages.grand_total') }}</th>
                                        <th class="text-right">{{ __('messages.payment_type') }}</th>
                                    </tr>
                                    </thead>
                            
                                    <tbody>
                                    <?php $i = $Tamount =0;?>
                                    @foreach($expenses as $expense)
                                    @php $Tamount += $expense->amount @endphp
                                    <tr>
                                        <td>{{sprintf('%02d',++$i)}}</td>
                                        <td>{{Pharma::dateFormat($expense->date)}}</td>
                                        <td>{{$expense->category->category_name}}</td>
                                        <td class="text-right Tamount">{{Pharma::amountFormatWithCurrency($expense->amount,'-')}}</td>
                                        <td class="text-right">{{$expense->payment_type}}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <td colspan="3" class="text-right font-weight-bold">{{ __('messages.total') }}:</td>
                                        <td class="text-right font-weight-bold" id="Tamount">{{Pharma::amountFormatWithCurrency($Tamount)}}</td>
                                        <td class="text-right font-weight-bold" id=""></td>
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
        var Tamount = 0;
        $(".Tamount").each(function(){
            var v = $(this).text().split('{{Pharma::getCurrency()}}');
            v = v[1];
            if(isNaN(v)){ v = $(this).text();}
            Tamount = parseFloat(Tamount) + parseFloat(v);
        });
        $('#Tamount').text('{{Pharma::getCurrency()}}'+parseFloat(Tamount).toFixed(2));
    }

</script>
@endpush --}}