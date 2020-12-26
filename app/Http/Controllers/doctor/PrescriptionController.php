<?php

namespace App\Http\Controllers\doctor;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\diagnostic\DiagonTestList;
use App\Models\diagnostic\DiagonTestCategory;
use App\Models\doctor\PreMedicine;
use App\Models\doctor\PreMedicineType;
use App\Models\doctor\DocAppointment;
use App\Models\doctor\PreMedicineItem;
use App\Models\doctor\PreTestItem;
use App\Doctor;
use App\Patient;
use App\Models\doctor\Prescription;
use Pharma;
use Sentinel;
use Session;

class PrescriptionController extends Controller{

    // public function __construct(){
    //     $this->middleware(['authorized','doctor','diagnostic']);
    // }

    public function index(){
        $doctor         = Pharma::getDoctor();
        $testLists      = DiagonTestList::all();
        $medecineLists  = PreMedicine::all();
        $types          = PreMedicineType::all();
        $appointPatient = DocAppointment::with('patient')->where('doctor_id',$doctor->id)->where('date',date('Y-m-d'))->where('status','Paid')->get();
        $testCategories = DiagonTestCategory::all();
        $invoice        = Pharma::GenarateInvoiceNumber('prescriptions','Rx');
        return view('doctor_module.prescription.index',compact('testLists','medecineLists','appointPatient','types','testCategories','invoice','doctor'));
    }

    public function store(Request $request,Prescription $prescription){
        // dd($request->all());
        $doctor = Pharma::getDoctor();
        $invoice    = Pharma::GenarateInvoiceNumber('prescriptions','Rx');
        $data = [
            'invoice'           => $invoice,
            'date'              => date('Y-m-d'),
            'symptoms'          => $request->symptoms,
            'diagnosis'         => $request->diagnosis,
            'advices'           => $request->advices,
            'next_appointment'  => date('Y-m-d',strtotime($request->next_appointment)),
            'patient_id'        => $request->patient_id,
            'appointment_id'    => $request->appointment_id,
            'doctor_id'         => $doctor->id,
            'user_id'           => Sentinel::getUser()->id,
            'status'            => $request->save == 'draft' ? 'Draft' : 'Active',
            'created_at'        => now()
        ];
        $prescription = $prescription->create($data);
        $this->addMedicines($request, $prescription->id);
        $this->addTests($request, $prescription->id);

        $appoint = DocAppointment::find($request->appointment_id);
        $appoint->status = 'Closed';
        $appoint->save();
        
        Session::flash('success', 'Prescription Generated Successfully!');
        Pharma::activities("Added", "New Prescription", "Prescription Generate by {$doctor->name} #{$invoice}");
        if($request->save == 'saveMore'){
            return redirect('prescription');
        }else if($request->save == 'draft'){
            return redirect('prescription');
        }else{
            return redirect("prescription/invoice/a4/{$invoice}?print");
        }
    }

    public function edit(Prescription $prescription){
        if($prescription->status != 'Draft'){
            Session::flash('warning', 'You cant continue...');
            return redirect('prescription/list');
        }
        // dd($prescription);
        $doctor         = Pharma::getDoctor();
        $testLists      = DiagonTestList::all();
        $medecineLists  = PreMedicine::all();
        $types          = PreMedicineType::all();
        $testCategories = DiagonTestCategory::all();

        $prescription = $prescription->load('patient', 'premedicineitem.premedicine.premedicinetype.preroutine','pretest');
        // dd($prescription);
        return view('doctor_module.prescription.edit',compact('testLists','medecineLists','types','testCategories','doctor','prescription'));
    }


    public function update(Request $request,Prescription $prescription){
        // dd($request->all());
        $data = [
            'symptoms'          => $request->symptoms,
            'diagnosis'         => $request->diagnosis,
            'advices'           => $request->advices,
            'next_appointment'  => date('Y-m-d',strtotime($request->next_appointment)),
            'status'            => $request->save == 'draft' ? 'Draft' : 'Active',
            'updated_at'        => now()
        ];
        $prescription->update($data);
        PreMedicineItem::where('prescription_id',$prescription->id)->delete();
        PreTestItem::where('prescription_id',$prescription->id)->delete();
        $this->addMedicines($request, $prescription->id);
        $this->addTests($request, $prescription->id);

        
        Session::flash('success', 'Prescription Updated Successfully!');
        Pharma::activities("Updated", "New Prescription", "Prescription Updated #{$prescription->invoice}");
        if($request->save == 'saveMore'){
            return redirect('prescription');
        }else if($request->save == 'draft'){
            return redirect('prescription');
        }else{
            return redirect("prescription/invoice/a4/{$prescription->invoice}?print");
        }
    }


    private function addMedicines($request,$preId){
        $medItems = new PreMedicineItem;
        $data = [];
        if(!empty($request->medicine)){
            foreach($request->medicine as $key => $med){
                $data = [
                    'medicine'          => $med,
                    'dose'              => $request->dos[$key],
                    'days'              => $request->days[$key],
                    'use_time'          => $request->usetime[$key],
                    'pre_medicine_id'   => $request->pre_medicine_id[$key],
                    'prescription_id'   => $preId,
                    'user_id'           => Sentinel::getUser()->id,
                    'created_at'        => now()
                ];
                $medItems->create($data);
            }
        }
        // dd($data);
    }

    private function addTests($request,$preId){
        $testItems = new PreTestItem;
        $data = [];
        if(!empty($request->tests)){
            foreach($request->tests as $key => $test){
                $data = [
                    'test'              => $test,
                    'diagon_test_id'    => $request->testsId[$key],
                    'prescription_id'   => $preId,
                    'user_id'           => Sentinel::getUser()->id,
                    'created_at'        => now()
                ];
                $testItems->create($data); 
            }
        }
    }
    
    public function patient($id){
        $patient = Patient::find($id);
        echo json_encode($patient);
    }

    public function newMedicine($type,$medicine){
        $medicine = PreMedicine::create([
            'name'  => $medicine,
            'pre_medicine_type_id'  => $type,
            'user_id'   => Sentinel::getUser()->id
        ]);

        $medicines = PreMedicine::orderBy('name','ASC')->get();

        $prescriptionRow = $this->PrescriptionTableRow($medicine);
        $medicineList = $this->medicineList($medicines);

        echo json_encode(['prescriptionRow' => $prescriptionRow , 'medicineList' => $medicineList]);
    }

    public function medicine($id){
        $medicine = PreMedicine::with('premedicinetype.preroutine')->find($id);
        echo $this->PrescriptionTableRow($medicine);
    }

    private function medicineList($medeType){
        $html = '';
        if(!empty($medeType)){
            foreach($medeType as $row){
                $id = sprintf('%02d',$row->id);
                $html .= "<tr>";
                $html .= "<td>{$id}</td>";
                $html .= "<td onclick='addToPrescriptioin({$row->id})'>{$row->name}</td>";
                $html .= "</tr>";
            }
        }else{
            $html .= "<tr style='cursor:pointer'>";
            $html .= "<td colspan='2'>No data</td>";
            $html .= "</tr>";
        }
        return $html;
    }

    private function PrescriptionTableRow($medicine){
        $html = '';
        $html .= "<tr id='medicineId{$medicine->id}'>";
        $html .= "<td class='sl'></td>";
        $html .= "<td>{$medicine->name} <input type='hidden' value='{$medicine->name}' name='medicine[]'> <input type='hidden' value='{$medicine->id}' name='pre_medicine_id[]'></td>";
        $html .= "<td>";
        $html .= "<select name='dos[]' class='form-control' id=''>";
        foreach($medicine->premedicinetype->preroutine as $routine){
        $html .= "<option value='{$routine->name}'>{$routine->name}</option>";
        }
        $html .= "</select>";
        $html .= "</td>";
        $html .= "<td><input type='number' required name='days[]' class='form-control' placeholder='Days only'></td>";
        $html .= "<td>";
        $html .= "<select name='usetime[]' class='form-control' id=''>";
        $html .= Pharma::getOptionArray(['খাবার আগে' => 'খাবার আগে', 'খাবার পরে'=> 'খাবার পরে','খাবার মাঝে' => 'খাবার মাঝে']);
        $html .= "</select>";
        $html .= "</td>";
        $html .= "<td><span class='btn btn-warning' onclick='medicineRemove({$medicine->id})'>X</span></td>";
        $html .= "</tr>";

        return $html;
    }

    public function SearchbyMedecineType($typ_id){
        if($typ_id == 0){
            $medeType = PreMedicine::orderBy('name','ASC')->get();
        }else{
            $medeType = PreMedicine::where('pre_medicine_type_id',$typ_id)->orderBy('name','ASC')->get();
        }
        echo $this->medicineList($medeType);
     }

     public function SearchbyTestType($type_id){
        if($type_id == 0){
            $tests = DiagonTestList::orderBy('count','ASC')->get();
        }else{
            $tests = DiagonTestList::where('test_category_id',$type_id)->orderBy('count','ASC')->get();
        }
        $html = '';
        if(!empty($tests)){
            foreach($tests as $test){
                $html .= "<tr onclick=\"addTest({$test->id},'{$test->name}')\">";
                $html .= "<td>{$test->name}</td>";
                $html .= "</tr>";
            }
        }else{
            $html .= "<tr>";
            $html .= "<td colspan='2'>No data</td>";
            $html .= "</tr>";
        }
        echo $html;
     }

    public function prescriptionList(){
        $presctiption = Prescription::where('status','Active')->where('date',date('Y-m-d'))->where('user_id',Sentinel::getUser()->id)->get();
        $presctiptionDraft = Prescription::where('status','Draft')->where('date',date('Y-m-d'))->where('user_id',Sentinel::getUser()->id)->get();
        return view ('doctor_module.prescription.prescriptionList',compact('presctiption','presctiptionDraft'));
    }

    

    public function void($id){
        $presctiption = Prescription::where('id', $id)->first();
        $presctiption->status = "Void";
        $presctiption->save();

        Pharma::activities("Voided", "Presctiption", "Voided Presctiption ");
        Session::flash('success', 'Prescription Void Succeed!');
        return back();
    }

    public function voided(){
        $presctiption = Prescription::where('status', 'Void')->get();
        return view('doctor_module.prescription.prescriptionVoidList',compact('presctiption'));
    }

    public function draft(){
        $presctiption = Prescription::where('status', 'Draft')->get();
        return view('doctor_module.prescription.prescriptionDraftList',compact('presctiption'));
    }

    public function invoiceA4($invoice){
        $invoicePrint = Prescription::with('pretest')->where('status','!=','Void')->where('invoice',$invoice)->first();
        return view('doctor_module.prescription.invoice.invoiceA4',compact('invoicePrint'));
    }
    
}
