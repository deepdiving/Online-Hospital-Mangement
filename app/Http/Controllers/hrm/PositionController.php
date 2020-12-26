<?php

namespace App\Http\Controllers\hrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hrm\HrmPosition;
use Sentinel;
use Pharma;
use Session;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = HrmPosition::all();
        return view('hrm.positions.index',compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'name'        => $request->name,
            'description' => $request->description,
            'user_id'     => Sentinel::getUser()->id,
            'created_at'  => now()
        ];

        //dd($data);
      
        HrmPosition::create($data);

        Session::flash('success', 'Position Added Succeed!');
        Pharma::activities("Added", "Position", "Added a New Position");
        return redirect('position');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HrmPosition $position)
    {
        
        return view('hrm.positions.show',compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(HrmPosition $position)
    {
        return view('hrm.positions.edit',compact('position'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HrmPosition $position)
    {
        $data = [
            'name'        => $request->name,
            'description' => $request->description,
            'user_id'     => Sentinel::getUser()->id,
            'updated_at'  => now()
        ];

        //dd($data);
      
        $position->update($data);

        Session::flash('success', 'Position Updated Succeed!');
        Pharma::activities("Updated", "Position", "Update Position");
        return redirect('position');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HrmPosition $position)
    {
        $position->delete();
        Session::flash('success', 'Position Deleted Succeed!');
        Pharma::activities("Deleted", "position", "Deleted position");
        return redirect('position');
    }
}
