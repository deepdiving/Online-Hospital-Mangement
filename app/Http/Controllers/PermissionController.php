<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;
use Pharma;
use Cartalyst\Sentinel\Roles\EloquentRole;
use DB;
use Sentinel;
use Session;
class PermissionController extends Controller
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
        if(!Sentinel::hasAccess('permission-index')) {  Session::flash('warning','Permission Denied');return redirect()->back();}
        $data = array();
        $permissions = Permission::where('parent_id', 0)->get();
        foreach ($permissions as $permission) {
            array_push($data, $permission);
            $subs = Permission::where('parent_id', $permission->id)->get();
            foreach ($subs as $sub) {
                array_push($data, $sub);
            }
        }

        $parents = Permission::where('parent_id',0)->get();
        // return $parents;
        // echo json_encode($parents);
        // dd($parents->all());
        return view('users.permission.index', compact('data','parents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Sentinel::hasAccess('permission-add')) {  Session::flash('warning','Permission Denied');return redirect()->back();}
        $parent_id = Permission::where('parent_id',0)->get();
        return view('users.permission.create')->with('parent_ids',$parent_id);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Sentinel::hasAccess('permission-store')) {  Session::flash('warning','Permission Denied');return redirect()->back();}
        $permission = new Permission();
        $permission->name = $request->name;
        if($request->type == 'parent'){
            $permission->parent_id = 0;
        }else{
            $permission->parent_id = $request->parent_id;
        }
        $permission->description = $request->description;
        $permission->slug = Pharma::getUniqueSlug($permission, $request->name);
        $permission->save();
        $role = EloquentRole::find(1);
        $role->updatePermission($permission->slug, true, true)->save();
        Pharma::activities("Save", "Permission", "Added a new permission");
        Session::flash('success','Permission added succeed!');                
        return redirect('users/permissions');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Sentinel::hasAccess('permission-edit')) { Session::flash('warning','Permission Denied');return redirect()->back();}
        $permission = Permission::find($id);
        $parents = Permission::where('parent_id',0)->get();
        return view('users.permission.edit',compact('permission','parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!Sentinel::hasAccess('permission-update')) {  Session::flash('warning','Permission Denied');return redirect()->back();}
        $permission = Permission::find($id);
        $permission->name = $request->name;
        if($request->type == 'parent'){
            $permission->parent_id = 0;
        }else{
            $permission->parent_id = $request->parent_id;
        }
        $permission->description = $request->description;
        // $permission->slug = Pharma::getUniqueSlug($permission, $request->name);
        $permission->save();
        Session::flash('success','Permission update succeed!');        
        return redirect('users/permissions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
    }

    public function parent_show(){
        $parent_id = Permission::select('parent_id')->get();
        return response()->json($parent_id);      
    }

    public function showParmission($id){
        
    }


}
