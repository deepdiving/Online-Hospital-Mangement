<?php

namespace App\Http\Controllers;
use App\Notification;
use Illuminate\Http\Request;
use App\User;
use Session;
use Sentinel;
use Pharma;

class NotificationController extends Controller
{
    public function __construct(){
        $this->middleware('authorized');
    }

    public function index(){
        if (!Sentinel::hasAccess('notifacation')) {  Session::flash('warning','Permission Denied');return redirect('dashboard');}
        $notifications = Notification::where('user',Sentinel::getUser()->id)->get();  
        return view('users.notification', compact('notifications'));
    }

    public function delete($id){
        if (!Sentinel::hasAccess('notifacation')) {  Session::flash('warning','Permission Denied');return redirect()->back();}
        Notification::destroy($id);
        Session::flash('success','Delete Successed!');   
        Pharma::activities("Deleted", "Notifaction", "Deleted a notifacations");
        return redirect('users/notification');
    }
}
