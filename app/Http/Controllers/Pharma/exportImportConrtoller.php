<?php

namespace App\Http\Controllers\Pharma;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Exports\AttendanceFormat;
use App\Exports\ProductExport;
use App\Exports\ProductFormat;
use App\Exports\BatchFormat;
use App\Exports\CategoryExport;
use App\Exports\UnitExport;
use App\Exports\ProdctTypeExport;
use App\Exports\ManufacturerExport;
use App\Imports\ProductImport;
use App\Imports\AttendanceImport;
use App\Imports\BatchImport;
use App\Exports\BatchExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Pharma;
use Sentinel;


class exportImportConrtoller extends Controller{

    public function __construct(){
        // $this->middleware(['authorized','pharma']);
    }

    public function itemExport(){
        return Excel::download(new ProductExport, 'products.xlsx');
    }
    public function itemExportForm(){
        return Excel::download(new ProductFormat, 'itemformat.csv');
    }
    public function categoryExport(){
        return Excel::download(new CategoryExport, 'categories.xlsx');
    }
    public function unitExport(){
        return Excel::download(new UnitExport, 'units.xlsx');
    }
    public function productTypeExport(){
        return Excel::download(new ProdctTypeExport, 'productTypes.xlsx');
    }
    public function manufacturerExport(){
        return Excel::download(new ManufacturerExport, 'mafacturer.xlsx');
    }
    public function exportImport(){
        if (!Sentinel::hasAccess('product-export-import')) { Session::flash('error', 'Permission Denied!'); return redirect()->back(); }
        // dd(session()->all());
        // session()->forget('batch');
        return view('pharma.products.exportImport');
    }

    public function itemImport(Request $request){
        if($request->hasFile('productcsv')){
            Excel::import(new ProductImport, request()->file('productcsv'));
            if ($request->session()->has('csv')) {
                $count = count(session('csv'));
                Session::flash('error', $count.' Data has has not been inserted!');
            }else{
                Session::flash('success', 'Product uploaded Succeed!');
            }
            Pharma::activities("csv upload", "product", "upload csv Product");
            return redirect('products/export-import');
        }else{
            Session::flash('error', 'File has not been empty!');
            return redirect('products/export-import');
        }
    }

    public function batchExport(){
        return Excel::download(new BatchExport, 'batches.xlsx');
    }

    public function batchImport(Request $request){
        if($request->hasFile('batchcsv')){
            Excel::import(new BatchImport, request()->file('batchcsv'));
            if ($request->session()->has('batch')) {
                $count = count(session('batch'));
                Session::flash('error', $count.' Data has has not been inserted!');
            }else{
                Session::flash('success', 'batch uploaded Succeed!');
            }
            Pharma::activities("csv upload", "batch", "upload csv batch");
            return redirect('products/export-import');
        }else{
            Session::flash('error', 'File has not been empty!');
            return redirect('products/export-import');
        }
    }

    public function batchExportForm(){
        return Excel::download(new BatchFormat, 'batchformat.csv');
    }

//Attendance Form Export Import Start...

    public function attendanceExportForm(){
        return Excel::download(new AttendanceFormat, 'attendanceForm.xlsx');
    }

    public function attendanceImport(Request $request){
        // dd($request->all());
        if($request->hasFile('attendancecsv')){
            Excel::import(new AttendanceImport, request()->file('attendancecsv'));
            
            if ($request->session()->has('attendance')) {
                $count = count(session('attendance'));
                Session::flash('error', $count.' Data has has not been inserted!');
            }else{
                Session::flash('success', 'attendance uploaded Succeed!');
            }

            Pharma::activities("csv upload", "attendance", "upload csv attendance");
            return redirect('attendence');
        }else{
            Session::flash('error', 'File has not been empty!');
            return redirect('attendence');
        }
    }

    //Attendance Form Export Import End...
}
