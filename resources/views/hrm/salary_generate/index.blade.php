@extends('layout.app',['pageTitle' => 'Salary Generate'])
@section('content')
@component('layout.inc.breadcrumb')
@slot('title')
Salary Generate
@endslot
@endcomponent 
@include('elements.alert')
<div class="row">
    <div class="col-lg-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <form class="form-material form" action="{{ route('generate.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <h3 class="form-title text-themecolor"><span>Salary Generate</span></h3>
                    <div class="row m-t-20">
                        <div class="form-group col-md-6 m-t-20">
                            <select name="month" class="form-control" id="">
                                {!!Pharma::getOptionArray([
                                    '01'    => 'Janurary',
                                    '02'    => 'February',
                                    '03'    => 'March',
                                    '04'    => 'April',
                                    '05'    => 'May',
                                    '06'    => 'June',
                                    '07'    => 'July',
                                    '08'    => 'August',
                                    '09'    => 'September',
                                    '10'    => 'October',
                                    '11'    => 'November',
                                    '12'    => 'December',
                                ])!!}
                            </select>
                        </div>                     
                        <div class="form-group col-md-6 m-t-20">
                            <select name="year" class="form-control" id="">
                                {!!Pharma::getOptionArray([
                                    '2020'      => '2020',
                                    '2021'      => '2021',
                                    '2022'      => '2022',
                                    '2023'      => '2023',
                                    '2024'      => '2024',
                                    '2025'      => '2025',
                                    '2026'      => '2026',
                                    '2027'      => '2027',
                                    '2028'      => '2028',
                                    '2029'      => '2029',
                                    '2030'      => '2030'
                                ])!!}
                            </select>
                        <input type="hidden" name="salary_track_id[]">
                        </div>
                        <div class="form-group col-md-12 text-right"> 
                            <span class="btn btn-bg btn-info" data-toggle="modal" data-target=".salary-generate">Generat</span>
                        </div>

                    </div>
               
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline">Salary Generate List</h4><br>
                <h6 class="card-subtitle d-inline">Salary Generate</h6>
                <hr class="hr-borderd">

            <div class="col-lg-12">
                <div class="Content">
                    <table class="table table-bordered table-hover Content" id="myTable">
                        <thead>
                            <tr class="themeThead">
                                <th width="50">{{__('messages.sl')}}</th>  
                                <th>Salary Name</th>
                                <th>Generate Date</th> 
                                <th>Generate By</th>
                                {{-- <th width="100">{{__('messages.action')}}</th> --}}
                            </tr>
                        </thead>

                         <tbody>
                            <?php $i = 0;?>
                            @foreach($genetateBy as $row)
                                <tr>
                                    <td>{{sprintf('%02d',++$i)}}</td> 
                                    <td>{{ date('F', mktime(0, 0, 0, $row->month)) }} {{ $row->year}}</td>
                                    <td>{{ Pharma::dateFormat($row->date) }}</td>
                                    <td>{{ $row->user->name }}</td> 
                                    {{-- <td style="display: flex; justify-content: space-evenly;"> 
                                        <form action="{{ url('salary/generate/'.$row->id) }}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$row->id}})"><i class="fa fa-trash-o"></i></button>
                                        </form>
                                    </td>  --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div> 
    </div>
</div>
<div class="modal fade salary-generate" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content"> 
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Salary Generate Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="Content">
                            <table class="table table-bordered table-hover Content" id="myTable">
                                <thead>
                                    <tr class="themeThead">
                                        <th width="50">{{__('messages.sl')}}</th>  
                                        <th>Employee</th>
                                        <th width="120" class="text-right" >Basic</th> 
                                        <th width="120" class="text-right" >Gross</th>
                                        <th width="120" class="text-right" >Add</th>
                                        <th width="120" class="text-right" >Decuct</th>
                                        <th width="120" class="text-right">This Month</th>
                                        <th width="250">Remark</th>
                                    </tr>
                                </thead>
        
                                 <tbody>
                                    <?php $i = 0;?>
                                    @foreach($employee as $row)
                                        <tr>
                                            <td>{{sprintf('%02d',++$i)}}</td>   
                                            <td><input type="hidden" name="emp_id[]" value="{{$row->id}}"> {{$row->name }}</td>  
                                            <td><input type="number" name="basic_salary[]" class="form-control text-right" readonly value="{{ $row->basic_salary }}"  id="basic{{$row->id}}"></td> 
                                            <td><input type="number" name="gross_salary[]"  readonly class="form-control text-right"  value="{{ $row->gross_salary }}"  id="gross{{$row->id}}"></td> 
                                            <td><input type="number" name="addamount[]" value="" class="form-control text-right addAmount" id="addAmount{{$row->id}}" placeholder="0.00" data-employee="{{$row->id}}" autocomplete="off"></td> 
                                            <td><input type="number" name="deductamount[]" value="" class="form-control text-right deductAmount" id="deductAmount{{$row->id}}" data-employee="{{$row->id}}" placeholder="0.00" autocomplete="off"></td>
                                            <td><input type="number" name="thismonthamount[]" value="{{ $row->gross_salary }}" id="thisMonth{{$row->id}}" class="form-control text-right" readonly placeholder="0.00" autocomplete="off"></td>
                                            <td><textarea name="remark[]" class="form-control" id="" rows="2"></textarea></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger waves-effect text-left">Generate Salary</span>
                </div>
            </form>
        </div>
    </div>
</div>
@include('elements.dataTableOne')
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/imageupload.css') }}">
    <style>
        @media (min-width: 768px) {
      .modal-xl {
        width: 90%;
       max-width:1200px;
      }
    }

    </style>
@endpush
@push('js')
    <script src="{{ asset('js/imageupload.js') }}"></script>
    <script> 

        $('.addAmount').on('keypress change keyup',function(){
            const emp = parseFloat($(this).data('employee'))||0;
            const add = parseFloat($(this).val())||0;
            grossCalculate(emp,add,'Add');
        });
        
        $('.deductAmount').on('keypress change keyup',function(){
            const emp = parseFloat($(this).data('employee'))||0;
            const deduct = parseFloat($(this).val())||0;
            grossCalculate(emp,deduct,'Deduct');
        });
        

        function grossCalculate(emp,amount,type){
            const basic = $('#basic'+emp).val();
            const gross = $('#gross'+emp).val();
            
            if(type === 'Add'){
                var thisMonth = parseFloat(amount) + parseFloat(gross);
                const deduct = parseFloat($('#deductAmount'+emp).val())||0;
                thisMonth = parseFloat(thisMonth) - parseFloat(deduct);
            }
            if(type === 'Deduct'){
                var thisMonth = parseFloat(gross) - parseFloat(amount);
                const add = parseFloat($('#addAmount'+emp).val())||0;
                thisMonth = parseFloat(thisMonth) + parseFloat(add);
            }

            $('#thisMonth'+emp).val(parseFloat(thisMonth));
        }
    </script>
   
@endpush
