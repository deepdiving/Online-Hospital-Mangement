@extends('layout.app',['pageTitle' => 'Due collection'])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
       Due collection
    @endslot
@endcomponent
 
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Due collection</h4>
                    {{-- <h6 class="card-subtitle">{{__('messages.create_new')}} {{trans_choice('messages.new_referral',10)}}</h6> --}}
                    <hr class="hr-borderd">
                    <form class="form-material m-t-40 form" action="" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-outline-inverse">
                                    <div class="card-header">
                                        <h4 class="m-b-0 text-white"><i class="mdi mdi-food-variant"> </i> &nbsp;Diagnostic</h4>
                                    </div>
                                    <div class="card-body">
                                        {{-- <h4 class="card-title">Dues: <span class="text-danger font-weight-bold">{{Pharma::getDiagnosticDue($admission->patient->id)}}</span></h4> --}}
                                        <a href="#" data-toggle="modal" data-target=".bs-example-modal-lg" class="btn btn-primary float-right">Collect</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-outline-inverse">
                                    <div class="card-header">
                                        <h4 class="m-b-0 text-white"><i class="mdi  mdi-pill"></i> &nbsp;Pharmecy</h4>
                                    </div>
                                    <div class="card-body">
                                        {{-- <h4 class="card-title">Dues: <span class="text-danger font-weight-bold">{{Pharma::getPharmecyDue($admission->patient->id)}}</span></h4> --}}
                                        <a href="#" class="btn btn-primary float-right">Collect</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-outline-inverse">
                                    <div class="card-header">
                                        <h4 class="m-b-0 text-white"><i class="mdi mdi-clock-start"> </i> &nbsp;Operations</h4>
                                    </div>
                                    <div class="card-body">
                                        {{-- <h4 class="card-title">Dues: <span class="text-danger font-weight-bold">{{Pharma::getOperationDue($admission->patient->id)}}</span></h4> --}}
                                        <a href="#" class="btn btn-primary float-right">Collect</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-outline-inverse">
                                    <div class="card-header">
                                        <h4 class="m-b-0 text-white"><i class="mdi mdi-clock-start"> </i> &nbsp;Emargency</h4>
                                    </div>
                                    <div class="card-body">
                                        {{-- <h4 class="card-title">Dues: <span class="text-danger font-weight-bold">{{Pharma::getEmergencyDue($admission->patient->id)}}</span></h4> --}}
                                        <a href="#" class="btn btn-primary float-right">Collect</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="card card-outline-inverse">
                                    <div class="card-header">
                                        <h4 class="m-b-0 text-white"><i class="mdi mdi-bulletin-board"> </i> &nbsp;Admission</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <tr>
                                                <td width="120">Service Due</td>
                                                {{-- <td class="text-right">{{Pharma::amountFormatWithCurrency($servicedue = Pharma::getAdmissionDue($admission->patient->id))}}</td> --}}
                                            </tr>
                                            <tr>
                                                <td width="">Bed Charge</td>
                                                {{-- <td class="text-right">{{Pharma::amountFormatWithCurrency($beddue = Pharma::bedChargeDue($admission->patient->id))}}</td> --}}
                                            </tr>
                                            <tr class="font-weight-bold">
                                                <td width="">Total Due</td>
                                                {{-- <td class="text-right text-danger">{{Pharma::amountFormatWithCurrency($servicedue+$beddue)}}</td> --}}
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myLargeModalLabel">Diagnostic Dues History</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table">
                                            <tr>
                                                <th>Invoice</th>
                                                <th class="text-right">Grand Total</th>
                                                <th class="text-right">Paid Amount</th>
                                                <th width="200" class="text-right">Due</th>
                                                <th class="text-right">Due Collection</th>
                                            </tr>
                                            <tr>
                                                <td>Dia0311</td>
                                                <td class="text-right">$3000</td>
                                                <td class="text-right">$1000</td>
                                                <td><input type="text" class="form-control text-right" value="2000"></td>
                                                <td class="text-right">$0</td>
                                            </tr>
                                            <tr>
                                                <td>Dia0311</td>
                                                <td class="text-right">$3000</td>
                                                <td class="text-right">$1000</td>
                                                <td><input type="text" class="form-control text-right" value="2000"></td>
                                                <td class="text-right">$0</td>
                                            </tr>
                                            <tr>
                                                <td>Dia0311</td>
                                                <td class="text-right">$3000</td>
                                                <td class="text-right">$1000</td>
                                                <td><input type="text" class="form-control text-right" value="2000"></td>
                                                <td class="text-right">$0</td>
                                            </tr>
                                            <tr class="font-weight-bold">
                                                <td colspan="2" class="text-right">
                                                    <textarea name="" class="form-control" rows="3" placeholder="Remark"></textarea>
                                                </td>
                                                <td class="text-right">Total</td>
                                                <td><input type="text" class="form-control text-right" readonly value="2000"></td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
