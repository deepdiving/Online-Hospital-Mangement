@extends('layout.app',['pageTitle' => 'Report List'])
@section('content')

@push('css')
<style>

@media print {
    @page {
        size: A4;
    }
    .row{
        width: 100%;
    }
    .col-md-6{
        width: 50% !important; 
    }
}
tbody.borderhade tr {
    border-top: 2px dashed #d4d2d2;
}
.borderdobul{
    border-top: double;
    margin-top: -15px !important;
}
.b-r{
    border-right: 2px dashed #ddd !important;
}
.table td{
    padding: 0px !important;
}
.m-l{
    margin-left:160px;
}

</style>
@endpush  

@component('layout.inc.breadcrumb')
    @slot('title')
        Report 
    @endslot
@endcomponent
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div id="invoice">
                <div class="toolbar hidden-print" id="printSection">
                    <div class="text-right" id="buttontPlace">
                        <button id="printInvoice" class="btn btn-info print-window"><i class="fa fa-print"></i> {{ __('messages.print') }}</button>
                        <a href="{{ URL::previous() }}" class="btn btn-info aa"><i class="fa fa-angle-left"></i> {{ __('messages.back') }}</a>
                    </div>
                    <hr>
                </div>
                    <div class="invoice-box">
                        <div id="tablehight">
                            <tr class="top">
                                <td colspan="2">
                                    <table style="margin-bottom: 35px;">                                                                                                                     
                                            <div class="patientInfo d-flex justify-content-between">
                                                <p>
                                                      #0003 <br>
                                                      Mehedi <br> 
                                                      Khulna <br>
                                                      01619251624
                                                </p>
                                                <p>
                                                    #DIA0001 <br>
                                                    10-Mar-2020 <br>
                                                    Mar 10, 2020 1:14 pm<br>
                                                    Khulna
                                                </p>
                                            </div>                                     
                                    </table>
                                </td>
                            </tr>
                            <table cellpadding="0" cellspacing="0" class="table-bordered">
                             <h4 class="font-weight-bold">Report Name :&nbsp;</h4> <br>   
                                <thead>
                                    <tr>
                                        <th>Test Name</th>
                                        <th width="100">Result</th>
                                        <th width="150">Normal Value</th>
                                        <th width="180">Comments</th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    {{-- @foreach($invoicePrint->billItem as $row) -- --}}
                               <tr>
                                   <td>Digital X-Ray Thigh Hip (B/V)</td>                                               
                                   <td class="text-center">12</td>
                                   <td class="text-center">10</td>
                                   <td>Normal</td>
                               </tr>
                               <tr>
                                   <td>Digital X-Ray Femur (B/V)	</td>                                               
                                   <td class="text-center">20</td>
                                   <td class="text-center">10</td>
                                   <td>Abnormal</td>
                               </tr>
                               <tr>
                                   <td>Digital X-Ray Elbow-Right/Left (B/V)</td>                                               
                                   <td class="text-center">18</td>
                                   <td class="text-center">18</td>
                                   <td>Normal</td>
                               </tr>
                               <tr>
                                   <td>Digital X-Ray Arm -Right/Left (B/V) (B/V)</td>                                               
                                   <td class="text-center">2</td>
                                   <td class="text-center">-2</td>
                                   <td>Abnormal</td>
                               </tr>
                               <tr>
                                   <td>Digital X-Ray Thigh Hip (B/V)</td>                                               
                                   <td class="text-center">12</td>
                                   <td class="text-center">10</td>
                                   <td>Normal</td>
                               </tr>
                               <tr>
                                   <td>Digital X-Ray Arm -Right/Left (B/V)</td>                                               
                                   <td class="text-center">7</td>
                                   <td class="text-center">7</td>
                                   <td>Normal</td>
                               </tr>
                           {{-- @endforeach  --}}
                       </tbody>           
                  </table>
                            <p>
                                Remarks: Come Next Times.
                            </p>                            
                        <div class="row">
                            <div class="col">
                                <p class="d-inline-block m-l8">Thank you</p>                                  
                                <p class="float-right text-right m-l-20">Receive: Mehadi </p>                                                          
                            </div> 
                        </div> 
                    </div>
                 </div>                              
              </div>
          </div>
      </div>
  </div> 
@endsection
@include('elements.print')
@if(isset($_GET['print']))
@push('js')
<script>
    $(document).ready(function(){
        setTimeout(function(){
            $('#printInvoice').click()
        },1000);
    });
</script>
@endpush
@endif
