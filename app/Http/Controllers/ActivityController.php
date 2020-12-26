<?php

namespace App\Http\Controllers;
use App\Activity;
use Illuminate\Http\Request;
use Session;
use Pharma;
use Sentinel;
class ActivityController extends Controller
{
    public function __construct(){
        $this->middleware('authorized');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Sentinel::hasAccess('activities')) {  Session::flash('warning','Permission Denied');return redirect('dashboard');}
        $activities = new Activity;
        $activities = $activities->orderBy('id','DESC');
        if(!Pharma::isAdmin()){
            $activities = $activities->where('user_id',Sentinel::getUser()->id);
        }
        $data = $activities->get();// Activity::orderBy('id','DESC')->get();
        return view('users.activites', compact('data'));
    }


    public function delete($id)
    {
        Activity::destroy($id);
        Session::flash('success','Deleted succeed!');
        return redirect('users/activities');
    }
}
