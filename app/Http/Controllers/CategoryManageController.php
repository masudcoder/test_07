<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Auth;
use Session;
class CategoryManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		
		$data['records'] = \App\Models\Category::where('created_by', Auth::user()->id)->get();
		return view('category.category_home', ['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		$data = array();
		return view('category.category_create', ['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category_model = new \App\Models\Category;
		
		if($request->edit_row_id)
		{
		    $category_model = $category_model::where('created_by', Auth::user()->id)->find($request->edit_row_id);
			$category_model->updated_by = Auth::user()->id;  		  
		} else
		{
			$category_model->created_by = Auth::user()->id;
		}
		
		
		$category_model->category_name = $request->category_name;  
        $category_model->category_short_description = $request->category_short_description;			
        $category_model->save();
		
		Session::flash('success-message', 'Category has beed added successfully.');        
        return Redirect::to('/manage-category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //		
		$data['single_record'] = \App\Models\Category::where( [ 'created_by'=>Auth::user()->id,  'category_row_id'=>$id ] )->first();		
		return view('category.category_create', ['data'=>$data]);		
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
		$category_model = new \App\Models\Category;
		$category_model = $category_model::where('created_by', Auth::user()->id)->find($id);
		$category_model->delete();
		
		Session::flash('success-message', "Category has been deleted successfully.");        
        return Redirect::to('/manage-category');
    }
}
