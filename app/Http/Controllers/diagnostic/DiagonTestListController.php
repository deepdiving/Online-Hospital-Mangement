<?php

namespace App\Http\Controllers\diagnostic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\diagnostic\DiagonTestList;
use App\Models\diagnostic\DiagonTestCategory;
use Session;

class DiagonTestListController extends Controller
{

    public function __construct(){
        $this->middleware(['authorized','diagnostic']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testLists = DiagonTestList::with('category')->orderBy('id','DESC')->get();
        return view('diagnostic.testlists.index',compact('testLists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $diagonTestCategories = DiagonTestCategory::pluck('category','id'); 
        $diagonTestCategories = DB::table('diagon_test_categories')->select('category','id')->get();

        return view('diagnostic.testlists.create',compact('diagonTestCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only('name','price','test_category_id');

        DiagonTestList::create($data);

        Session::flash('success','Test List Added Succeed!');
        return redirect('diagnostic/testlists');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $DiagonTestList = DB::table('diagon_test_lists')
                           ->select('diagon_test_lists.*','diagon_test_categories.category')
                           ->leftJoin('diagon_test_categories','diagon_test_categories.id','=','diagon_test_lists.test_category_id')
                           ->where('diagon_test_lists.id','=',$id)
                           ->first();
        return view('diagnostic.testlists.show',compact('DiagonTestList'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $diagonTestCategories = DB::table('diagon_test_categories')->select('category','id')->get();
        $DiagonTestList = DB::table('diagon_test_lists')
                           ->select('diagon_test_lists.*','diagon_test_categories.category')
                           ->leftJoin('diagon_test_categories','diagon_test_categories.id','=','diagon_test_lists.test_category_id')
                           ->where('diagon_test_lists.id','=',$id)
                           ->first();
        return view('diagnostic.testlists.edit ',compact('DiagonTestList','diagonTestCategories'));
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
        $DiagonTestList = DiagonTestList::findOrFail($id);

        $DiagonTestList->update($request->only('name','price','test_category_id'));

        Session::flash('success','Test List update Succeed!');
        return redirect('diagnostic/testlists');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $DiagonTestList = DiagonTestList::findOrFail($id);

        $DiagonTestList->delete();

         Session::flash('success','Test List Deleted Succeed!');
        return redirect('diagnostic/testlists');
    }
}
