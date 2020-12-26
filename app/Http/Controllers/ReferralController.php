<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ReferralCategory;
use App\Referral;
use App\Models\diagnostic\Bill;
use App\ReferralPayment;
use App\Models\hospital\HmsAdmission;
use Session;

class ReferralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $referrals = Referral::all();
        return view('referrals.index',compact('referrals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $refCategory = ReferralCategory::all();
        return view('referrals.create',compact('refCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
         'email' => 'unique:referrals',
         'contact' => 'required|unique:referrals|max:15|min:9',
        ]);

        $data = $request->only('name','designation','contact','email','referral_category_id');

        Referral::create($data);

        Session::flash('success','Refettal Added Succeed!');
        return redirect('referral');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
         $search = [
            'start' => '-',
            'end'   => '-',
        ];
         $searches = [
            's_start' => '-',
            's_end'   => '-',
        ];
        $ref_bill = new Bill;
        if($request->has('start') && $request->start != '-'){
            $ref_bill = $ref_bill->where('date','>=',$request->start);
            $search['start'] = $request->start;
        }
        if($request->has('end') && $request->end != '-'){
            $ref_bill = $ref_bill->where('date','<=',$request->end);
            $search['end'] = $request->end;
        }

        $DiagonReferral = Referral::with('bill','payments.transation')->findOrFail($id);
        $ref_data = $ref_bill->where('referral_id',$id)->get();


        // $DiagonReferral = Referral::with('bill','payments.transation')->findOrFail($id);
        // $ref_data = $ref_bill->where('referral_id',$id)->get();



        $ref_hos = new HmsAdmission;
        if($request->has('s_start') && $request->s_start != '-'){
            $ref_hos = $ref_hos->where('date','>=',$request->s_start);
            $searches['s_start'] = $request->s_start;
        }
        if($request->has('s_end') && $request->s_end != '-'){
            $ref_hos = $ref_hos->where('date','<=',$request->s_end);
            $searches['s_end'] = $request->s_end;
        }
        $referralhospital = $ref_hos->where('referral_id',$id)->get();
         //dd($referralhospital);
        return view('referrals.show',compact('DiagonReferral','search','searches','ref_data','referralhospital'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $refCategory = ReferralCategory::all();
        $DiagonReferral = Referral::findOrFail($id);
        return view('referrals.edit',compact('DiagonReferral','refCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $request->validate([       
       'contact' => 'required',
      ]);

        $DiagonReferral = Referral::findOrFail($id);

        $DiagonReferral->update($request->only('name','designation','contact','email','referral_category_id'));

        Session::flash('success','Referral Updated Succeed!');
        return redirect('referral');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $DiagonReferral = Referral::findOrFail($id);

        $DiagonReferral->delete();

        Session::flash('success','Referral Deleted Succeed!');
        return redirect('referral');
    }
}
