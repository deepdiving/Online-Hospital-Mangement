<?php

namespace App\Http\Controllers;

use Sentinel;
use App\SiteSetting;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Pharma;
use Session;

class HomeController extends Controller
{
    public function __construct(){

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if (!Sentinel::check()) {
            return redirect('login');
        } else {
            return redirect('dashboard');
        }
    }

    public function login(){
        if (Sentinel::check()) {
            \Session::flash('success','Welcome to dashboard!');
            return redirect('dashboard');
        }
        return view('frontend.login');
    }


    public function logout(){
        session()->forget('settings');
        session()->flush();
        Sentinel::logout(null, true);
        return redirect('login');
    }

    public function process_login(Request $request){
        if (Sentinel::check()) {
            return redirect('dashboard');
        }
        $request->validate([
            'email'     => 'required|email|exists:users,email',
            'password'  => 'required',
        ]);

        $settings = SiteSetting::first()->toArray();
        Session::push('settings', $settings);
        Session::put('locale',$settings['language']);

        $credentials = [
            "email" => $request->email,
            "password" => $request->password
        ];

        if ($request->remember) {
            $remember = true;
        } else {
            $remember = false;
        }

        try {
            if (Sentinel::authenticate($credentials, $remember)) {
                if (Sentinel::getUser()->blocked == 1) {
                    flash(__('You Have Been Blocked'))->error();
                    Sentinel::logout(null, true);
                    return redirect('login');
                }
                // if ($user = Sentinel::getUser()){
                //     if ($user->inRole('admin')){
                //         return redirect('dashboard');
                //     }else if($user->inRole('laboratory')){
                //         return redirect('dashboard');
                //     }else if($user->inRole('pharmacy')){
                //         return redirect('dashboard');
                //     }else if($user->inRole('diagnostic')){
                //         return redirect('dashboard');
                //     }elseif($user->inRole('hospital')){
                //         return redirect('dashboard');
                //     }
                // }
                return redirect('dashboard');
            } else {
                return redirect()->back()->with(['status'=>'Invlide Login Details','class'=>'danger']);
            }
        } catch (ThrottlingException $ex) {
            return redirect()->back()->with(['status'=>'Too Many Attempts! please wait 266 second.','class'=>'danger']);
        } catch (NotActivatedException $ex) {
            return redirect()->back()->with(['status'=>'Your account is not active yet!','class'=>'danger']);
        }
    }


    public function register(){
        if (Sentinel::check()) {
            return redirect('dashboard');
        }
        return view('frontend.register');
    }


    public function process_register(Request $request){
        if (Sentinel::check()) {
            return redirect('dashboard');
        }
        $request->validate([
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
            'rpassword' => 'required|same:password',
            'first_name' => 'required',
            'last_name' => 'required',
            'terms'     => 'accepted'
        ]);

        $credentials = array(
            "name"          => $request->first_name." ".$request->last_name,
            "email"         => $request->email,
            "password"      => $request->password,
            "first_name"    => $request->first_name,
            "last_name"     => $request->last_name,
            "created_at"    => now()
        );
        $user = Sentinel::registerAndActivate($credentials);

        $role = Sentinel::findRoleByName('Seller');
        $role->users()->attach($user);
        $msg = trans('login.success');
        return redirect('login')->with(['status'=>'Registration Success! Please Login Here.','class'=>'success']);
    }

    public function password_reset(){
        if (Sentinel::check()) {
            return redirect('dashboard');
        }
        return view('frontend.password_reset');
    }




    /*
     * Resets Password Options
     */
    public function process_password_reset(Request $request){
        if (Sentinel::check()) {
            return redirect('dashboard');
        }

        $request->validate([
            'email' => 'required|exists:users,email'
        ]);

        $credentials = ['email' => $request->email];
        $user = Sentinel::findByCredentials($credentials);
        //Sending email with code
        $reminder = Reminder::exists($user) ?: Reminder::create($user);
        $code = $reminder->code;
        $data = [
            'name'  => $user->first_name." ".$user->last_name,
            'link'  => "<a href='".url('confirm_password_reset')."/{$user->id}/{$code}'> Reset Here.</a>",
        ];
        Pharma::sendEmail(['to'=>$request->email,'data'=>$data,'template'=>'forget-password','attachments'=>'']);
        return redirect('login')->with(['status'=>'Link hass been send please check your email','class'=>'success']);
    }

    public function confirm_password_reset($id, $code){
        if (Sentinel::check()) {
            return redirect('dashboard');
        }
        $user = Sentinel::findById($id);
        if(Reminder::where('user_id',$id)->where('code',$code)->count() > 0){
            return view('frontend.confirm_password_reset', compact('id', 'code'));
        }else{
            return redirect('404');
        }
    }

    public function process_confirm_password_reset(Request $request, $id, $code){
        if (Sentinel::check()) {
            return redirect('dashboard');
        }
        $request->validate([
            'password' => 'required',
            'rpassword' => 'required|same:password',
        ]);
        $credentials = array(
            "email" => $request->email,
            'password' => $request->password,
        );
        $user = Sentinel::findById($id);
        if (!Reminder::complete($user, $code, $request->password)) {
            return redirect('password_reset')->with(['status'=>'Your Key is expaired or invalid','class'=>'danger']);
        }
        return redirect('login')->with(['status'=>'Your Password hass been updated!','class'=>'success']);
    }
}
