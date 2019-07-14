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

class ImportTemplateManageController extends Controller
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
		$data['records'] = \App\Models\ImportTemplate::where('created_by', Auth::user()->id)->get();
		return view('import_template.home', ['data'=>$data]);
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
		return view('import_template.create', ['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	// while uploading csv this method is called. 
    /*public function storeImportTemplate(Request $request)
    {
    	$user_id = Auth::user()->id;
        $template_model = new \App\Models\ImportTemplate;
		
		if($request->edit_row_id){
		    $template_model = $template_model::where('created_by', Auth::user()->id)->find($request->edit_row_id);
			$template_model->updated_by = Auth::user()->id;  		  
			Session::flash('success-message', 'Template has beed updated successfully.');        
		} else {			
			if(\App\Models\ImportTemplate::where('template_name', $request->template_name)->first())
			{
				Session::flash('error-message', 'Template name already exist!.');		 
				return Redirect::to('/add-import-template');
			}
			$template_model->created_by = Auth::user()->id;
			Session::flash('success-message', 'Template has beed added successfully.');        
		}	
		
		$template_model->template_name = $request->template_name;    
		//$template_model->order_match_column = $request->order_match_column;  
		if(Input::hasFile('import_file')) 
	    {
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
				$value = str_replace('___', '_', strtolower($value));
			});
			$template_model->template_fields = json_encode($header);    
			$template_model->count_fields = count($header);
			$template_model->save();	
			$template_row_id = $template_model->template_row_id;
			
			// Save Template Heads
			$template_csv_heads_data = array(); 
			for($i=0;$i<count($header); $i++) {  
				$template_csv_heads_data[] = ['csv_head_name' => $header[$i], 'csv_head_name_original' => $header_original[$i], 'template_row_id' => $template_row_id];
			}
			if(!empty($template_csv_heads_data)) {
				DB::table('template_csv_heads')->insert($template_csv_heads_data);				
			}
			
			$csv = array();			
			foreach ($rows as $row) {
			  $csv[] = array_combine($header, $row);
			}
			
			$data = Excel::load($path, function($reader) {
				})->get();
				
			if(!empty($data) && $data->count()) {
				$template_csv_values_data = array();
				$template_csv_heads = DB::table('template_csv_heads')->where('template_row_id', $template_row_id)->get();
				foreach ($template_csv_heads as $key => $csvHead)
				{
					$count_sample_data = 0;
				    foreach ($data as $key => $value) 
					{				
						$head_name = $csvHead->csv_head_name;
						$csv_head_row_id = $csvHead->csv_head_row_id;
						
						$template_csv_values_data[] = [
						'csv_head_row_id' => $csv_head_row_id,
						'csv_value_name' => $value->$head_name,
						];
						
						$count_sample_data++;										
						if($count_sample_data == 3)
						break;
					
					}
					
				}
		
				if(!empty($template_csv_values_data))
				{
					DB::table('template_csv_values')->insert($template_csv_values_data);				
				}
			}
		}
		// Session::flash('success-message', 'Template has been updated successfully.');		 
		return Redirect::to('/import-template/' .  $template_model->template_row_id);
		
    }
	*/
	
	/* First Form */
	public function storeImportTemplate(Request $request) {		
    	$user_id = Auth::user()->id;
        $template_model = new \App\Models\ImportTemplate;
		
		//Validation, iF Not csv file then SHOW ERROR
		if(Input::hasFile('import_file')) {
			$name = $_FILES["import_file"]["name"];
			$extArr = explode('.', $name);

			if( strtolower( end($extArr) ) != 'csv' ) {
				Session::flash('error-message', 'Please upload csv file, Download a sample CSV file given below.');		 
			    return Redirect::to('/add-import-template');
			}
		}

		if($request->edit_row_id) {
		    $template_model = $template_model::where('created_by', Auth::user()->id)->find($request->edit_row_id);
			$template_model->updated_by = Auth::user()->id;  		  
			Session::flash('success-message', 'Template has beed updated successfully.');        
		} else {			
			if(\App\Models\ImportTemplate::where('template_name', $request->template_name)->first()) {
				Session::flash('error-message', 'Template name already exist!.');		 
				return Redirect::to('/add-import-template');
			}
			$template_model->created_by = Auth::user()->id;
			Session::flash('success-message', 'Template has beed added successfully.');        
		}	
		
		$template_model->template_name = $request->template_name;    
		//$template_model->order_match_column = $request->order_match_column;  
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
				$value = str_replace('#', '', strtolower($value));
				$value = str_replace('(', '', strtolower($value));
				$value = str_replace(')', '', strtolower($value));
				$value = str_replace('-', '_', strtolower($value));
				//$value = str_replace('#', '', strtolower($value));
				$value = str_replace('+', '_', strtolower($value));
				$value = str_replace(' ', '_', strtolower($value));
				$value = str_replace('.', '_', strtolower($value));				
				$value = str_replace('__', '_', strtolower($value));
				$value = str_replace('___', '_', strtolower($value));
			});
			$template_model->template_fields = json_encode($header);    
			$template_model->count_fields = count($header);
			$template_model->save();	
			$template_row_id = $template_model->template_row_id;
			
			// Save Template Heads
			$template_csv_heads_data = array(); 
			
			for($i=0;$i<count($header); $i++) {
				if(! $header_original[$i])
				continue;
				$template_csv_heads_data[] = ['csv_head_name' => $header[$i], 'csv_head_name_original' => $header_original[$i], 'template_row_id' => $template_row_id];
			}
			
			if(!empty($template_csv_heads_data)) {
				DB::table('template_csv_heads')->insert($template_csv_heads_data);				
			}
			
			$csv = array();			
			foreach ($rows as $row) {
			  $csv[] = array_combine($header, $row);
			}
			
			$data = Excel::load($path, function($reader) {
				})->get();
				
			if(!empty($data) && $data->count()) {
				$template_csv_values_data = array();
				$template_csv_heads = DB::table('template_csv_heads')->where('template_row_id', $template_row_id)->get();
				foreach ($template_csv_heads as $key => $csvHead) {
					$count_sample_data = 0;					
				    foreach ($data as $key => $value) {			
						$head_name = $csvHead->csv_head_name;
						$csv_head_row_id = $csvHead->csv_head_row_id;
						//dd($value);
						$template_csv_values_data[] = [
						'csv_head_row_id' => $csv_head_row_id,
						'csv_value_name' => $value->$head_name,
						];
						
						$count_sample_data++;										
						if($count_sample_data == 3)
						break;
					
					}
				}
		
				if(!empty($template_csv_values_data))
				{					
					DB::table('template_csv_values')->insert($template_csv_values_data);				
				}
			}
		}
		//exit;
		// Session::flash('success-message', 'Template has been updated successfully.');		 
		return Redirect::to('/import-template/' .  $template_model->template_row_id);
		
    }
	
	public function viewTemplate($id) {
		$data['template_info'] = \App\Models\ImportTemplate::with('csv_heads')->where('template_row_id', $id)->first();		
		$data['vendors_list'] = \App\Models\Vendor::where('created_by', Auth::user()->id)->get();		
		$data['collections_list'] = \App\Models\Collection::where('created_by', Auth::user()->id)->get();
		$data['categories_list'] = \App\Models\Category::where('created_by', Auth::user()->id)->get();
		$data['product_types_list'] = \App\Models\Product_type::where('created_by', Auth::user()->id)->get();	
		$data['price_levels_list'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->get();
		$data['records'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->orderBy('customer_group_row_id', 'asc')->get()->toArray();
		//dd($data['template_info']);

		return view('import_template.csv_fields', ['data'=>$data]);
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
		$template_model = new \App\Models\ImportTemplate;
		$template_model = $template_model::where([['created_by', Auth::user()->id],['template_row_id', $id] ])->find($id);
		$template_model->delete();		
		
		$csvHeads = DB::Table('template_csv_heads')->where('template_row_id', $id)->get();

		foreach ($csvHeads as $key => $value) {  // delete all csv valu that has those csv row id
			$sql= "DELETE  FROM template_csv_values WHERE csv_head_row_id = " . $value->csv_head_row_id;
			$results  = DB::select($sql);
		}

		$sql= "DELETE  FROM template_csv_heads WHERE template_row_id = " . $id;
		$results  = DB::select($sql);

		//import_template_automation_rules
		$sql= "DELETE  FROM import_template_automation_rules WHERE template_row_id = " . $id;
		$results  = DB::select($sql);

		// another delete from csv values
		
		
		Session::flash('success-message', "Template has been deleted successfully.");        
        return Redirect::to('/manage-import-template');
    }
	
	// Template Second Form save, manual mapping, etc.
	public function templateImport(Request $request)
	{
	
		//if(array_key_exists('vendor_row_id', $request->csv_field_db_mapping)) {
		//	$request->csv_field_db_mapping['vendor_row_id'] = 'vendor_row_id';
		//}
		$ImportTemplate_model = new \App\Models\ImportTemplate;
		$ImportTemplate_model = $ImportTemplate_model::find($request->template_row_id);		
		$ImportTemplate_model->manual_mapping = trim(trim($request->manual_mapping), ',');
		$ImportTemplate_model->static_assignment = trim(trim($request->static_assignment), ',');		
		$ImportTemplate_model->skip_first_line = $request->skip_first_line ? 1 : 0;
		$ImportTemplate_model->send_email_confirmation = $request->send_email_confirmation ? 1 : 0;		
		$ImportTemplate_model->csv_field_db_mapping = json_encode($request->csv_field_db_mapping);		
		//$ImportTemplate_model->head_replace_to = json_encode($request->head_replace_to);		
		$ImportTemplate_model->save();
		
		$head_replace_to = $request->head_replace_to;		
		$template_csv_heads = \App\Models\TemplateCsvHead::where('template_row_id', $request->template_row_id)->orderBy('csv_head_row_id')->get();		
		$i=0;
		foreach($template_csv_heads as $csvHead) {
			$templateCsvHead = \App\Models\TemplateCsvHead::find($csvHead->csv_head_row_id);			
			$templateCsvHead->head_replace_to = $head_replace_to[$i];
			$templateCsvHead->save();
			$i++;	
		}
	
		Session::flash('success-message', "Template has been updated successfully."); 
		return Redirect::to('/manage-import-template');
		/*
		$user_id = Auth::user()->id;
		$template_row_id = $request->template_row_id ? $request->template_row_id : 0;
		
	   if(Input::hasFile('import_file')) {
			$path = Input::file('import_file')->getRealPath();
			$rows = array_map('str_getcsv', file($path));
			
			$header = array_shift($rows);
			$csv = array();
			foreach ($rows as $row) {
			  $csv[] = array_combine($header, $row);
			}
			
			$data = Excel::load($path, function($reader) {
			})->get();
			
			
			if(!empty($data) && $data->count()) 
			{
				foreach ($data as $key => $value) 
				{	$insert = array();
					if($template_row_id)
					{
						$insert = [
						'product_name' => $value->ProductType,
						'handle' => $value->handle,
						'product_price' => $value->price ? $value->price : 0,
						'product_sku' => $value->sku,
						'upc' => $value->upc,								
						'created_by' =>$user_id,
						];
					
					} 
					else
					{
						$insert = [
						'product_name' => $value->name,
						'handle' => $value->handle,
						'product_price' => $value->price ? $value->price : 0,
						'product_sku' => $value->sku,
						'upc' => $value->upc,
						'product_long_description'=> $value->description,
						'product_image'=>$value->image,	
						'image_external_link'=>1,
						'product_height'=>$value->height,	
						'product_height_unit'=>$value->height_unit,
						'product_width'=>$value->width,	
						'product_width_unit'=>$value->width_unit,
						'product_length'=>$value->length,
						'product_length_unit'=>$value->length_unit,					
						'product_weight'=>$value->weight,	
						'product_weight_unit'=>$value->weight_unit,
						'product_meta_title'=>$value->meta_title,	
						'product_meta_keyword'=>$value->meta_keyword,	
						'product_meta_description'=>$value->meta_description,	
						'created_by' =>$user_id,
						];
					}			
					
					DB::table('products')->insert($insert);					
				}							
			}			
		
		  Session::flash('success-message', 'Products has been imported Successfully.');        
		  return Redirect::to('/manage-product');
		  
		}*/
	}

	/**
	  id: template_row_id
	*/
	public function automatedRules(Request $request, $template_row_id=0) {		
		
		if($request->isMethod('post')) {
			$template_row_id = $request->template_row_id;
			
			if($request->field) {
				$data['rules'] = json_encode($request->field);
				$data['template_row_id'] =  $request->template_row_id;
				$data['product_column_name'] =  $request->selected_db_field_name;
				DB::table('import_template_automation_rules')->insert($data);			
				Session::flash('success-message', 'Automation rules has been assigned to import template successfully.');
			} else {
				Session::flash('error-message', 'Select at least one item.');
			}

			return redirect('/automated-rules/' . $template_row_id);
		}

		$data['template_info'] = \App\Models\ImportTemplate::with('csv_heads')->where('template_row_id', $template_row_id)->first();
		$data['automation_rules'] = \App\Models\ImportTemplateAutomationRule::where('template_row_id', $template_row_id)->orderBy('import_template_automation_rule_id', 'DESC')->get();	
		$data['template_csv_heads'] = DB::table('template_csv_heads')->where([ ['template_row_id', $template_row_id], ['head_replace_to','!=', ''] ])->get();
		$data['vendors_list'] = \App\Models\Vendor::where('created_by', Auth::user()->id)->get();		
		$data['collections_list'] = \App\Models\Collection::where('created_by', Auth::user()->id)->get();
		$data['categories_list'] = \App\Models\Category::where('created_by', Auth::user()->id)->get();
		$data['product_types_list'] = \App\Models\Product_type::where('created_by', Auth::user()->id)->get();	
		$data['price_levels_list'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->get();
		$data['records'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->orderBy('customer_group_row_id', 'asc')->get()->toArray();
		return view('import_template.automated_rules', ['data'=>$data]);

	}


	public function manageVendorTemplate()
    {
        //
		$data['records'] = [];
		//$data['records'] = \App\Models\ImportTemplate::where('created_by', Auth::user()->id)->get();
		return view('import_template.manage-vendor-template', ['data'=>$data]);
    }
}
