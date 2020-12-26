@extends('layout.app',['pageTitle' => 'Income Statement'])
@section('content')
@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.sale_report') }}
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
                                <input type="text" name="start" value="{{($data['start'] == '-') ? '-' : date('Y-m-d',strtotime($data['start']))}}" class="form-control datepickerDB">
                            </div>
                            <div class="form-group">
                                <label for="text">{{ __('messages.date_to') }}</label>
                                <input type="text" name="end" value="{{ ($data['end'] == '-') ? '-' : date('Y-m-d',strtotime($data['end']))}}" class="form-control datepickerDB">
                            </div>
                            <div class="form-group">
                                <label for="text">User</label>
                                <select name="user" id="user" class="form-control">
                                    <option value="">Select User</option>
                                    @foreach ($users as $row)
                                        <option value="{{ $row->id}}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn search-btn"><i class="fa fa-search"></i></button>
                                <a class="btn search-btn-reset" href="{{url('reports/admin-transaction')}}"><i class="fa fa-refresh"></i></a>
                                <button type="button" class="btn btn-success ml-3" style="padding: 10px 15px; border-radius:0px" onclick="invoiceprint()"> <i class="mdi mdi-printer"> </i> {{ __('messages.print') }} </button>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>

           
           <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                    <div class="Content" id="printJS-form">
                        <div class="invoiceHead text-center">
                            <h2>Admin - {{$siteInfo->site_name}}</h2>
                            <h3>User Income Statemetn</h3>
                            <h4>{{ __('messages.from')}} <b>{{ ($data['start'] == '-') ? 'First' : date('dS M Y', strtotime($data['start']))}} </b> {{ __('messages.to')}} <b>{{ ($data['end'] == '-') ? 'Last' : date('dS M Y', strtotime($data['end']))}}</b></h4>
                        </div>
                        <hr class="hr-borderd">
                        <div class="col-lg-12">
                            <div class="Content">
                                <table class="table table-bordered table-hover Content" id="myTable">
                                    <thead>
                                        <tr class="themeThead">
                                            <th width="50">{{__('messages.sl')}}</th>
                                            <th>Date</th>
                                            <th>#Id</th> 
                                            <th>User Name</th> 
                                            <th class="text-right">Amount</th> 
                                            <th>Moudle</th>
                                            <th class="text-right">Description</th>  
                                        </tr>
                                    </thead>
            
                                        <tbody>
                                        <?php $i = $total = 0;?>
                                        @foreach($user_trans as $row)
                                        @php $total += $row->amount @endphp
                                             <tr>
                                                <td>{{sprintf('%02d',++$i)}}</td>
                                                <td>{{  Pharma::dateFormat($row->date) }}
                                                <td>{{ $row->trans_id }}</td> 
                                                <td>{{ $row->user->name }}</td>  
                                                <td class="text-right">{{ Pharma::amountFormatWithCurrency($row->amount) }}</td>
                                                <td>{{ $row->module}}</td>
                                                <td class="text-right"><?php echo Pharma::limit_text($row->description,20)?></td>  
                                            </tr> 
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="font-weight-bold">
                                            <td></td>
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
        </div>   
    </div>
</div>
@include('elements.dataTableOne')
@endsection
@push('css')
<style>
    .wd60percent{ width: 60%;}
    .wd15percent{ width: 15%;}
    .wd25percent{ width: 25%;}
</style>
@endpush
@push('js')
<script src='{{ asset('js') }}/print.js'></script>
<script>
    function invoiceprint(){
        $("#printJS-form").print({
            addGlobalStyles : true,
            stylesheet : "{{ asset('css') }}/print.css",
            // rejectWindow : true,
            noPrintSelector : "#printSection,#footer",
            // iframe : false,
            append : null,
            prepend : "#footer"
        });
    }   
</script>
@endpush
