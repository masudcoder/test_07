<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Session;
use Excel;
use DB;
use Illuminate\Support\Facades\Input;

class SalesTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function __construct()
    {
		$this->middleware('auth');
		
    } 
    public function index()
    {
        //
		$data['records'] = \App\Models\ImportSalesTemplate::where('created_by', Auth::user()->id)->get();
		return view('import_sales_template.home', ['data'=>$data]);
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
		return view('import_sales_template.create', ['data'=>$data]);
    }

    
	
	/* First Form */
	public function storeImportTemplate(Request $request) {	
    	$user_id = Auth::user()->id;
        $template_model = new \App\Models\ImportSalesTemplate;
		
		if($request->edit_row_id) {
		    $template_model = $template_model::where('created_by', Auth::user()->id)->find($request->edit_row_id);
			$template_model->updated_by = Auth::user()->id;  		  
			Session::flash('success-message', 'Template has beed updated successfully.');        
		} else {			
			if(\App\Models\ImportSalesTemplate::where('template_name', $request->template_name)->first()) {
				Session::flash('error-message', 'Template name already exist!.');		 
				return Redirect::to('/add-import-template');
			}
			$template_model->created_by = Auth::user()->id;
			Session::flash('success-message', 'Template has beed added successfully.');        
		}	
		
		$template_model->template_name = $request->template_name;    		
		if(Input::hasFile('import_file')) {
			$path = Input::file('import_file')->getRealPath();
			$rows = array_map('str_getcsv', file($path));		
			$rows_original = $rows;			
			$header = array_shift($rows);
			$header_original = array_shift($rows_original);
			array_walk($header, function(&$value) {
				$value = trim($value);
				$value = trim($value, '#');
				$value = trim($value);
				$value = str_replace(' + ', '_', strtolower($value));
				$value = str_replace('+', '_', strtolower($value));
				$value = str_replace(' ', '_', strtolower($value));
				$value = str_replace('.', '_', strtolower($value));				
				$value = str_replace('__', '_', strtolower($value));				
			});

			$template_model->template_fields = json_encode($header);    
			$template_model->template_fields_original = json_encode($header);
			  
			$template_model->count_fields = count($header);
			$template_model->save();	
			$template_row_id = $template_model->sales_template_row_id;

			// Save Template Heads
			$template_csv_heads_data = array(); 
			$arr = []; 
			$data = Excel::load($path, function($reader) {
					})->get();

			
			for($i=0;$i<count($header); $i++) {
				if(! $header_original[$i])
				continue;

				$count_sample_data = 0;
				$headSampleData = '';
			 	foreach ($data as $key => $value) {				 		
					if($count_sample_data >= 3) {
						$arr[] = [
									$header[$i] => trim($headSampleData, ','),
								];
						break;		
					}
					$temp_csv_header = trim($header[$i]);
					$headSampleData .= $value->$temp_csv_header;
					$headSampleData .= ',';
					$count_sample_data++;
				}	
			}
			
			if($arr) {
				$template_model = $template_model::where('created_by', Auth::user()->id)->find($template_row_id);
				$template_model->sample_data =  json_encode($arr);
				$template_model->save();
			}
		}
		
		return Redirect::to('import-sales-template/' . $template_row_id);
		
    }
	
	public function viewTemplate($id) {
		$data['template_info'] = \App\Models\ImportSalesTemplate::where('sales_template_row_id', $id)->first();		
		$data['vendors_list'] = \App\Models\Vendor::where('created_by', Auth::user()->id)->get();		
		$data['collections_list'] = \App\Models\Collection::where('created_by', Auth::user()->id)->get();
		$data['categories_list'] = \App\Models\Category::where('created_by', Auth::user()->id)->get();
		$data['product_types_list'] = \App\Models\Product_type::where('created_by', Auth::user()->id)->get();		
		$data['price_levels_list'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->get();		
		return view('import_sales_template.csv_fields', ['data'=>$data]);
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
		die('coming soon');
		$data['single_record'] = \App\Models\Template::where( [ 'created_by'=>Auth::user()->id,  'template_row_id'=>$id ] )->first();		
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
		
		$template_model = new \App\Models\ImportSalesTemplate;
		$template_model = $template_model::where([['created_by', Auth::user()->id],['sales_template_row_id', $id] ])->find($id);
		$template_model->delete();
		
		Session::flash('success-message', "Template has been deleted successfully.");        
        return Redirect::to('/manage-sales-template');
    }
	
	// Template Second Form save, manual mapping, etc.
	public function templateImport(Request $request) {
		$ImportTemplate_model = new \App\Models\ImportSalesTemplate;
		$ImportTemplate_model = $ImportTemplate_model::find($request->template_row_id);
		$ImportTemplate_model->manual_mapping = trim(trim($request->manual_mapping), ',');
		$ImportTemplate_model->skip_first_line = $request->skip_first_line ? 1 : 0;   
		$ImportTemplate_model->send_email_confirmation = $request->send_email_confirmation ? 1 : 0; 
		$ImportTemplate_model->static_assignment = trim(trim($request->static_assignment), ',');
		$ImportTemplate_model->csv_field_db_mapping = json_encode($request->csv_field_db_mapping);
		$ImportTemplate_model->save();
		Session::flash('success-message', "Template has been updated successfully."); 
		return Redirect::to('import-sales-template/' .  $request->template_row_id);		
	}

	
	public function importSalesExcel(Request $request) {
	 
		$user_id = Auth::user()->id;		
		$template_row_id = $request->sales_template_row_id ? $request->sales_template_row_id : 0;
		$template_info = \App\Models\ImportSalesTemplate::where('sales_template_row_id', $template_row_id)->first();
		$sales_data_option = $request->sales_data_option;
		$all_fields =   [
							'order_id', 'order_date', 'product_name', 'product_sku', 'upc', 'product_price', 'quantity', 'total_amount', 'customer_info'
						];


									
		$manual_mapping_field_names['order_date'] = 'Order Date';								
		$manual_mapping_field_names['product_name'] = 'Product Name';							
		$manual_mapping_field_names['product_sku'] = 'Product SKU';		
		$manual_mapping_field_names['upc'] = 'UPC';
		$manual_mapping_field_names['quantity'] = 'Quantity';
		$manual_mapping_field_names['product_price'] = 'Product Price';
		$manual_mapping_field_names['total_amount'] = ' Total Amou';
		$manual_mapping_field_names['customer_info'] = 'Customer info';

		$manual_mapping_field_names_reverse = array_flip($manual_mapping_field_names);

		$manual_mapping_arr = array();
		if($template_info) {
			$manual_mapping_arr = explode(',' , $template_info->manual_mapping);
		}
		
		$manual_map_arr = array();
		
		if(count($manual_mapping_arr)) {
			foreach($manual_mapping_arr as $key=>$val) {
				if(!$val)
				continue;
				
				$temp_arr = explode('=', $val);
				$newKey = str_replace(' ', '_', strtolower (trim($temp_arr[0])));
				  
				$newVal = trim($temp_arr[1]);
				if ( ! in_array($newVal, $manual_mapping_field_names_reverse)) 
				{		    
					if(in_array($newVal, $manual_mapping_field_names)) {				
						$newVal  = array_search($newVal, $manual_mapping_field_names); 				
					}
				}
				$manual_map_arr[$newKey] = $newVal;
			}
		}
		
		$static_value_arr = array();
		if($template_info && $template_info->static_assignment) {
			$static_value_arr = explode(',' , $template_info->static_assignment);
		}		
		$static_map_arr = array();

		/*
			
		*/
		if(count($static_value_arr)) {
			foreach($static_value_arr as $key=>$val) {				
				$temp_arr = explode('==', $val);				
				$newKey = str_replace(' ', '_', strtolower (trim($temp_arr[0])));				  
				
				if(isset($temp_arr[1])) {
				  $newVal = trim($temp_arr[1]);
				} else {
					$newVal = '';
				}
				
				$static_map_arr[$newKey] = $newVal;
			}
		}
		//dd($static_map_arr);
		$manual_map_arr_flip = array_flip($manual_map_arr);
		
		if(Input::hasFile('import_file')) {
			$path = Input::file('import_file')->getRealPath();		

			$data = Excel::load($path, function($reader) {
			})->get();
			
			$insert = array();	
			$lineSkiped = 0;
			$lineImported = 0;
			$listSkippedLine = array();
			$i = 0; // which line has been  skipped.

			if(!empty($data) && $data->count()) {
				foreach ($data as $key => $value) {

				$i++;
				// if code  is not available in row then skip the row.
				if(! isset($value['code']) || !$value['code'] ) {
					$lineSkiped++;										
					$listSkippedLine[] = $i;
					continue;
				}
				// find out the product against the code
				$product_info = \App\Models\Product::where('product_sku', $value['code'])->first();
				if($product_info) {						
						$product_row_id = $product_info->product_row_id;	
						if($sales_data_option == 2) // replace sales data with the ncurrent data.
						{
							$ProductSalesData = \App\Models\ProductSalesData::where('product_row_id', $product_row_id)->delete();
							
						}

						$lineImported ++;							
					}  else {
						$lineSkiped++;					
						$listSkippedLine[] = $i;
						continue;
				}

				if($template_row_id) {
						$csv_field_db_mapping =  json_decode($template_info->csv_field_db_mapping, true);

						if( !is_array($csv_field_db_mapping)) {
							Session::flash('error-message', 'No Product has been imported, May be this template has all fields skipped settings.'); 
							return Redirect::to('/manage-sales-template');
						}						
						//validation
						$csv_db_fields = array_values($csv_field_db_mapping);
						if(!array_filter($csv_db_fields)) {
							Session::flash('error-message', 'No Product has been imported, May be this template has all fields skipped settings.'); 
							return Redirect::to('/manage-sales-template');
						}

						$product_row = array();		
						$build_dynamic_field_row = [];
						$checkDbField = true;

						foreach($value as $key=>$val) {

							if(!$val)
							continue;

							// because no need to insert product name.
							if($key == 'product_name' || $key=='name' || $key=='code')
								continue;

							$product_row['product_row_id'] = $product_row_id;
						
						    /* check is the values of the head assigned statically */
							/*if ( array_key_exists($key, $static_map_arr)) {								
								$product_row[$key] = $static_map_arr[$key];								
								continue;								
							}
							*/

							/* check this head of csv is mapped in manual maaping, is yes then just execute this code 
								and go to nxt head
							*/
														
							if ( in_array($key, $manual_map_arr_flip)) {
								$dbField = array_search($key, $manual_map_arr_flip);
								$product_row[$dbField] = $val;								
								continue;
							}
							
							if( !isset($csv_field_db_mapping[$key]) || (!$csv_field_db_mapping[$key]) ) { 
								$temp[$key] = $val;
								continue;							
							}
														
							if(! in_array($csv_field_db_mapping[$key], $all_fields)) {
								$build_dynamic_field_row[$csv_field_db_mapping[$key]]= $val;
							} 
							else {							
								if( in_array($csv_field_db_mapping[$key], $manual_map_arr)) {
									continue;								
								}

								if($csv_field_db_mapping[$key] == 'order_date') {
								$product_row[$csv_field_db_mapping[$key]] = date('Y-m-d h:i:s', strtotime($val));
								} else {									
									$product_row[$csv_field_db_mapping[$key]] = $val;
								}
							}
							
						}		
						
						$product_row['created_by'] = $user_id;
						foreach($static_map_arr as $dbCol=>$colValue) {						
						   $product_row[$dbCol] = $colValue;
						}
						
						$sales_data_row_id = DB::table('product_sales_datas')->insertGetId($product_row);
						Session::flash('error-message', $lineSkiped . ' lines has been skipped.'); 
						
						//dd($listSkippedLine);
					
						if($build_dynamic_field_row) {
							foreach($build_dynamic_field_row as $dynamicFieldKey=>$dynamicFieldVal) {
								$arr['field_name'] = $dynamicFieldKey;
								$arr['field_value'] = $dynamicFieldVal;
								$arr['product_row_id'] = $product_row_id;
								//DB::table('product_dynamic_fields')->insert($arr);
							}
						}
					} else {
						
						/*

						if($key == 'code') {
									$product_info = \App\Models\Product::where('product_sku', $val)->first();
									$product_row_id = $product_info->product_row_id;
									$product_row_id = 2;
								}

						$insert = [
						'product_row_id' => $product_row_id,
						'order_id'=>$value->order_id,						
						'order_date'=>$value->order_date,											
						'customer_info' => $value->customer_info,
						'product_price' => $value->price ? $value->price : 0,
						'quantity'=> $value->quantity,
						'total_amount'=> $value->product_total,
						];

						DB::table('products')->insert($insert);
						*/
					}						
				
				}
			}

			Session::flash('error-message', $lineSkiped . ' lines has been skipped.'); 	
			if($lineImported) {
				Session::flash('success-message', $lineImported .'Sales data has been imported Successfully.');	
			}
			
		  	return Redirect::to('/manage-sales-template');	
		}
		return back();
	}

}
