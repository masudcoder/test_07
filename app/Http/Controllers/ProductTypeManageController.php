<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Auth;
use Session;
class ProductTypeManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //		
		$data['records'] = \App\Models\Product_type::where('created_by', Auth::user()->id)->get();
		return view('product_type.product_type_home', ['data'=>$data]);
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
		return view('product_type.product_type_create', ['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product_type_model = new \App\Models\Product_type;
		
		if($request->edit_row_id)
		{
		    $product_type_model = $product_type_model::where('created_by', Auth::user()->id)->find($request->edit_row_id);
			$product_type_model->updated_by = Auth::user()->id;  		  
			Session::flash('success-message', 'Product type has been updated successfully.');    
		} else
		{
			$product_type_model->created_by = Auth::user()->id;
			Session::flash('success-message', 'Product type has been added successfully.');    
		}
				
		$product_type_model->product_type_name = $request->product_type_name;          		
		$product_type_model->product_type_short_description = $request->product_type_short_description;
        $product_type_model->save();
		
		Session::flash('success-message', 'Product type has been added successfully.');        
        return Redirect::to('/manage-product-type');
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
		$data['single_record'] = \App\Models\Product_type::where( [ 'created_by'=>Auth::user()->id,  'product_type_row_id'=>$id ] )->first();		
		return view('product_type.product_type_create', ['data'=>$data]);		
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
		$product_type_model = new \App\Models\Product_type;
		$product_type_model = $product_type_model::where('created_by', Auth::user()->id)->find($id);
		$product_type_model->delete();
		
		Session::flash('success-message', "Product Type has been deleted successfully.");        
        return Redirect::to('/manage-product-type');
		
    }
}
