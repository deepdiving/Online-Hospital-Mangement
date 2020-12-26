<?php

namespace App\Http\Controllers\doctor;
use App\Http\Controllers\Controller;
use Pharma;
use Sentinel;
use Session;
use App\Transation;
use App\Doctor;
use App\Patient;
use App\Models\doctor\DocSchedule;
use App\Models\doctor\DocAppointment;
use DB;

use Illuminate\Http\Request;

class DocAppointmentController extends Controller{

    public function __construct(){
        $this->middleware(['authorized','diagnostic']);
    }

    public function index(){
        $doctors = Doctor::where('status','Active')->get();
        $appointments = DocAppointment::orderBy('id','DESC')->get();
        $confirmdAppoints = DocAppointment::where('status','Confirmed')->get();
        $calendarEvents = DocAppointment::where('status','!=','Void')->groupBy('doctor_id', 'date')->get(); //where('date','>=',date('Y-m-d')) 
        $patients = Patient::Active()->get();
        return view('doctor_module.appointment.index',compact('doctors','appointments','patients','calendarEvents','confirmdAppoints'));
    }

    public function store(Request $request){ 
        $invoice    = Pharma::GenarateInvoiceNumber('doc_appointments','A');
        $data = [
            'date'              => $request->date,
            'invoice'           => $invoice,
            'patient_id'        => $request->patient_id,
            'doctor_id'         => $request->doctor_id,
            'doc_schedule_id'   => $request->time_slot,
            'doctor_fees'       => $request->consultant_fees,
            'discount'          => $request->discount,
            'net_fees'          => $request->consultant_fees - $request->discount,
            'serial'            => Pharma::getNextSerial($request->time_slot,$request->date),
            'remark'            => $request->remark,
            'user_id'           => Sentinel::getUser()->id,
        ];
        $appointment = DocAppointment::create($data);
        if($request->received_payment == 1){
            $transId = $this->makeTransaction($invoice,$request);
            $appointment->trans_id = $transId;
            $appointment->status = 'Paid';
            $appointment->save();
        }
        $url = url('appointment/invoice/a4/'.$invoice);
        Session::flash('success', 'New Appointed Success');
        Pharma::activities("Added", "New Appointment", "Appointed a New patient <a target='_blank' href='{$url}'>{$invoice}</a>");
        return redirect()->back();
    }

    private function makeTransaction($invoice,$request){
        $transaction = New Transation;
        $url = url('appointment/invoice/a4/'.$invoice);
        $trans = $transaction->create([
            'date'                  => date('Y-m-d'),
            'trans_id'              => Pharma::GenarateInvoiceNumber('transations',session()->get('settings')[0]['transaction_prefix']),
            'amount'                => $request->consultant_fees - $request->discount,
            'description'           => "Received from Appointment bill. <a target='_blank' href='{$url}'>{$invoice}</a>",
            'vendor_id'             => $request->patient_id,
            'user_id'               => Sentinel::getUser()->id,
            'module'                => 'Diagnostic',
            'sub_module'            => 'Diagnostic-Appointment',
            'created_at'            => now(),
        ]);
        return $trans->id;
    }

    Public function show(DocAppointment $appointment){ 

        return view('doctor_module.appointment.appointedpatient',compact('appointment'));
    }

    public function payment(Request $request){
        $appoint = DocAppointment::find($request->payment_appoint_id); 
        $netFees = $appoint->doctor_fees - $request->payment_discount;
        $appoint->status = 'Paid';
        $appoint->discount = $request->payment_discount;
        $appoint->net_fees = $netFees;
        $appoint->updated_at = now();

        $appoint->save();

        if($netFees > 0){
            $transaction = New Transation;
            $url = url('appointment/invoice/a4/'.$appoint->invoice);
            $trans = $transaction->create([
                'date'                  => date('Y-m-d'),
                'trans_id'              => Pharma::GenarateInvoiceNumber('transations',session()->get('settings')[0]['transaction_prefix']),
                'amount'                => $netFees,
                'description'           => "Received from Appointment bill. <a target='_blank' href='{$url}'>{$appoint->invoice}</a>",
                'vendor_id'             => $appoint->patient_id,
                'user_id'               => Sentinel::getUser()->id,
                'module'                => 'Diagnostic',
                'sub_module'            => 'Diagnostic-Appointment',
                'created_at'            => now(),
            ]);
        }
        $url = url('appointment/invoice/a4/'.$appoint->invoice);
        Session::flash('success', 'Appointment bill colleced!');
        Pharma::activities("Collected", "Bill collected", "Collected Bill Form Appointment <a target='_blank' href='{$url}'>{$appoint->invoice}</a>");
        return redirect()->back();

    }


    public function getTimeSlot($date,$doctorId){
        $schedules = DocSchedule::where('doctor_id',$doctorId)->where('week_day',date("l",strtotime($date)))->get();
        if(!empty($schedules)){
            $html = '';
            $i = 0;
            foreach($schedules as $row){
                $sTime = date('h:ia', strtotime($row->start_time));
                $eTime = date('h:ia', strtotime($row->end_time));
                $checked = ($i == 0) ? 'checked' : '';
                $html .= "<input name='time_slot' type='radio' onchange='time_slot_change({$row->id})' id='radio_{$row->id}' value='{$row->id}' {$checked} class='with-gap radio-col-pink'>";
                $html .="<label for='radio_{$row->id}'> {$row->name} <span class='badge bg-theme font-weight-bold'>{$sTime} to {$eTime} </span></label>";
                $i++;
            }
            echo json_encode(['status'=> 'OK','html' => $html]);
        }else{
            echo json_encode(['status'=> 'NOT OK','html' => '']);
        }
    }

    public function getTimeSlotData($scheduleId,$date){
        $sl         = Pharma::getNextSerial($scheduleId,$date);
        $schedule   = DocSchedule::find($scheduleId);
        $fees = $schedule->doctor_fees;
        $qty = $schedule->visit_qty;
        $red = $qty < $sl ? 'red' : '';

        echo json_encode(['serial'=>$sl,'fees'=>$fees,'red' => $red]);

    }
    public function getDaywiseDoctorSchedule($doctorId,$scheduleId,$date){
        $appionts        = Pharma::getDayWisDoctorSchedule($doctorId,$scheduleId,$date);
        $html = '';
        foreach($appionts as $app){
            $html .= "<div class='col-md-4 mt-3'>";
            $html .= "<div class='p-2' style='background:#ddd'>";
            $html .= "<h2 class='display-4 font-weight-bold'>{$app->serial} <small style='font-size: 40%;'>#{$app->invoice}</small></h2>";
            $html .= "<h4>{$app->patient->patient_name} <small>#{$app->patient->slug}</small></h4>";
            $html .= "<b>";
            $html .= Pharma::dateFormat($app->date)."<br>";
            $html .= date('h:i A', strtotime($app->docschedule->start_time));
            $html .= "</b>";
            if($app->status == "Paid"){
                $html .= "<span class='btn btn-primary float-right rounded-0 p-1' style='margin-right: -8px;margin-bottom: -8px;'>Paid</span>";
            }
            $html .= "</div>";
            $html .= "</div>";
        }
        echo json_encode(['html'=>$html]);
    }

    public function cofirmpatietnList($patient){
      $cofirmPatient = DocAppointment::where('status','Confirmed')->get();

      $seriel   = $cofirmPatient->serial;
      $fees     = $cofirmPatient->doctor_fees;
      $discount = $cofirmPatient->discount;

      echo json_encode(['seriel'=>$seriel, 'fees'=>$fees, 'discount'=>$discount]);
    }

    public function getAppointment($id){
      $appoint = DocAppointment::find($id);
      echo json_encode(['data'=>$appoint]);
    }

    public function patientStore(Request $request){
        $patient_number = Pharma::GenaratePatientSlug();
        $data = [
            'patient_name'  => $request->patient_name,
            'slug'          => $patient_number,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'age'           => $request->age,
            'address'       => $request->address,
            'gender'        => $request->gender,
            'description'   => $request->description,
            'marital_status'=> $request->marital_status,
            'blood_group'   => $request->blood_group,
            'guardian'      => $request->guardian,
            'relationship'  => $request->relationship,
            'guardian_phone'=> $request->guardian_phone,
            'occupation'    => $request->occupation,
            'religion'      => $request->religion,
            'user_id'       => Sentinel::getUser()->id,
            'created_at'    => now()
        ];
        $patient = Patient::create($data);
        Pharma::activities("Added", "patient", "Added a New patient");
        echo json_encode($patient);
    }

    Public function appointmentList(Request $request){
        $search = [
            'date'   => date('Y-m-d'),
            'doctor' => '',
            'status' => 'Paid',
        ];
        $appoint = New DocAppointment;
        if($request->has('date') && $request->date != '-'){
            $appoint = $appoint->where('date','=',$request->date);
            $search['date'] = $request->date;
        }
        if($request->has('doctor') && $request->doctor != '-'){
            $appoint = $appoint->where('doctor_id',$request->doctor);
            $search['doctor'] = $request->doctor;
        }
        if($request->has('status') && $request->status != '-'){
            $appoint = $appoint->where('status',$request->status);
            $search['status'] = $request->status;
        }
        $doctors = Doctor::where('status','Active')->get();
        $appointmentList =  $appoint->orderBy('id','DESC')->get();
        return view('doctor_module.appointment.appointmentList',compact('appointmentList','search','doctors'));
    }

    Public function appointedpatient(){

        $appointmentPatient = DocAppointment::with('patient')->get();        
        //dd( $appointmentPatient);
        $appointmentPatient = DocAppointment::all();   
        return view('doctor_module.appointment.appointedpatient',compact('appointmentPatient'));
    }
   

    public function destroy(DocAppointment $appointment){
      $appointment->delete();  

        DB::statement("SET @count = 0;");
        DB::statement("UPDATE `doc_appointments` SET `doc_appointments`.`serial` = @count:= @count + 1 where `doc_appointments`.`doc_schedule_id`= $appointment->doc_schedule_id;");
        DB::statement("ALTER TABLE `doc_appointments` AUTO_INCREMENT = 1;");



      return redirect('appointment-list');
   }

}
