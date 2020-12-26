<?php

namespace App\Http\Controllers;

use App\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Pharma;
use Session;
class EmailTemplateController extends Controller
{
    public function __construct(){
        $this->middleware('authorized');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if (!Pharma::isAdmin()) {Session::flash('warning','Permission Denied');return redirect()->back();}
        $templates = EmailTemplate::all();
        return view('email_template.index',compact('templates'));
    }

    public function mailbox(){
        $mails = DB::table('mailboxes')->orderBy('id','desc')->get();
        return view('email_template.mailbox',compact('mails'));
    }

    public function mailbox_detail($id){
        DB::table('mailboxes')->where('id', $id)->update(['status' => 'read']);
        $mail = DB::table('mailboxes')->find($id);
        return view('email_template.mailbox-detail')->with('mail',$mail);
    }

    public function mailbox_delete(Request $request){
        if(!empty($request->chackMail)){
            foreach ($request->chackMail as $id) {
                DB::table('mailboxes')->where('id', $id)->delete();
            }
            Session::flash('success','Deleted Succeed!');
            Pharma::activities("Delete", "Email log", "Delete mail log");
            return redirect('emailtemplate/mailbox');
        }else{
            Session::flash('error','Select Email for Delete!');
            return redirect('emailtemplate/mailbox');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        if (!Pharma::isAdmin()) {Session::flash('warning','Permission Denied');return redirect()->back();}
        return view('email_template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, EmailTemplate $emailtemplate){
        if (!Pharma::isAdmin()) {Session::flash('warning','Permission Denied');return redirect()->back();}
        $this->validateForm($request);
        $emailtemplate->create($request->merge([
            'name'          => $request->name,
            'slug'          => Pharma::getUniqueSlug($emailtemplate,$request->slug),
            'subject'       => $request->subject,
            'content'       => $request->content,
            'description'   => $request->description,
            'from_name'     => $request->from_name,
            'from_email'    => $request->from_email,
            'cc_email'      => $request->cc_email,
            'created_at'    => now(),
        ])->all());

        Session::flash('success','Template Added Succeed!');
        Pharma::activities("Added", "Email Template", "Added a New Email template");
        return redirect('emailtemplate');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(EmailTemplate $emailtemplate){
        if (!Pharma::isAdmin()) {Session::flash('warning','Permission Denied');return redirect()->back();}
        return view('email_template.show',compact('emailtemplate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailTemplate $emailtemplate){
        if (!Pharma::isAdmin()) {Session::flash('warning','Permission Denied');return redirect()->back();}
        return view('email_template.edit',compact('emailtemplate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmailTemplate $emailtemplate){
        if (!Pharma::isAdmin()) {Session::flash('warning','Permission Denied');return redirect()->back();}
        $this->validateForm($request);
        $emailtemplate->update($request->merge([
            'name'          => $request->name,
            'slug'          => Pharma::getUniqueSlug($emailtemplate,$request->slug),
            'subject'       => $request->subject,
            'content'       => $request->content,
            'description'   => $request->description,
            'from_name'     => $request->from_name,
            'from_email'    => $request->from_email,
            'cc_email'      => $request->cc_email,
            'created_at'    => now(),
        ])->all());

        Session::flash('success','Template Update Succeed!');
        Pharma::activities("Update", "Email Template", "update a Email template");
        return redirect('emailtemplate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailTemplate $emailtemplate){
        if (!Pharma::isAdmin()) {Session::flash('warning','Permission Denied');return redirect()->back();}
        $emailtemplate->delete();
        Session::flash('success','Template Delete Succeed!');
        Pharma::activities("Delete", "Email Template", "deleted a Email template");
        return redirect('emailtemplate');
    }

    private function validateForm($request){
        $validatedData = $request->validate([
            'name'          => 'required',
            'slug'          => 'required',//'required|sometimes|nullable|unique:email_templates,slug',
            'subject'       => 'required',
            'content'       => 'required',
            // 'description'   => 'required',
            // 'from_name'     => 'required',
            'from_email'    => 'sometimes|nullable|email',
            'cc_email'      => 'sometimes|nullable|email',
        ]);
    }
}
