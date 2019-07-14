<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Auth;
use Session;
use DB; 

class ExportTemplateManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$data['records'] = \App\Models\Template::where('created_by', Auth::user()->id)->get();
		return view('export_template.home', ['data'=>$data]);
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
        /*$data['dynamic_fields'] = DB::table('product_dynamic_fields')        
                                        ->select('field_name')
                                        ->distinct()
                                        ->where('created_by',  Auth::user()->id)
                                        ->orderBy('dynamic_field_row_id')
                                        ->get();*/
        $data['dynamic_fields'] = config('site_config.product_dynamic_fields');
        //dd($data['dynamic_fields']);
        $data['price_list'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->get();
		return view('export_template.create', ['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $template_model = new \App\Models\Template;
		if($request->template_row_id) {
		    $template_model = $template_model::where('created_by', Auth::user()->id)->find($request->template_row_id);
			$template_model->updated_by = Auth::user()->id;  		  
			Session::flash('success-message', 'Template has beed updated successfully.');        
		} else {	
			if(\App\Models\Template::where('template_name', $request->template_name)->first())
			{
				Session::flash('error-message', 'Template name already exist!.');		 
				return Redirect::to('/add-export-template');
			}
			$template_model->created_by = Auth::user()->id;
			Session::flash('success-message', 'Template has beed added successfully.');        
		}		
		
		$template_model->template_name = $request->template_name;    
		$template_model->file_name = $request->file_name;  
		$template_model->template_fields = json_encode($request->template_fields);  
		
        $template_model->save();
        return Redirect::to('/manage-export-template');
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
        /*$data['dynamic_fields'] = DB::table('product_dynamic_fields')                                       
                                        ->select('field_name')
                                        ->distinct()
                                        ->where('created_by',  Auth::user()->id)
                                        ->orderBy('dynamic_field_row_id')
                                        ->get();*/
        $data['dynamic_fields'] = config('site_config.product_dynamic_fields');
		$data['single_record'] = \App\Models\Template::where( [ 'created_by'=>Auth::user()->id,  'template_row_id'=>$id ] )->first();		
		$data['price_list'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->get();
		return view('export_template.edit', ['data'=>$data]);		
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
		$template_model = new \App\Models\Template;
		$template_model = $template_model::where('created_by', Auth::user()->id)->find($id);
		$template_model->delete();		
		Session::flash('success-message', "Template has been deleted successfully.");        
        return Redirect::to('/manage-export-template');
    }
}
