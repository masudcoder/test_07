<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Auth;
use Session;
class VendorManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //		
		$data['records'] = \App\Models\Vendor::where('created_by', Auth::user()->id)->orderBy('vendor_row_id', 'DESC')->get();
		$data['countries'] = \App\Models\Country::get();
		return view('vendor.vendor_home', ['data'=>$data]);
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
		$data['countries'] = \App\Models\Country::get();	
		return view('vendor.vendor_create', ['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vendor_model = new \App\Models\Vendor;
		
		if($request->edit_row_id)
		{
		    $vendor_model = $vendor_model::where('created_by', Auth::user()->id)->find($request->edit_row_id);
			$vendor_model->updated_by = Auth::user()->id;  	
			Session::flash('success-message', 'Vendor has beed updated successfully.'); 			
		} else
		{
			$vendor_model->created_by = Auth::user()->id;
			Session::flash('success-message', 'Vendor has beed added successfully.'); 
		}
		
		
		$vendor_model->vendor_name = $request->vendor_name;  
        $vendor_model->vendor_note = $request->vendor_note;					
		$vendor_model->postal_code = $request->postal_code;
		$vendor_model->city = $request->city;
		$vendor_model->state = $request->state;
		$vendor_model->country = $request->country == 'none' ? '' : $request->country;
        $vendor_model->save();		       
        return Redirect::to('/manage-vendor');
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
		$data['single_record'] = \App\Models\Vendor::where( [ 'created_by'=>Auth::user()->id,  'vendor_row_id'=>$id ] )->first();	
		$data['countries'] = \App\Models\Country::get();		
		return view('vendor.vendor_create', ['data'=>$data]);		
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
		$vendor_model = new \App\Models\Vendor;
		$vendor_model = $vendor_model::where('created_by', Auth::user()->id)->find($id);
		$vendor_model->delete();
		
		Session::flash('success-message', "Vendor has been deleted successfully.");        
        return Redirect::to('/manage-vendor');
    }
}
