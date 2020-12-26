@extends('layout.app',['pageTitle' =>'Asset Equipment'])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
HMS Asset Equipment
@endslot
@endcomponent
@push('css')
<link href="{{ asset('material') }}/assets/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
@endpush
@include('elements.alert')
<div class="row">
    <div class="col-lg-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Asset Equipment</h4>
                <form class="form-material form" action="{{ url('asset/equipment') }}" method="post">
                    @csrf
                    <div class="form-group row {{ $errors->has('category_id') ? ' has-danger' : '' }}">
                        <div class="col-md-6">
                            <select name="category_id" class="form-control" id="category_id" required autocomplete="off">
                                <option value="" selected disabled>Select Asset Category</option>
                                @foreach ($category as $row)
                                    <option value="{{ $row->id }}" id="cat{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                            @include('elements.feedback',['field' => 'category_id'])
                        </div>
                        <div class="col-md-6">
                            <select name="location_id" class="form-control" id="location_id" required autocomplete="off">
                                <option value="" selected disabled>Select Asset Location</option>
                                @foreach ($location as $row)
                                    <option value="{{ $row->id }}">{{$row->name}}</option>
                                @endforeach
                            </select>
                            @include('elements.feedback',['field' => 'location_id'])
                        </div>
                    </div>

                    {{-- <div class="row">  --}}
                        <div class="form-group row  {{ $errors->has('item_name') ? ' has-danger' : '' }}">
                            <div class="col-sm-12 col-md-12">
                                <input type="text" name="item_name" value="{{old('item_name')}}" class="form-control" id="item_name" placeholder="Type Name" required autocomplete="off">
                                @include('elements.feedback',['field' => 'item_name'])
                            </div>
                        </div> 

                        <div class="form-group row {{ $errors->has('serial_no') ? ' has-danger' : '' }}">                          
                            {{-- <label for="serial_no" class="col-sm-4 text-right control-label col-form-label">Serial No<sup class="text-danger font-bold">*</sup> :</label> --}}
                            <div class="col-sm-12 col-md-6">
                                <input type="text" name="serial_number" value="{{old('serial_no')}}" class="form-control" id="serial_no" placeholder="Serial No" required autocomplete="off">
                                @include('elements.feedback',['field' => 'serial_no'])
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <input type="text" name="model" value="{{old('model')}}" class="form-control" id="model" placeholder="Model" required autocomplete="off">
                                @include('elements.feedback',['field' => 'model'])
                            </div>

                        </div> 

                        <div class="form-group row {{ $errors->has('acquisition_cost') ? ' has-danger' : '' }}">                          
                            {{-- <label for="acquisition_cost" class="col-sm-4 text-right control-label col-form-label">Acquisition Cost<sup class="text-danger font-bold">*</sup> :</label> --}}
                            <div class="col-sm-12 col-md-6">
                                <input type="number" name="acquisition_cost" value="{{old('acquisition_cost')}}" class="form-control" id="acquisition_cost" placeholder="Cost" required autocomplete="off">
                                @include('elements.feedback',['field' => 'acquisition_cost'])
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <input type="text" name="received_date" value="{{date('Y-m-d')}}" class="form-control datepickerDB" id="date" placeholder="date" required autocomplete="off">
                                @include('elements.feedback',['field' => 'received_date'])
                            </div>

                        </div> 
                        
                        <div class="form-group row {{ $errors->has('identification_no') ? ' has-danger' : '' }}">                          
                            {{-- <label for="identification_no" class="col-sm-4 text-right control-label col-form-label">Identification No<sup class="text-danger font-bold">*</sup> :</label> --}}
                            <div class="col-sm-12 col-md-12">

                                <input type="number" name="acquisition_cost" value="{{old('acquisition_cost')}}" class="form-control" id="acquisition_cost" placeholder="Acquisition Cost" required autocomplete="off">
                                @include('elements.feedback',['field' => 'acquisition_cost'])

                                <input type="text" name="identification_no" value="{{session()->get('settings')[0]['prefix_asset']}}" readonly class="form-control" id="identification_no" placeholder="Identification No" required autocomplete="off">
                                @include('elements.feedback',['field' => 'identification_no'])
                            </div>
                        </div> 


                        <div class="form-group row  {{ $errors->has('description') ? ' has-danger' : '' }}">                          
                            {{-- <label for="description" class="col-sm-4 text-right control-label col-form-label">Description<sup class="text-danger font-bold">*</sup> :</label> --}}
                            <div class="col-sm-12 col-md-12">
                                <textarea name="description" id="" class="form-control"  value="{{old('description')}}" class="form-control" id="description" placeholder="Description" rows="3"></textarea>
                                @include('elements.feedback',['field' => 'description'])
                            </div>
                        </div>

        
                                             
                        
                        <div class="form-group">
                            {{-- <label for="current_status" class="control-label col-form-label">Current Status :</label> --}}
                                <input name="current_status" value="Usable" type="radio" class="with-gap" id="Usable" checked>
                                <label for="Usable">Usable</label>
                                <input name="current_status" value="Not Usable" type="radio" id="Not Usable" class="with-gap">
                                <label for="Not Usable">Not Usable</label>
                                <input name="current_status" value="Repairable" type="radio" id="Repairable" class="with-gap">
                                <label for="Repairable">Repairable</label>
                        </div>

                        <div class="form-group">
                            {{-- <label for="description" class="control-label col-form-label">{{__('messages.marital_status')}} :</label> --}}
                                <input name="condition" value="Good" type="radio" class="with-gap" id="Good" checked>
                                <label for="Good">Good</label>
                                <input name="condition" value="Average" type="radio" id="Average" class="with-gap">
                                <label for="Average">Average</label>
                                <input name="condition" value="Damage" type="radio" id="Damage" class="with-gap">
                                <label for="Damage">Damage</label>
                        </div>



                    {{-- </div>  --}}
                    <div class="form-group m-b-0 float-right">
                        <button type="submit" class="btn bg-theme text-white">{{__('messages.save')}}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="col-lg-8 col-md-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline">Asset Equipment</h4><br>
                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="myTable">
                            <thead>
                                <tr class="">
                                    <th width="50">SL</th>
                                    <th>Category</th> 
                                    <th>Name</th> 
                                    <th>#Identification</th>
                                    <th>Location</th>                                                                      
                                    <th width="100">Action</th>
                                </tr>
                            </thead> 

                            <tbody>
                           
                                <?php $i = 0;?>
                                @foreach($equipment as $row)
                                 <tr>
                                     <td>{{sprintf('%02d',++$i)}}</td>
                                     <td>
                                         {{ $row->category->name }}
                                     </td> 
                                     <td>
                                        {{ $row->item_name }}
                                    </td> 
                                    <td>
                                        {{ $row->identification_no}}
                                    </td> 
                                     <td>
                                        {{$row->location->name}}
                                    </td> 
                                     
                                     <td style="display: flex; justify-content: space-evenly;">
                                     <a class="btn waves-effect waves-light btn-xs btn-info" href="{{ url('asset/equipment/'.$row->id) }}"><i class="fa fa-eye"></i></a>    
                                     <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{ url('asset/equipment/'.$row->id.'/edit') }}"><i class="fa fa-edit"></i></a>  
                                     
                                     <form action="{{  url('asset/equipment/'.$row->id) }}" method="post" style="margin-top:-2px" id="deleteButton{{$row->id}}">
                                         @csrf
                                         @method('delete')
                                         <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$row->id}})"><i class="fa fa-trash-o"></i></button>
                                     </form>  
                                     </td> 
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
@include('elements.dataTableOne')
@endsection

@push('js')
<script>
    $('#category_id').change(function(){
        var id = $(this).val();
        var catName = convertToSlug($('#cat'+id).text().toLowerCase());
        var name = convertToSlug($('#item_name').val().toLowerCase());
        $('#identification_no').val("{{session()->get('settings')[0]['prefix_asset']}}"+catName+'/'+name);
    });

    $('#item_name').on('keypress keyup change',function(){
        var id = $('#category_id').val();
        var catName = convertToSlug($('#cat'+id).text().toLowerCase());
        var name = convertToSlug($(this).val().toLowerCase());
        $('#identification_no').val("{{session()->get('settings')[0]['prefix_asset']}}"+catName+'/'+name);
    });


    function convertToSlug(Text){
        return Text
            .toLowerCase()
            .replace(/ /g,'-')
            .replace(/[^\w-]+/g,'')
            ;
    }

</script>
@endpush
