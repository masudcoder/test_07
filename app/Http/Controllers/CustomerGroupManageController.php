<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Auth;
use Session;
class CustomerGroupManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //		
		$data['records'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->orderBy('customer_group_row_id', 'asc')->get();
		return view('customer_group.customer_group_home', ['data'=>$data]);
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
		return view('customer_group.customer_group_create', ['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer_group_model = new \App\Models\Customer_group;
		
		if($request->edit_row_id)
		{
		    $customer_group_model = $customer_group_model::where('created_by', Auth::user()->id)->find($request->edit_row_id);
			$customer_group_model->updated_by = Auth::user()->id;  		  
			Session::flash('success-message', 'Price Type has been updated successfully.');    
		} else
		{
			$customer_group_model->created_by = Auth::user()->id;
			Session::flash('success-message', 'Price Type has been added successfully.');    
		}
				
		$customer_group_model->customer_group_name = $request->customer_group_name;  
        $customer_group_model->customer_group_short_description = $request->customer_group_short_description;			
        $customer_group_model->save();
		
		  
        return Redirect::to('/manage-price-type');
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
		$data['single_record'] = \App\Models\Customer_group::where( [ 'created_by'=>Auth::user()->id,  'customer_group_row_id'=>$id ] )->first();		
		return view('customer_group.customer_group_create', ['data'=>$data]);		
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
		$customer_group_model = new \App\Models\Customer_group;
		$customer_group_model = $customer_group_model::where('created_by', Auth::user()->id)->find($id);
		$customer_group_model->delete();
		
		Session::flash('success-message', "Price Type has been deleted successfully.");        
        return Redirect::to('/manage-price-type');
		
    }
}
