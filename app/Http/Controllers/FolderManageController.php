<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Auth;
use Session;
class FolderManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //		
		$data['records'] = \App\Models\Folder::where('created_by', Auth::user()->id)->get();
		return view('preset_folder.folder_home', ['data'=>$data]);
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
		return view('preset_folder.folder_create', ['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $folder_model = new \App\Models\Folder;
		
		if($request->edit_row_id)
		{
		    $folder_model = $folder_model::where('created_by', Auth::user()->id)->find($request->edit_row_id);
			$folder_model->updated_by = Auth::user()->id;  		  
			Session::flash('success-message', 'Folder has beed updated successfully.');        
		} else
		{
			$folder_model->created_by = Auth::user()->id;
			Session::flash('success-message', 'Folder has beed added successfully.');        
		}
		
		
		$folder_model->folder_name = $request->folder_name;        		
        $folder_model->save();		
        return Redirect::to('/manage-folder');
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
		$data['single_record'] = \App\Models\Folder::where( [ 'created_by'=>Auth::user()->id,  'folder_row_id'=>$id ] )->first();		
		return view('preset_folder.folder_create', ['data'=>$data]);		
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
		$folder_model = new \App\Models\Folder;
		$folder_model = $folder_model::where('created_by', Auth::user()->id)->find($id);
		$folder_model->delete();
		
		Session::flash('success-message', "Folder has been deleted successfully.");        
        return Redirect::to('/manage-folder');
    }
}
