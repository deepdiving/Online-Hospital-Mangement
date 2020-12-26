<?php

namespace App\Http\Controllers\laboratory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\doctor\Prescription;
use App\Models\doctor\PreTestItem;
use App\Models\diagnostic\Bill;
use App\Models\diagnostic\BillItem;
use App\Models\laboratory\LabReport;
use Pharma;
use Sentinel;
use Session;

class LabReportController extends Controller{

    public function index(){

    }

    public function store(Request $request){
        $invoice    = Pharma::GenarateInvoiceNumber('lab_reports','LR');

        $data =[
            'date'           => date('Y-m-d'),
            'invoice'        => $invoice,
            'content'        => $request->content,
            'diagon_bill_id' => $request->diagon_bill_id,
            'patient_id'     => $request->patient_id,
            'user_id'       => Sentinel::getUser()->id,
            'created_at'    => now()
        ];

        //dd($data);
        LabReport::create($data);

        Session::flash('success', 'Report Added Succeed!');
        Pharma::activities("Added", "Report", "Added a New Lab Report");

        return redirect('lab/invoice/' . $invoice);
       
    }

    public function testList(){
        $bills   = Bill::with('labReports')->where('status','Active')->orderBy('id','DESC')->get();
        return view('laboratory.report.testList',compact('bills'));
    }

    public function labRport($invoice){
        $invoicePrint = Bill::with(['patient','billItem.test'])->where('invoice',$invoice)->first();
        return view('laboratory.report.labReport',compact('invoicePrint'));
    }

    public function reportList(){
        $todayReport = LabReport::where('status','Active')->with(['bill','patient'])->where('date',date('Y-m-d'))->orderBy('id','DESC')->get();
        $allReport   = LabReport::where('status','Active')->with(['bill','patient'])->orderBy('id','DESC')->get();
        //dd($todayReport);
        return view('laboratory.report.reportList',compact('todayReport','allReport'));
    } 

    public function invoice($invoice){
        $reports = LabReport::where('invoice',$invoice)->first();
        return view('laboratory.invoice.invoice',compact('reports'));
    }

    public function voided(){
        $voidList   = LabReport::where('status','Void')->with(['bill','patient'])->orderBy('id','DESC')->get();
        return view('laboratory.report.voidList',compact('voidList'));
    }

    public function void($id){
        $report = LabReport::find($id);
        $report->status = "Void";
        $report->save();

        Session::flash('success', 'Lab Report Voided Succeed!');
        Pharma::activities("Voided", "Lab Report", "Voided {$report->invoice} Lab Report");
        return redirect('lab/report/list');
    }

}
