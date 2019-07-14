<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Auth;
use Session;
class DescriptionManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //		
		$data['records'] = \App\Models\Description::where('created_by', Auth::user()->id)->get();
		return view('description.description_home', ['data'=>$data]);
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
		return view('description.description_create', ['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $description_model = new \App\Models\Description;
		
		if($request->edit_row_id)
		{
		    $description_model = $description_model::where('created_by', Auth::user()->id)->find($request->edit_row_id);
			$description_model->updated_by = Auth::user()->id;  		  
			Session::flash('success-message', 'Description has beed updated successfully.');        
		} else
		{
			$description_model->created_by = Auth::user()->id;
			Session::flash('success-message', 'Description has beed added successfully.');        
		}
		
		
		$description_model->description_name = $request->description_name;        		
		$description_model->description_text = $request->description_text;
        $description_model->save();		
        return Redirect::to('/manage-description');
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
		$data['single_record'] = \App\Models\Description::where( [ 'created_by'=>Auth::user()->id,  'description_row_id'=>$id ] )->first();		
		return view('description.description_create', ['data'=>$data]);		
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
		$description_model = new \App\Models\Description;
		$description_model = $description_model::where('created_by', Auth::user()->id)->find($id);
		$description_model->delete();
		
		Session::flash('success-message', "Description has been deleted successfully.");        
        return Redirect::to('/manage-description');
    }
}
