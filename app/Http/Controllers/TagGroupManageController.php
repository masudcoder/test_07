<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Auth;
use Session;
class TagGroupManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //		
		$data['records'] = \App\Models\Tag_group::where('created_by', Auth::user()->id)->get();
		return view('tag_group.tag_home', ['data'=>$data]);
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
		return view('tag_group.tag_create', ['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	
	
        $tag_model = new \App\Models\Tag_group;
		
		if($request->edit_row_id)
		{
		    $tag_model = $tag_model::where('created_by', Auth::user()->id)->find($request->edit_row_id);
			$tag_model->updated_by = Auth::user()->id;  		  
			Session::flash('success-message', 'Tag Group has been updated successfully.');    
		} else
		{
			$tag_model->created_by = Auth::user()->id;
			Session::flash('success-message', 'Tag Group has been added successfully.');    
		}
				
		$tag_model->tag_group_name = $request->tag_group_name;          		
        $tag_model->save();
		
		    
        return Redirect::to('/manage-tag-group');
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
		$data['single_record'] = \App\Models\Tag_group::where( [ 'created_by'=>Auth::user()->id,  'tag_group_row_id'=>$id ] )->first();		
		return view('tag_group.tag_create', ['data'=>$data]);		
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
		$tag_model = new \App\Models\Tag_group;
		$tag_model = $tag_model::where('created_by', Auth::user()->id)->find($id);
		$tag_model->delete();
		
		Session::flash('success-message', "Tag Group has been deleted successfully.");        
        return Redirect::to('/manage-tag-group');
		
    }
}
