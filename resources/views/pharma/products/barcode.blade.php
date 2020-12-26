@extends('layout.app',['pageTitle' => __('Items Barcode Management')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.item_barcode') }}
    @endslot
@endcomponent
<?php // echo DNS2D::getBarcodeHTML("4445645656", "QRCODE");
    // echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("BATCH00003", "C39",2,33,array(1,1,1), true) . '" alt="barcode"   /><br><br><br><br>';
    // echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("BATCH00003", "C39",2,33,array(1,1,1), true) . '" alt="barcode"   /><br><br><br><br>';
    // echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("BATCH00003", "C39E",2,33,array(1,1,1), true) . '" alt="barcode"   /><br><br><br><br>';
    // echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("BATCH00003", "C39E",2,33,array(1,1,1), true) . '" alt="barcode"   /><br><br><br><br>';
    // echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("BATCH00003", "C93",2,33,array(1,1,1), true) . '" alt="barcode"   /><br><br><br><br>';
    // echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("BATCH00003", "C128",1,33,array(1,1,1), true) . '" alt="barcode"   /><br><br><br><br>';
    // echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("BATCH00003", "C128A",1,33,array(1,1,1), true) . '" alt="barcode"/>';
    // echo DNS2D::getBarcodeHTML("Shariful", "QRCODE");
    // echo "<ul>";
        // echo '1<li>'.DNS1D::getBarcodeHTML("BATCH00001", "C39",1,33,"black", true).'</li><br><br><br><br><br>';
        // echo '2<li>'.DNS1D::getBarcodeHTML("BATCH00001", "C39+",1,33,"black", true).'</li><br><br><br><br><br>';
        // echo '3<li>'.DNS1D::getBarcodeHTML("BATCH00001", "C39E",1,33,"black", true).'</li><br><br><br><br><br>';
        // echo '4<li>'.DNS1D::getBarcodeHTML("BATCH00001", "C39E+",1,33,"black", true).'</li><br><br><br><br><br>';
        // echo '5<li>'.DNS1D::getBarcodeHTML("BATCH00001", "C93",1,33,"black", true).'</li><br><br><br><br><br>';
        // echo '6<li>'.DNS1D::getBarcodeHTML("BATCH00001", "S25").'</li><br><br><br><br><br>';
        // echo '7<li>'.DNS1D::getBarcodeHTML("BATCH00001", "S25+").'</li><br><br><br><br><br>';
        // echo '8<li>'.DNS1D::getBarcodeHTML("BATCH00001", "I25").'</li><br><br><br><br><br>';
        // echo '9<li>'.DNS1D::getBarcodeHTML("BATCH00001", "I25+").'</li><br><br><br><br><br>';
        // echo '10<li>'.DNS1D::getBarcodeHTML("BATCH00001", "C128").'</li><br><br><br><br><br>';
        // echo '11<li>'.DNS1D::getBarcodeHTML("BATCH00001", "C128A").'</li><br><br><br><br><br>';
        // echo '12<li>'.DNS1D::getBarcodeHTML("BATCH00001", "C128B").'</li><br><br><br><br><br>';
        // echo '13<li>'.DNS1D::getBarcodeHTML("BATCH00001", "C128C").'</li><br><br><br><br><br>';
        // echo '<li>'.DNS1D::getBarcodeHTML("44455656", "EAN2").'</li><br><br><br><br><br>';
        // echo '<li>'.DNS1D::getBarcodeHTML("4445656", "EAN5").'</li><br><br><br><br><br>';
        // echo '<li>'.DNS1D::getBarcodeHTML("4445", "EAN8").'</li><br><br><br><br><br>';
        // echo '<li>'.DNS1D::getBarcodeHTML("4445", "EAN13").'</li><br><br><br><br><br>';
        // echo '14<li>'.DNS1D::getBarcodeHTML("BATCH00001", "UPCA").'</li><br><br><br><br><br>';
        // echo '15<li>'.DNS1D::getBarcodeHTML("BATCH00001", "UPCE").'</li><br><br><br><br><br>';
        // echo '16<li>'.DNS1D::getBarcodeHTML("BATCH00001", "MSI").'</li><br><br><br><br><br>';
        // echo '17<li>'.DNS1D::getBarcodeHTML("BATCH00001", "MSI+").'</li><br><br><br><br><br>';
        // echo '18<li>'.DNS1D::getBarcodeHTML("BATCH00001", "POSTNET").'</li><br><br><br><br><br>';
        // echo '19<li>'.DNS1D::getBarcodeHTML("BATCH00001", "PLANET").'</li><br><br><br><br><br>';
        // echo '20<li>'.DNS1D::getBarcodeHTML("BATCH00001", "RMS4CC").'</li><br><br><br><br><br>';
        // echo '21<li>'.DNS1D::getBarcodeHTML("BATCH00001", "KIX").'</li><br><br><br><br><br>';
        // echo '22<li>'.DNS1D::getBarcodeHTML("BATCH00001", "IMB").'</li><br><br><br><br><br>';
        // echo '23<li>'.DNS1D::getBarcodeHTML("BATCH00001", "CODABAR").'</li><br><br><br><br><br>';
        // echo '24<li>'.DNS1D::getBarcodeHTML("BATCH00001", "CODE11").'</li><br><br><br><br><br>';
        // echo '25<li>'.DNS1D::getBarcodeHTML("BATCH00001", "PHARMA").'</li><br><br><br><br><br>';
        // echo '26<li>'.DNS1D::getBarcodeHTML("BATCH00001", "PHARMA2T").'</li><br><br><br><br><br>';
    // echo "</ul>";
?>
@include('elements.alert')
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="card">
                <div class="card-body">
                    <h3>{{ucfirst($product->title)}} <small>{{$product->stock}} {{$product->unit->unit_name}}</small></h3>
                    <br>
                    <form action="" method="get" class="form-material">
                        @foreach($product->batch as $batch)
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">{{$batch->batch_number}} :</label>
                                <div class="col-8">
                                    <input type="number" class="form-control" value="{{($data[$batch->batch_number]) ? $data[$batch->batch_number] : 0}}" name="{{$batch->batch_number}}">
                                </div>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-default float-right">Load Bercode</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-8">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn bg-theme text-light mb-3 float-right" style="padding: 10px 15px; border-radius:0px" onclick="invoiceprint()"> <i class="mdi mdi-printer"> </i> Print </button>
                    <table class="table" id="printJS-form"  cellpadding="5" cellspacing="0">
                        @foreach($data as $key => $val)
                            @if($data[$key] > 0)
                                <tr>
                                    <td colspan="2" class="font-weight-bold">{{strtoupper($key)}}</td>
                                </tr>
                                @for($i = 0; $i < $val; $i++)
                                    <tr>
                                        <td><b>{{Pharma::short_text(ucfirst($product->title),20)}}</b> <br><small>{{Pharma::amountFormatWithCurrency($product->sale_price)}}</small><br><?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG(strtoupper($key), "C128A",1,33,array(1,1,1), true) . '" alt="barcode"/>';?></td>
                                        <td><b>{{Pharma::short_text(ucfirst($product->title),20)}}</b> <br><small>{{Pharma::amountFormatWithCurrency($product->sale_price)}}</small><br><?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG(strtoupper($key), "C128A",1,33,array(1,1,1), true) . '" alt="barcode"/>';?></td>
                                    </tr>
                                @endfor
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
<link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
<style>
    .wd60percent{ width: 60%;}
    .wd15percent{ width: 15%;}
    .wd25percent{ width: 25%;}
</style>
@endpush
@push('js')
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<script>
    function invoiceprint(){
        printJS({ 
            printable: 'printJS-form', 
            type: 'html', 
            style: '.table {width:80%; margin:0px auto; }.table td{ border-bottom: 1px solid #000; width:80% !important; padding:20px 0px;;}',
            // css: "{{ asset('css') }}/print2.css",
            // onPrintDialogClose: printJobComplete
            // gridHeaderStyle: 'color: red;  border: 2px solid #3971A5;',
	        // gridStyle: 'border: 2px solid #3971A5;'
            // header: 'PrintJS - Form Element Selection',
        });
    }   
</script>
@endpush