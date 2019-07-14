<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\File;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use App\Models\Product;
use App\Models\Common;
use App\Library\CommonLib;
use App\Library\SimpleImage;


use Session;
use DB;
use Auth;
use Excel;
use Illuminate\Support\Facades\Input;
use App\Classes\OrderDeskApiClientClass;
use Image;

class ProductController extends Controller
{
        private $editable_fields = [
        "product_name",
        "handle",
        "handle_url",
        "product_sku",
        "vendor_sku",
        "aku_code",
        "product_price",
        "product_price_unit",
        "is_deleted",
        "assign_to_folder",
        "is_favourite",
        "product_image",
        "product_secondary_images",
        "image_external_link",
        "uploaded_design_image",
        "product_cost",
        "distributor_price",
        "distributor_price_unit",
        "wholesale_price",
        "wholesale_price_unit",
        "retail_price",
        "retail_price_unit",
        "product_cost_unit",
        "product_length",
        "product_length_unit",
        "product_width",
        "product_width_unit",
        "product_height",
        "product_height_unit",
        "product_weight",
        "product_weight_unit",
        "ship_cartoon",
        "ship_weight",
        "ship_weight_unit",
        "ship_width",
        "ship_width_unit",
        "ship_length",
        "ship_length_unit",
        "ship_height",
        "ship_height_unit",
        "master_cartoon",
        "upc",
        "update_source",
        "number_of_pieces",
        "tag_group_row_id",
        "attribute_group1_row_id",
        "attribute_group2_row_id",
        "attribute_group3_row_id",
        "attribute_price",
        "attribute_sku",
        "attribute_barcode",
        "product_stock",
        "product_stock_type",
        "inventory_serial",
        "category_row_id",
        "collection_row_id",
        "vendor_row_id",
        "product_type_row_id",
        "folder_row_id",
        "is_featured",
        "is_latest",
        "product_short_description",
        "product_long_description",
        "product_meta_title",
        "product_meta_keyword",
        "product_meta_description"
    ];

    public function __construct()
    {
		$this->middleware('auth', ['except' => 'cronCreateThumb']);

		
    }

	public function index(Request $request)
    {
    $data = [];
    $data['search_result'] = 0;
    $page = $request->page ? $request->page : 0;
    $product_per_page = 50;
    //$this->productListToCreateThumb($page);
    $obCommonLib = new CommonLib();
    if($request->isMethod('post')) {    
    	$data['collection_match'] = $request->collection_match;
        $data['condition'] = $request->condition;
        $data['condition_type'] = $request->condition_type;
        $data['condition_value'] = $request->condition_value;
        $data['dynamic_field_name'] = $request->dynamic_field_name;
        $products = $obCommonLib->searchProduct($request); // get search product result, needs to paginate/get
        session()->put('search_result_products', 1); // flag to understand the data has been searched.
        $data['products_list'] = $products->paginate($product_per_page);
        $data['search_result'] = 1;
        
        session()->put('collection_match', $data['collection_match']);
        session()->put('condition', $data['condition']);
        session()->put('condition_type', $data['condition_type']);
        session()->put('condition_value', $data['condition_value']);
        session()->put('dynamic_field_name', $data['dynamic_field_name']);
    } else { // when form is not submitted
        
        if( $page) { //Form was submitted before, now pagination.
        $data['collection_match'] = $request->collection_match = session()->get('collection_match');
        $data['condition']  = $request->condition = session()->get('condition');
        $data['condition_type']  = $request->condition_type = session()->get('condition_type');
        $data['condition_value']  = $request->condition_value = session()->get('condition_value');
        $data['dynamic_field_name']  = $request->dynamic_field_name = session()->get('dynamic_field_name');
        
        if(session()->has('search_result_products')) {
             $products = $obCommonLib->searchProduct($request);
             $data['products_list'] = $products->paginate($product_per_page);
            //$search_result_products = session()->get('search_result_products');
            //$data['products_list'] = $search_result_products->paginate($product_per_page);
          //  dd($data['products_list']);
        }
        else{
            $data['products_list'] = DB::table('products')->where([ ['created_by', Auth::user()->id], ['is_deleted', '!=', 1]])->orderby('product_row_id', 'DESC')->paginate($product_per_page);   
        }
         //$data['products_list'] = DB::table('products')->where([ ['created_by', Auth::user()->id], ['is_deleted', '!=', 1]])->paginate($product_per_page);   
        
        
        } else { // just fresh product listing page , first time.
            session()->forget('collection_match');
            session()->forget('condition');
            session()->forget('condition_type');
            session()->forget('condition_value');
            session()->forget('dynamic_field_name');
            session()->forget('search_result_products');
            $data['products_list'] = DB::table('products')->where([ ['created_by', Auth::user()->id], ['is_deleted', '!=', 1]])->orderby('product_row_id', 'DESC')->paginate($product_per_page);
        }
    }    
    // test-2

    dd( $data['products_list'] ); 
    $data['product_dynamic_fields'] = config('site_config.product_dynamic_fields'); 
	$common_model = new Common();                         
    $data['categories_list'] = $common_model->allCategories();
	$data['user_id'] = Auth::user()->id;
	$data['import_templates'] = \App\Models\ImportTemplate::where('created_by', Auth::user()->id)->get();
	dd($data['import_templates']);  exit;
	return view('product.product_list', ['data'=>$data]);
    }

	public function getProductsAjax () {
		$data = [];
		return view('product.product_list', ['data'=>$data]);
	}

	function create()
	{	  
		//$this->Thumbnail('http://laraveldeveloper.me/public/uploads/products/1470796273.jpg', 'x1x.jpg');
		
			
		if(Session::get('uploaded_secondary_images_array'))
		{
			Session::forget('uploaded_secondary_images_array');
		}
        		
		$data['categories_list'] = \App\Models\Category::where('created_by', Auth::user()->id)->get();
		$data['vendors_list'] = \App\Models\Vendor::where('created_by', Auth::user()->id)->get();
		$data['product_types_list'] = \App\Models\Product_type::where('created_by', Auth::user()->id)->get();
		$data['customer_groups_list'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->get();
		$data['tag_groups'] = \App\Models\Tag_group::where('created_by', Auth::user()->id)->get();
		$data['collection_list'] = \App\Models\Collection::where('created_by', Auth::user()->id)->get();
		$data['folder_list'] = \App\Models\Folder::where('created_by', Auth::user()->id)->get();	 
		$data['description_list'] = \App\Models\Description::where('created_by', Auth::user()->id)->get();
		$data['price_list'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->get();
		$data['products_list'] = DB::table('products')->where([ ['created_by', Auth::user()->id], ['is_deleted', '!=', 1]])->get();	
		return view('product.create', ['data'=>$data]);
	   
	}
	
	public function store(Request $request)
    {
	   
		$this->validate($request, [
            'product_name' => 'required',           
        ]); 
		//dd($request);
		
        $product_model = new Product();      
		
		if($request->hidden_row_id)	
		$product_model = $product_model->find($request->hidden_row_id);
		
        $product_model->product_name = $request->product_name;  
		
		$productFixedUrl = url('/') . '/products/';
		$handle = str_replace($productFixedUrl, '', $request->handle);		
		$temp = $handle;
		$i=0;
		do
		{
			if($request->hidden_row_id) {
				$count = $product_model::where('handle', $temp)->where('product_row_id', '!=',  $request->hidden_row_id)->where('created_by', Auth::user()->id)->count();
			}
			else {
				$count = $product_model::where('handle', $temp)->where('created_by', Auth::user()->id)->count();			
			}
			
			if($count)
			{
				$i++;
				$temp = $handle . '-' . $i;				
			}
		} while($count);

		/*** Code Added By ASIF AHMED
		***  Before updating a product we need to remove that product from OrderDesk. To do so we need to get ***  all products in OrderDesk and find the SKU.
		******/
		$userOrderDeskAccount = \App\Models\AccountOrderdesk::select('store_id', 'api_key')->where('user_id', Auth::user()->id)->first();

		//dd($userOrderDeskAccount);
		if(!empty($userOrderDeskAccount)) {
			$store_id = $userOrderDeskAccount['store_id'];
			$api_key = $userOrderDeskAccount['api_key'];

			$orderdesk = new OrderDeskApiClientClass($store_id, $api_key);
			$args = array(
			  "code" => $request->product_sku,
			);
			$result = $orderdesk->get("inventory-items", $args);
			//echo "<pre>" . print_r($result, 1) . "</pre>"; exit;
			if(!empty($result['inventory_items'])) {
				$invid = $result['inventory_items'][0]['id'];
				if(isset($invid) && ($invid != '')) {
					$deletedata = $orderdesk->delete("inventory-items/".$invid);
				}
			}
		
		}

		/// End of code

		$product_model->handle = $temp;
		$product_model->handle_url = $request->handle_url;		
		$product_model->product_sku = $request->product_sku;  
		$product_model->vendor_sku = $request->vendor_sku;
        $product_model->product_price = $request->product_price ? $request->product_price : NULL;  
		$product_model->product_price_unit = $request->product_price_unit;
		$product_model->upc = $request->upc; 
		$product_model->product_weight = $request->product_weight; 
		$product_model->product_weight_unit = $request->product_weight_unit; 
		$aku_prefix = \App\User::where('id', Auth::user()->id)->first()->aku_prefix;		
		$product_model->aku_code = $request->aku_code ? $aku_prefix . '_' . $request->aku_code : NULL;
		$product_model->description = $request->description;
		$product_model->print_mode = $request->print_mode;
		$product_model->production_art_url_1 = $request->production_art_url_1;
		$product_model->production_art_url_2 = $request->production_art_url_2;
		$product_model->print_location = $request->print_location;
		$product_model->print_location2 = $request->print_location2;
		$product_model->assign_to_folder = $request->assign_to_folder == 'on' ? 1 : 0;			
		$product_model->is_favourite = $request->is_favourite == 'on' ? 1 : 0;
		$product_model->product_dynamic_fields = json_encode($request->dynamic_fields_value);
		$product_model->in_orderdesk = 0;
		
		$collection_row_id = 0;
		if($request->collection_new) {
		    // check does it exist already ?			
		$collection_model = new \App\Models\Collection();
		$collection_model->collection_name = $request->collection_new;  
		$collection_model->created_by = Auth::user()->id;		
		$collection_model->save();
		$collection_row_id = $collection_model->collection_row_id;
		}
		$product_model->collection_row_id = $request->collection_row_id ? $request->collection_row_id : $collection_row_id;	
		
		$folder_row_id = 0;
		if($request->folder_new) {
		  $folder_model = new \App\Models\Folder();
		  $folder_model->folder_name = $request->folder_new;  
		  $folder_model->created_by = Auth::user()->id;		
          $folder_model->save();
		  $folder_row_id = $folder_model->folder_row_id;
		}
		$product_model->folder_row_id = $request->folder_row_id ? $request->folder_row_id : $folder_row_id;	
		
		$vendor_row_id = 0;
		if($request->vendor_new) {
		  $vendor_model = new \App\Models\Vendor();
		  $vendor_model->vendor_name = $request->vendor_new;  
		  $vendor_model->created_by = Auth::user()->id;		
          $vendor_model->save();
		  $vendor_row_id = $vendor_model->vendor_row_id;
		}
		$product_model->vendor_row_id = $request->vendor_row_id ? $request->vendor_row_id : $vendor_row_id;
		
		$category_row_id = 0;
		if($request->category_new) {
		  $category_model = new \App\Models\Category();
		  $category_model->category_name = $request->category_new;  
		  $category_model->created_by = Auth::user()->id;	
          $category_model->save();
		  $category_row_id = $category_model->category_row_id;
		}
        $product_model->category_row_id = $request->category_row_id ? $request->category_row_id : $category_row_id; 

		$product_type_row_id = 0;
		if($request->product_type_new) {
		  $product_type_model = new \App\Models\Product_type();
		  $product_type_model->product_type_name = $request->product_type_new;  
		  $product_type_model->created_by = Auth::user()->id;
          $product_type_model->save();
		  $product_type_row_id = $product_type_model->product_type_row_id;
		}
		$product_model->product_type_row_id = $request->product_type_row_id ? $request->product_type_row_id : $product_type_row_id;
		
		if($request->hidden_primary_image) {
			$product_model->product_image = $request->hidden_primary_image;
		}
		
		if(Session::has('uploaded_image'))
		{
			$product_model->image_external_link = 0;		
			$product_model->product_image = Session::get('uploaded_image');
			Session::forget('uploaded_image');
		}
		
		if($request->hidden_row_id)
		{			
			$existing_Secondary_images = [];
			if($product_model->product_secondary_images) {
				$existing_Secondary_images = json_decode($product_model->product_secondary_images, true);
			}					    
			if(Session::has('removed_secondary_images_array'))
		    {  
			   $newSecondaryImages = array_diff($existing_Secondary_images, Session::get('removed_secondary_images_array'));  
			   $newSecondaryImages = $existing_Secondary_images = array_values($newSecondaryImages);
			   $product_model->product_secondary_images =  json_encode($newSecondaryImages);
			   Session::forget('removed_secondary_images_array');			   
			}			
			if(Session::has('uploaded_secondary_images_array'))
			{
				$newSecondaryImages = array_merge($existing_Secondary_images, Session::get('uploaded_secondary_images_array'));
				$product_model->product_secondary_images = json_encode($newSecondaryImages);
				Session::forget('uploaded_secondary_images_array');
			}
		} 
		else
		{
		   if(Session::has('uploaded_secondary_images_array'))
			{
				$product_model->product_secondary_images = json_encode(Session::get('uploaded_secondary_images_array'));
				Session::forget('uploaded_secondary_images_array');
			}		
		}
		
		if(Session::has('uploaded_design_image'))
		{		
			$product_model->uploaded_design_image = Session::get('uploaded_design_image');
			Session::forget('uploaded_design_image');
		}
		
		
		// Data of another Tab 
		$product_model->product_length = $request->product_length;
		$product_model->product_length_unit = $request->product_length_unit;
		$product_model->product_width = $request->product_width;
		$product_model->product_width_unit = $request->product_width_unit;
		$product_model->product_height = $request->product_height;
		$product_model->product_height_unit = $request->product_height_unit;		
		$product_model->product_cost = $request->product_cost;
		$product_model->product_cost_unit = $request->product_cost_unit;		
		$product_model->product_stock = $request->product_stock;
		$product_model->product_stock_type = $request->product_stock_type;
		$product_model->inventory_serial = $request->inventory_serial;
		$product_model->update_source = $request->update_source;
		$product_model->tag_group_row_id = $request->tag_group_row_id;			
		$product_model->number_of_pieces = $request->number_of_pieces;
		
		
		// Data of another Tab 
		$product_model->ship_cartoon = $request->ship_cartoon;
		$product_model->ship_weight = $request->ship_weight;
		$product_model->ship_weight_unit = $request->ship_weight_unit;
		$product_model->ship_width = $request->ship_width;
		$product_model->ship_width_unit = $request->ship_width_unit;
		$product_model->ship_length = $request->ship_length;
		$product_model->ship_length_unit = $request->ship_length_unit;
		$product_model->ship_height = $request->ship_height;
		$product_model->ship_height_unit = $request->ship_height_unit;
		$product_model->master_cartoon = $request->master_cartoon;				
					
		// meta
		$product_model->product_meta_title = $request->product_meta_title;
		$product_model->product_meta_keyword = $request->product_meta_keyword;
		$product_model->product_meta_description = $request->product_meta_description;	
		
		// attribute 
	    $product_model->attribute_price = json_encode($request->attribute_price);
		$product_model->attribute_sku = json_encode($request->attribute_sku);
		$product_model->attribute_barcode = json_encode($request->attribute_barcode);		
		
		
		$product_model->created_by = Auth::user()->id;
        $product_model->save();		
		$product_row_id = $product_model->product_row_id;
		
		//price level
		$price_types = array();
		if($request->product_level_amount)
		{
			$amount_normal_price = 0;
			foreach($request->product_level_amount as $key=>$arr)
			{
				if($arr[0])
				{  
					$price_types[$key] = $arr[0];	
				   ///$product_model = $product_price_level->find($request->hidden_row_id);						
				   $product_price_level = new \App\Models\Product_price_level;					   
				   $product_price_level->product_row_id = $product_model->product_row_id;
				   $product_price_level->price_group_row_id = $key;		   
				   $product_price_level->price_level_amount = $arr[0];
				   if($request->product_level_amount_normal_price[$amount_normal_price]){
						if( $request->product_level_amount_normal_price[$amount_normal_price] == 1 ) //amount more
						{
							$product_price_level->price_level_amount = $product_model->product_price +  $arr[0];
						}
						else if( $request->product_level_amount_normal_price[$amount_normal_price] == 2 ) //amount less
						{
							$product_price_level->price_level_amount = $product_model->product_price -  $arr[0];
						}
						else if( $request->product_level_amount_normal_price[$amount_normal_price] == 3 ) //amount more in %
						{
							$product_price_level->price_level_amount = $product_model->product_price + ($product_model->product_price * $arr[0] /100);
						}
						else // amount less in  %
						{
							$product_price_level->price_level_amount = $product_model->product_price - ($product_model->product_price * $arr[0] /100);
						}
				    }
				   $product_price_level->save();		  	   
				}
				$amount_normal_price++;	
			}
		}

		$product_model->product_price_types = json_encode($price_types);
		$product_model->save();
		
		for($i=0; $i<count($request->group); $i++)
		{
			if($request->group[$i] && $request->group_options[$i][0])   
			{
			   		
			   $product_attribute = new \App\Models\Product_attribute;			   
				// $product_attribute::where('product_row_id', 1)->delete();			   
			   $product_attribute->product_row_id = $product_model->product_row_id;
			   $product_attribute->attribute_group_name = $request->group[$i];		   
			   $product_attribute->attribute_group_options = $request->group_options[$i][0];				
			   $product_attribute->save();
			} 
		}
		
		//dynamic field		
		//$insert[] = [];
		
		/*foreach($request->dynamic_fields as $key=>$val)	
		{
			if($val && $request->dynamic_fields_value[$key])
			{
				//update
				if(isset($request->dynamic_field_row_id[$key])) {
					//update		
				} 
				else {
					$insert[] = [
					'product_row_id' => $product_row_id,
					'field_name' => $val,
					'field_value' =>$request->dynamic_fields_value[$key],
					'created_by'=>Auth::User()->id,
					'created_at'=>date('Y-m-d H:i:s'),
					];
				}
			}
		}*/		
		
		if( !empty($insert))
		{
			DB::table('product_dynamic_fields')->insert($insert);
		}
        Session::flash('success-message', 'Product has beed added successfully.');        
        return Redirect::to('/manage-product');
        
	}
    
	public function edit($id)
    {
    	$template_row_id = \App\Models\Product::where('product_row_id', $id)->pluck('template_row_id');
		$template_info = \App\Models\ImportTemplate::where('template_row_id', $template_row_id)->first();
		//dd($template_info);
		$data['categories_list'] = \App\Models\Category::where('created_by', Auth::user()->id)->get();
		$data['vendors_list'] = \App\Models\Vendor::where('created_by', Auth::user()->id)->get();
		$data['product_types_list'] = \App\Models\Product_type::where('created_by', Auth::user()->id)->get();
		$data['customer_groups_list'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->get();
		$data['tag_groups'] = \App\Models\Tag_group::where('created_by', Auth::user()->id)->get();
		$data['collection_list'] = \App\Models\Collection::where('created_by', Auth::user()->id)->get();
		$data['folder_list'] = \App\Models\Folder::where('created_by', Auth::user()->id)->get();
		$data['description_list'] = \App\Models\Description::where('created_by', Auth::user()->id)->get();
		$data['price_list'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->get();	  
		$data['single_record'] =  \App\Models\Product::where('product_row_id', $id)->with('attributeName')->first();
		$data['price_types'] = json_decode($data['single_record']->product_price_types, 1);
		//$data['dynamic_fields'] =  DB::table('product_dynamic_fields')->where('product_row_id', $id)->get();
		$data['product_dynamic_fields'] =  \App\Models\Product::where('product_row_id', $id)->pluck('product_dynamic_fields');
		$decode_dynamic_fields = array();
		$decode_dynamic_fields = json_decode($data['product_dynamic_fields'][0]);
		$data['dynamic_fields'] = $decode_dynamic_fields;
		//dd($data['dynamic_fields']);
		//$data['dynamic_fields_config'] = config('site_config.product_dynamic_fields');

		// get current vendor name if vendor_row_id is exist
		if($data['single_record']->vendor_row_id > 0) {
			$data['current_vendorname'] = \App\Models\Vendor::select('vendor_name')->where('vendor_row_id', $data['single_record']->vendor_row_id)->value('vendor_name');
		}

		$csv_field_db_mapping = json_decode($template_info['csv_field_db_mapping']);
		//dd($data['price_types']);

		$all_fields = ['product_name', 'handle', 'product_sku', 'vendor_sku', 'aku_code', 'product_price','product_price_unit', 'upc', 'description', 'product_image', 'uploaded_design_image', 'product_length','product_length_unit', 'product_height', 'product_height_unit', 'product_width', 'product_width_unit', 'product_weight', 'product_weight_unit', 'product_cost', 'product_stock', 'inventory_serial', 'update_source', 'number_of_pieces', 'ship_length','ship_length_unit', 'ship_height', 'ship_height_unit', 'ship_width', 'ship_width_unit', 'ship_weight', 'ship_weight_unit', 'master_cartoon', 'print_mode', 'print_location', 'production_art_url_1', 'production_art_url_2', 'print_location2', 'product_meta_title', 'product_meta_keyword', 'product_meta_description'];

		// prepare dynamic fields array from template db mapping
		$build_dynamic_field_row = array();
		if ($csv_field_db_mapping) {
			foreach ($csv_field_db_mapping as $key => $value) {
				if(!in_array($key, $all_fields) && ($value != '')) {
					$build_dynamic_field_row[$key] = $value;
				}
			}
		}
		//dd($build_dynamic_field_row);
		$data['build_dynamic_field_row'] = $build_dynamic_field_row;
		
		$data['attribute_groups'] = $data['single_record']->attributeName;
		$price_level_amount = array();
		$level_amount =  \App\Models\Product_price_level::where('product_row_id', $id)->get();
		foreach($level_amount  as $row)
		{
			$price_level_amount[$row->price_group_row_id] =  $row->price_level_amount;
		}
		$data['price_level_amount'] =  $price_level_amount;
			
		$data['product_secondary_images'] = array();
		if($data['single_record']->product_secondary_images)
		{
			$data['product_secondary_images'] =  json_decode($data['single_record']->product_secondary_images);		
		}
		// dd($data['single_record']);
		$data['user_id'] = Auth::user()->id;
		return view('product.edit', ['data'=>$data]); 
	}
	public function update(Request $request)
    {
        $product_model = new Product();                                                                  
        $product_model = $product_model->find($request->hidden_row_id);
        $product_model->product_name = $request->product_name;  
        $product_model->product_price = $request->product_price ? $request->product_price : 0;  
        $product_model->product_sku = $request->product_sku;
		$product_model->vendor_sku = $request->vendor_sku;
                
        $product_model->save();
        Session::flash('success-message', 'Product Info has been updated Successfully.');        
        return Redirect::to('/manage-product');
	
	}
    
	
	public function addVariantsGroupOptions(Request $request)
	{
		$product_attribute = new \App\Models\Product_attribute;
		if($request->attribute_group_row_id) {
			$product_attribute = $product_attribute::find($request->attribute_group_row_id);			   
		}
		$product_attribute->attribute_group_name = $request->group;				
	    $product_attribute->attribute_group_options = $request->group_options;				
		$product_attribute->product_row_id = $request->product_row_id;		
		$product_attribute->save();
		Session::flash('success-message', 'Product Info has been updated Successfully.');        
		return Redirect::to('/edit-product/' . $request->product_row_id);
	}
	
    public function deleteRecord($id)
    {
       if( !$id ) { 
        return false;
       }
       
       $product_model = new Product();     	   
       $product_model = $product_model->find($id);                                        
	   $product_model->is_deleted = 1;
	   $product_model->save();
	   
		//DB::table('products')->where('product_row_id', $id)->delete(); 
       Session::flash('success-message', 'Product has been deleted successfully.');        
       return Redirect::to('manage-product');
    }
    
	
	public function uploadProductImage(Request $request)
	{
		$common_model = new Common();       
		$uploadedProductImage = $common_model->uploadImage('file', 'uploads/product_images/' . Auth::user()->id . '/');  
		Session::put('uploaded_image', $uploadedProductImage);	
	}
	public function uploadSecondaryImage(Request $request)
	{	
		$common_model = new Common();
		$uploaded_secondary_image = $common_model->uploadImage('file', 'uploads/product_images/' . Auth::user()->id . '/');
		
		if(!Session::has('uploaded_secondary_images_array')) {				
			Session::set('uploaded_secondary_images_array', [$uploaded_secondary_image]); 
		} else {
		   session()->push('uploaded_secondary_images_array', $uploaded_secondary_image);
		}
		
		/*if( Session::get('uploaded_secondary_images') )
		{
			$uploaded_secondary_images = Session::get('uploaded_secondary_images') . '|' . $uploaded_secondary_images;
		}
		
		Session::put('uploaded_secondary_images', $uploaded_secondary_images);	
		*/
	}
	
	public function uploadDesignImage(Request $request)
	{
		$common_model = new Common();       
		$uploadedProductImage = $common_model->uploadImage('file', 'uploads/product_images/' . Auth::user()->id . '/', Session::get('aku_code'));  
		Session::put('uploaded_design_image', $uploadedProductImage);	
	}
	public function removePrimaryImage()
	{	 
		Session::put('uploaded_image', '');	
	}	
	
	public function removeSecondaryImageWhileCreate($index)
	{
		//dd(Session::get('uploaded_secondary_images_array'));
		$event_data_display = Session::get('uploaded_secondary_images_array');
		unset($event_data_display[$index]);
		$event_data_display = array_values($event_data_display);
		Session::set('uploaded_secondary_images_array', $event_data_display);		
		unset($event_data_display);
	}	
	
	public function removeSecondaryImage($secondary_image_name)
	{	 
		//Session::put('uploaded_design_image', '');
		if(!Session::has('removed_secondary_images_array')) {				
			Session::set('removed_secondary_images_array', [$secondary_image_name]); 
		} else {
		   session()->push('removed_secondary_images_array', $secondary_image_name);
		}
		
	}	
	
	public function removeHireDesignImage()
	{	 
		Session::put('uploaded_design_image', '');	
	}	
	
	
	
	
	
    public function deleteImageOnly($product_row_id, $file_name )
    {
        $product_model = new Product();      
        if(File::exists(public_path().'/uploads/products/' . $file_name)) 
        {
            File::delete(public_path().'/uploads/products/' . $file_name);                        
        }    
        
        if($product_row_id)
        {
            $product_model = $product_model->find($product_row_id);
            $product_model->product_image = '';        
            $product_model->save();
        }        
        
    }
	
	  function generateRandomString($length = 5) {
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
    
		return strtoupper($randomString);
   }
   
	public function generateAkuCode() {
	
	$aku_prefix = \App\User::where('id', Auth::user()->id)->first()->aku_prefix;
		do {
		   $randString = $this->generateRandomString();			
		   $aku_code = $aku_prefix . '_' . $randString; 
		   $count = \App\Models\Product::where('aku_code', $aku_code)->count();
        } while($count);
	  	
		$data['aku_code'] = $randString;
		$data['aku'] = $aku_code;
		
		Session::put('aku_code', $aku_code);	
		return json_encode($data);
	}
	
    public function isValidAkuCode($randString, $product_row_id = 0) {	
		$aku_prefix = \App\User::where('id', Auth::user()->id)->first()->aku_prefix;
		$aku_code = $aku_prefix . '_' . $randString; 
		$exist = \App\Models\Product::where([ ['aku_code', $aku_code], ['product_row_id', '!=', $product_row_id] ])->first();
		if($exist) 
		{
			Session::put('aku_code', '');	  
			echo 'exist';		
		}			
		else
		{
			Session::put('aku_code', $aku_code );	
			return 'not-exist';
		}		
	}
	
	public function generateAku2Code() {
	
	$aku_prefix = \App\User::where('id', Auth::user()->id)->first()->aku_prefix;
		do {
		   $randString = $this->generateRandomString();			
		   $aku2_code = $aku_prefix . '_' . $randString; 
		   $count = \App\Models\Product::where('aku2_code', $aku2_code)->count();
        } while($count);
	  	
		$data['aku2_code'] = $randString;
		
		
		Session::put('aku2_code', $aku2_code);	
		return json_encode($data);
	}
	
    public function isValidAku2Code($randString, $product_row_id = 0) {	
		$aku_prefix = \App\User::where('id', Auth::user()->id)->first()->aku_prefix;
		$aku2_code = $aku_prefix . '_' . $randString; 
		$exist = \App\Models\Product::where([ ['aku2_code', $aku2_code], ['product_row_id', '!=', $product_row_id] ])->first();
		if($exist) 
		{
			Session::put('aku2_code', '');	  
			echo 'exist';		
		}			
		else
		{
			Session::put('aku2_code', $aku_code );	
			return 'not-exist';
		}		
	}
	
	public function senddata($data) {
	

		$data = $_REQUEST['file'];
		dd($data);
		$handle = fopen($data, "r");
		$test = file_get_contents($data);


		$handle = fopen($data, "r");
		$test = file_get_contents($data);
		if ($handle) {

		    $counter = 0;
		    //instead of executing query one by one,
		    //let us prepare 1 SQL query that will insert all values from the batch
		    $sql ="INSERT INTO table_test(name,contact_number) VALUES ";
		    while (($line = fgets($handle)) !== false) {
		      $sql .= "($line),";
		      $counter++;
		    }

		    echo $sql = substr($sql, 0, strlen($sql) - 1);
		     
		    fclose($handle);
		} else {  
		
		} 
		//unlink CSV file once already imported to DB to clear directory
		unlink($data);
	}
	
	public function importExcel(Request $request) {

		$user_id = Auth::user()->id;		
		$tmpName = $_FILES['import_file']['tmp_name'];
		$handle = fopen($tmpName, 'r');
		if(!$handle)
			return false;


		$row = 0;
		$insertAllProducts = [];

		//$data = fgetcsv($handle);
		$template_row_id = $request->template_row_id ? $request->template_row_id : 0;
		$template_info = \App\Models\ImportTemplate::where('template_row_id', $template_row_id)->first();
		$csv_field_db_mapping =  json_decode($template_info->csv_field_db_mapping, true);
		$csv_field_db_mapping_flipped  = array_flip($csv_field_db_mapping);
		//echo '<pre>'.print_r($csv_field_db_mapping, true).'</pre>';
		$csvHeadsFromDB = json_decode($template_info->template_fields);
		$csvHeadsFromDB = array_values(array_filter($csvHeadsFromDB));
		//dd($csv_field_db_mapping);


		//  All fields are needed to decide whether the filed exist in db or not. of does not exist then make dynamic field.
		$data['records'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->orderBy('customer_group_row_id', 'asc')->get()->toArray();
		$pricetypes = array();

		foreach ($data['records'] as $pricedata) {
			$pricetypes[] = 'PT-'.$pricedata['customer_group_row_id'];
		}
		//dd($pricetypes);
        $all_fields = ['product_name', 'handle', 'product_sku', 'vendor_sku', 'aku_code', 'product_price','product_price_unit', 'upc', 'description', 'product_image', 'uploaded_design_image', 'product_length','product_length_unit', 'product_height', 'product_height_unit', 'product_width', 'product_width_unit', 'product_weight', 'product_weight_unit', 'product_cost', 'product_stock', 'inventory_serial', 'update_source', 'number_of_pieces', 'ship_length','ship_length_unit', 'ship_height', 'ship_height_unit', 'ship_width', 'ship_width_unit', 'ship_weight', 'ship_weight_unit', 'master_cartoon', 'vendor_row_id', 'print_mode', 'print_location', 'production_art_url_1', 'production_art_url_2', 'print_location2', 'product_meta_title', 'product_meta_keyword', 'product_meta_description'];
        $all_fields = array_merge($all_fields, $pricetypes);
        
		/*new test*/
	    $processCsv = 0;
	    $iterationCount = 0;

	    // get all products sku from database and make an array for sku data
	    $allProductSku = \App\Models\Product::pluck('product_sku')->toArray();

	    $pricetypes = array();
	    while(($data = fgetcsv($handle)) !== FALSE)
		{		

			if($processCsv == 0) {
				$processCsv++;
				continue;
			}
			// check product sku for same csv import
			$csv_head_name_for_sku = array_search('product_sku', $csv_field_db_mapping);
			$skukey = array_search($csv_head_name_for_sku, $csvHeadsFromDB);
			$proSku = $data[$skukey];
			
			$product_exist = array();
			if(in_array($proSku, $allProductSku)) {
				//echo $proSku.'<br/>';
				$product_exist = \App\Models\Product::where('product_sku', $proSku)->first()->toArray();
				$dynamic_field_data = json_decode($product_exist['product_dynamic_fields'], true);
				//dd($product_exist);
			}
			//dd($product_exist);
			$update_dynamic_field_row = array();
			$build_dynamic_field_row = array();
			$product_update_row = array();
			$product_row = array();

			//automation-rules 
			$product_column_and_rules = [];
			$automation_rules_arr = \App\Models\ImportTemplateAutomationRule::where('template_row_id', $template_row_id)->get();
			if( count($automation_rules_arr) ) {
				foreach ($automation_rules_arr as $rule_info) {		
					$product_column_and_rules[$rule_info->product_column_name] = $rule_info->rules;
				}
			}//end automation-rules 

			foreach($data as $key=>$csvVal) {
				$csvHeadName = trim($csvHeadsFromDB[$key]);
				if(!empty($product_exist) && !$csvVal) { continue; }				
				if(isset($csv_field_db_mapping[$csvHeadName]) && ($csv_field_db_mapping[$csvHeadName])) {
					//echo $csv_field_db_mapping[$csvHeadName]; 
					if((!in_array($csv_field_db_mapping[$csvHeadName], $all_fields)) || !$csv_field_db_mapping[$csvHeadName]) {
						if(!empty($product_exist)) {
							if(array_key_exists($csvHeadName, $dynamic_field_data) && ($csvVal != $dynamic_field_data[$csvHeadName])) { 
								$update_dynamic_field_row[$csvHeadName]= isset($csvVal) ? preg_replace("/[^+'(){}*&.,;:\/a-zA-Z0-9\w _-]|[,;]$/s", '', $csvVal) : '';
							}
						} else {
							$build_dynamic_field_row[$csvHeadName]= isset($csvVal) ? preg_replace("/[^+'(){}*&.,;:\/a-zA-Z0-9\w _-]|[,;]$/s", '', $csvVal) : '';
						}
					} else {
						if(!empty($product_exist) && (in_array($csv_field_db_mapping[$csvHeadName], $all_fields))) {
							//echo $csvVal.'  '.$csv_field_db_mapping[$csvHeadName].'<br>'; //exit;
							//($csvVal != $product_exist[$csv_field_db_mapping[$csvHeadName]]);
							if (strpos($csv_field_db_mapping[$csvHeadName], 'PT-') !== false) {
							    $pricetypeid = explode('-', $csv_field_db_mapping[$csvHeadName]);
								$pricetypes[$pricetypeid[1]] = $csvVal;
							} else {
								$product_update_row[$csv_field_db_mapping[$csvHeadName]] = (isset($csvVal) && $csvVal) ? preg_replace("/[^+'(){}*&.,;:\/a-zA-Z0-9\w _-]|[,;]$/s", '', $csvVal) : null;

								//automation-rules
								if(count($product_column_and_rules)) {
									foreach($product_column_and_rules as $key=>$val) {
									$rulesArr = json_decode($val);									
									$final_val = '';
									if(count($rulesArr))
									{
										foreach($rulesArr as $key2 => $val2) {
											if( $key2%2 == 1 )
											$final_val .= $val2;
											else {
											// $VAL2 HOLDS CSV hEAD Name SUPPOSE COLORS, WE Need to get key of it in CSV LIKE 0,2.
												$final_val .= $data[ array_search($val2, $csvHeadsFromDB) ];
											}
										}
									}
									$product_update_row[$key] = $final_val;
									}			
								} //endof automation-rules
							}
						} else {
							$pos = strpos($csv_field_db_mapping[$csvHeadName], 'PT-');
							if ($pos !== false) {

								$pricetypeid = explode('-', $csv_field_db_mapping[$csvHeadName]);
								$pricetypes[$pricetypeid[1]] = $csvVal;

							} else {
								$product_row[$csv_field_db_mapping[$csvHeadName]] = (isset($csvVal) && $csvVal) ? preg_replace("/[^+'(){}*&.,;:\/a-zA-Z0-9\w _-]|[,;]$/s", '', $csvVal) : null;
								
								//automation-rules 
								if(count($product_column_and_rules)) {
									foreach($product_column_and_rules as $key=>$val) {			
									$rulesArr = json_decode($val);									
									$final_val = '';
									if(count($rulesArr))
									{
										foreach($rulesArr as $key2 => $val2) {
											//if( strlen($val2)<2 )
											if( $key2%2 == 1 )
											$final_val .= $val2;
											else {
											// $VAL2 HOLDS CSV hEAD Name SUPPOSE COLORS, WE Need to get key of it in CSV LIKE 0,2.
												$final_val .= $data[ array_search($val2, $csvHeadsFromDB) ];
											}
										}
								    }
									$product_row[$key] = $final_val;
									}			
								} //end automation-rules

							}	
						}
					}
				}
			} // END OF FETCHINg on ROW OF CSV.

			

			if(!empty($product_exist)) {
				//print_r($product_update_row);
				if(!empty($update_dynamic_field_row)) {
					$product_update_row['product_dynamic_fields'] = !empty($update_dynamic_field_row) ? json_encode($update_dynamic_field_row) : '';
				}
				if(!empty($product_update_row)) {
					$product_update_row['product_price_types'] = json_encode($pricetypes);
					$updateAllProducts[$product_exist['product_row_id']] = isset($product_update_row) ? $product_update_row : '';
				} else {
					continue;
				}
			} 

			if(!empty($product_row) || !empty($build_dynamic_field_row)) {
				//print_r($product_row);
				$product_row['created_by'] = $user_id;
				$product_row['template_row_id'] = $template_row_id;
				$product_row['product_dynamic_fields'] = !empty($build_dynamic_field_row) ? json_encode($build_dynamic_field_row) : '';
				$product_row['product_price_types'] = json_encode($pricetypes);
				$insertAllProducts[] = isset($product_row) ? $product_row : '';
			}
			//echo '<pre>'.print_r($product_row, true).'</pre>'; exit;

        } // end OF single row fetchinG.

        //echo '<pre>'.print_r($updateAllProducts, true).'</pre>';
        //echo '<pre>'.print_r($insertAllProducts, true).'</pre>'; exit;
        //dd($insertAllProducts);
        //exit;

        // If new data is available then insert data chunk by chunk
        if(!empty($insertAllProducts)) {
	        $collection = collect($insertAllProducts);
			$chunks = $collection->chunk(2000);

			foreach ($chunks as $key => $data) {
				$mydata = array();
	        	$mydata = $data->toArray();
	        	//echo '<pre>'.print_r($mydata, true).'</pre>'; exit;
	        	DB::connection()->disableQueryLog();
		    	DB::table('products')->insert($mydata);
		    	$mydata = null;
	        }
    	}

    	if(!empty($updateAllProducts)) {
    		foreach($updateAllProducts as $pid => $coldata) {
    			//echo '<pre>'.print_r($pid, true).'</pre>';
    			$updateData = array();
    			foreach ($coldata as $key => $value) {
    				if($key == 'product_dynamic_fields') {
    					$mergearray = array();
    					$pdfield = \App\Models\Product::select('product_dynamic_fields')->where('product_row_id', $pid)->first()->toArray();
    					$a = json_decode($value, true);
						$b = json_decode($pdfield['product_dynamic_fields'],true); 
    					$mergearray = json_encode((array_merge($b, $a)));
    					$updateData['product_dynamic_fields'] = $mergearray;
    				} else {
    					$updateData[$key] = $value;
    				}
    			}
    			// run update code
    			\App\Models\Product::where('product_row_id',  $pid)->update($updateData);
    		}
    	}
    	//exit;

		Session::flash('success-message', 'Products has been imported Successfully.');
		return Redirect::to('/manage-product');
		
	}

	public function setAutomationRules($data) {
		//AUTOMATION RULES	apply TO EACH ROW OF CSV		
		$product_column_and_rules = [];
		$automation_rules_arr = \App\Models\ImportTemplateAutomationRule::where('template_row_id', $template_row_id)->get();
		if( count($automation_rules_arr) ) {
			foreach ($automation_rules_arr as $rule_info) {		
				$product_column_and_rules[$rule_info->product_column_name] = $rule_info->rules;
			}
		}
		if(count($product_column_and_rules)) {
			foreach($product_column_and_rules as $key=>$val) {			
				$rulesArr = json_decode($val);
				//DD($rulesArr );
				$final_val = '';
				foreach($rulesArr as $key2 => $val2) {
					if( strlen($val2)<2 )
						$final_val .= $val2;
					else {
						// $VAL2 HOLDS CSV hEAD Name SUPPOSE COLORS, WE Need to get key of it in CSV LIKE 0,2.
						$final_val .= $data[ array_search($val2, $csvHeadsFromDB) ];
					}
				}
				$product_row[$key] = $final_val;
			}			
		}			
		// end of automation rules
	} 
	
	public function reports()
	{
	
	}
	
	public function setDescriptionField($description_row_id) {
	  $description_info =  DB::table('descriptions')->where('description_row_id', $description_row_id)->first();
	  if($description_info) {
		echo $description_info->description_text;
	  } else {
		echo 'no';
	  }
	  
	}
	
	
	public function csvImport() {
		$id = Auth::user()->id;
		$data['import_templates'] = DB::table('import_templates')->where('created_by', $id)->get(); 
	    return view('product.import_csv', ['data'=>$data]);
	}
	
	public function bulkEdit(Request $request)
    { 
	 if(count($request->product_row_ids) < 1 )
	 {
		Session::flash('error-message', 'Select at least one product to Bulk Edit.');        
		return Redirect::to('/manage-product');
	 }
	 
	  $data['products_list'] = DB::table('products')->where([ ['created_by', Auth::user()->id], ['is_deleted', '!=', 1]])->whereIn('product_row_id',$request->product_row_ids)->get();	 				 
      $common_model = new Common();                         
      $data['categories_list'] = $common_model->allCategories();
	  $data['user_id'] = Auth::user()->id;
	  return view('product.product_bulk_edit', ['data'=>$data]);
        //   
    }
	
	public function bulkUpdate(Request $request)
    {     
		
		 $product_row_ids = $request->product_row_id;
		 
		 for ($i=0; $i<count($product_row_ids); $i++)
		 {
		     $product_row_id = $product_row_ids[$i];
			 $product_price = $request->product_price[$i] ? $request->product_price[$i] : 0;
			 $product_sku = $request->product_sku[$i];
			 DB::table('products')
            ->where('product_row_id', $product_row_id)
            ->update( ['product_price' => $product_price, 'product_sku' => $product_sku]);
		 }
		 
		 
		  Session::flash('success-message', 'Products has been updated Successfully.');        
		  return Redirect::to('/manage-product');	
    }
	
	public function getAllProducts()
    {
	 
		$data['products_list'] = DB::table('products')->where([ ['created_by', Auth::user()->id], ['is_deleted', '!=', 1]])->get();	
		foreach($data['products_list']  as $product)
		{			
			echo '<a href="' .  url('/') . '/add-product/' . $product->product_row_id . ' ">' . $product->product_name . '<a>';
			echo '<br>';
		}		
    }
	
	public function copyProduct($id)
    {
		
		$data['categories_list'] = \App\Models\Category::where('created_by', Auth::user()->id)->get();
		$data['vendors_list'] = \App\Models\Vendor::where('created_by', Auth::user()->id)->get();
		$data['product_types_list'] = \App\Models\Product_type::where('created_by', Auth::user()->id)->get();
		$data['customer_groups_list'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->get();
		$data['tag_groups'] = \App\Models\Tag_group::where('created_by', Auth::user()->id)->get();
		$data['collection_list'] = \App\Models\Collection::where('created_by', Auth::user()->id)->get();
		$data['folder_list'] = \App\Models\Folder::where('created_by', Auth::user()->id)->get();
		$data['description_list'] = \App\Models\Description::where('created_by', Auth::user()->id)->get();
		$data['price_list'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->get();	  
		$data['single_record'] =  \App\Models\Product::where('product_row_id', $id)->with('attributeName')->first();
		
		$data['attribute_groups'] = $data['single_record']->attributeName;
		$price_level_amount = array();
		$level_amount =  \App\Models\Product_price_level::where('product_row_id', $id)->get();
		foreach($level_amount  as $row)
		{
			$price_level_amount[$row->price_group_row_id] =  $row->price_level_amount;
		}
		$data['price_level_amount'] =  $price_level_amount;
			
		$data['product_secondary_images'] = array();
		if($data['single_record']->product_secondary_images)
		{
			$data['product_secondary_images'] =  json_decode($data['single_record']->product_secondary_images);		
		}
		// dd($data['single_record']);
		$data['products_list'] = DB::table('products')->where([ ['created_by', Auth::user()->id], ['is_deleted', '!=', 1]])->get();
		$data['user_id'] = Auth::user()->id;
		return view('product.copy', ['data'=>$data]); 
	}
	
	
	public function delete_dynamic_field($id) {	
		DB::table('product_dynamic_fields')->where('dynamic_field_row_id', $id)->delete();
	}
	
	public function csvExport(Request $request) {
	
		if($request->isMethod('post')) 
		{
		
			$template_csv_file = 'products';
			if($request->template_row_id)
			{
				$template_row_id = $request->template_row_id;
				$template_info = \App\Models\Template::where('template_row_id', $template_row_id)->first();
				
				
				if($template_info->file_name)
				{
					$file_info = explode(".", $template_info->file_name);
					$template_csv_file = $file_info[0];
				}
				
				 $template_fields = json_decode($template_info->template_fields);
				 //echo $template_fields_comma = implode(',', $template_fields);
				
				$sql= "SELECT * FROM products WHERE  created_by = " . Auth::user()->id ;
				$data['products_list'] = DB::select($sql);
				$results = $data['products_list'];				
				
				$data = array();
				for ($i=0; $i<count($results); $i++) 
				{
					for($j = 0; $j<count($template_fields); $j++)
					{
						$field_name = $template_fields[$j];
						$a[$field_name] = $results[$i]->$field_name;
						
					}
					
					$data[] = (array)$a; 
				}
			}
			
			else
			{
			
			
				$sql= "SELECT product_row_id, product_name As ProductName,handle, product_sku As Sku, product_price As Price, product_image as Image, uploaded_design_image, image_external_link,
					   product_meta_title, product_meta_keyword, product_meta_description,product_length,product_width,product_height,product_weight	FROM products WHERE  created_by = " . Auth::user()->id ;
				$data['products_list'] = DB::select($sql);
				$results = $data['products_list'];				
				$data = array();
				for ($i=0; $i<count($results); $i++) 
				{
					$a['Product Name'] = $results[$i]->ProductName;
					$a['handle'] = $results[$i]->handle;
					$a['Sku'] = $results[$i]->Sku;
					$a['Price'] = $results[$i]->Price;
					
					$a['Primary Image'] = $results[$i]->Image;
					
					$a['Length'] = $results[$i]->product_length;
					$a['Width'] = $results[$i]->product_width;
					$a['Height'] = $results[$i]->product_height;
					$a['Weight'] = $results[$i]->product_weight;
					$a['Meta Title'] = $results[$i]->product_meta_title;
					$a['Meta Keyword'] = $results[$i]->product_meta_keyword;
					$a['Meta Description'] = $results[$i]->product_meta_description;
					$data[] = (array)$a; 
				}
			
			}	
			
			$data['products_list'] = $data;
			$this->exportProductToCsv($data['products_list'], $template_csv_file);
			
			exit;
		}
		
	  $data['products_list'] = DB::table('products')->where([ ['created_by', Auth::user()->id], ['is_deleted', '!=', 1]])->get();		 				 
	  $common_model = new Common();                         
      $data['categories_list'] = $common_model->allCategories();
	  $data['user_id'] = Auth::user()->id;
	 // return view('product.product_home', ['data'=>$data]);
 
		$data['export_templates'] = DB::table('templates')->get(); 
	    return view('product.export_csv', ['data'=>$data]);	
	}
	
	
	public function exportProductToCsv($data, $template_csv_file) {		
		
		Excel::create($template_csv_file, function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->download('csv');
		
		exit;

	}

	public function bulkDelete(Request $request) {

		if(!$request->products)
		{
			echo 'no';

		} else {			
			if($request->products && count($request->products)) {
        		Product::where('created_by', Auth::user()->id)->whereIn('product_row_id', explode(',', $request->products))->delete();
        		echo 'yes';
        	}
		}
    }


    public function searchProduct($request) {        
        $products = Product::where('created_by', Auth::user()->id);

        if($request->collection_match !== "listall") {   
        $request->match = $request->collection_match;        
        if($request->condition) {           
                foreach ($request->condition as $i => $condition) {
                    if (in_array($request->condition_type[$i], array("product_name", "product_sku", "product_price", "vendor_name", "vendor_sku", "collection_name", "folder_name", "aku",  "category_name", "product_type_name", "dynamic_fields", "print_mode", "production_art_url_1", "production_art_url_2", "total_amount", "quantity", "order_id", "customer_info" ) ) ) {

                        $condition = $request->condition[$i];

                        if($request->condition_type[$i] == "vendor_name") {
                           $value = $this->getVendors($request->condition_type[$i], $request->condition[$i], $request->condition_value[$i]);
                           $col = 'vendor_row_id'; 
                           $condition = 'array_in';
                        }

                        if($request->condition_type[$i] == "folder_name") {
                           $value = $this->getFolders($request->condition_type[$i], $request->condition[$i], $request->condition_value[$i]);
                           $col = 'folder_row_id'; 
                           $condition = 'array_in';
                        }

                        if($request->condition_type[$i] == "collection_name") {
                           $value = $this->getCollections($request->condition_type[$i], $request->condition[$i], $request->condition_value[$i]);
                           $col = 'collection_row_id'; 
                           $condition = 'array_in';
                        }
                        if($request->condition_type[$i] == "category_name") {
                           $value = $this->getCategories($request->condition_type[$i], $request->condition[$i], $request->condition_value[$i]);
                           $col = 'category_row_id'; 
                           $condition = 'array_in';
                        }
                        if($request->condition_type[$i] == "product_type_name") {
                           $value = $this->getProductTypes($request->condition_type[$i], $request->condition[$i], $request->condition_value[$i]);
                           $col = 'product_type_row_id'; 
                           $condition = 'array_in';
                        }                        
                        if($request->condition_type[$i] == "dynamic_fields") { 
                            $value = $this->fromDynamicFields($request->dynamic_field_name, $request->condition[$i], $request->condition_value[$i]);                            
                            $col = 'product_row_id'; 
                            $condition = 'array_in';
                        }
                        if($request->condition_type[$i] == "customer_info" || $request->condition_type[$i] == "order_id" || $request->condition_type[$i] == "total_amount" || $request->condition_type[$i] == "quantity") {                      
                            $value = $this->fromSalesCustomer($request->condition_type[$i], $request->condition[$i], $request->condition_value[$i]);
                            $col = 'product_row_id'; 
                            $condition = 'array_in';
                        }

                        switch ($condition) {
                            case "equals":                            
                                if ($request->match == "all" || $i == 0) {
                                    $products = $products->where($request->condition_type[$i], $request->condition_value[$i]);
                                } elseif ($request->match == "any") {
                                    $products = $products->orWhere($request->condition_type[$i], $request->condition_value[$i]);
                                }
                                break;
                            case "not_equals":
                                if ($request->match == "all" || $i == 0) {
                                    $products = $products->where($request->condition_type[$i], "<>", $request->condition_value[$i]);
                                } elseif ($request->match == "any") {
                                    $products = $products->orWhere($request->condition_type[$i], "<>", $request->condition_value[$i]);
                                }
                                break;
                            case "greater_than":
                                if ($request->match == "all" || $i == 0) {
                                    $products = $products->where($request->condition_type[$i], ">", $request->condition_value[$i]);
                                } elseif ($request->match == "any") {
                                    $products = $products->orWhere($request->condition_type[$i], ">", $request->condition_value[$i]);
                                }
                                break;
                            case "less_than":
                                if ($request->match == "all" || $i == 0) {
                                    $products = $products->where($request->condition_type[$i], "<", $request->condition_value[$i]);
                                } elseif ($request->match == "any") {
                                    $products = $products->orWhere($request->condition_type[$i], "<", $request->condition_value[$i]);
                                }
                                break;
                            case "starts_with":
                                if ($request->match == "all" || $i == 0) {
                                    $products = $products->where($request->condition_type[$i], "like", $request->condition_value[$i] . "%");
                                } elseif ($request->match == "any") {
                                    $products = $products->orWhere($request->condition_type[$i], "like", $request->condition_value[$i] . "%");
                                }
                                break;
                            case "ends_with":
                                if ($request->match == "all" || $i == 0) {
                                    $products = $products->where($request->condition_type[$i], "like", "%" . $request->condition_value[$i]);
                                } elseif ($request->match == "any") {
                                    $products = $products->orWhere($request->condition_type[$i], "like", "%" . $request->condition_value[$i]);
                                }
                                break;
                            case "contains":
                                if ($request->match == "all" || $i == 0) {
                                    $products = $products->where($request->condition_type[$i], "like", "%" . $request->condition_value[$i] . "%");
                                } elseif ($request->match == "any") {
                                    $products = $products->orWhere($request->condition_type[$i], "like", "%" . $request->condition_value[$i] . "%");
                                }
                                break;
                            case "not_contains":
                                if ($request->match == "all" || $i == 0) {
                                    $products = $products->where($request->condition_type[$i], "not like", "%" . $request->condition_value[$i] . "%");
                                } elseif ($request->match == "any") {
                                    $products = $products->orWhere($request->condition_type[$i], "not like", "%" . $request->condition_value[$i] . "%");
                                }
                                break;

                            case "array_in":                             
                            if($request->match == "all" || $i == 0) {
                                $products = $products->whereIn($col, $value);
                            } elseif($request->match == "any") {                                
                                $products = $products->orWhereIn($col, $value);
                            }
                            break; 
                        }
                    }
                }
            }
        }

     

        return $products;
    }



    public function createThumbByProductId() {		
		
		
		$user_id = Auth::user()->id;
		$product_list = \App\Models\Product::whereIn('product_row_id', [408,410,411])->get();
		
		if(!$product_list)
			return true;

		foreach($product_list as $row) {
			if($row->product_image) {

				//check whether this thumb already exist in DB with thumb already created. if exist then no need to create thumb again.
				/* No need to check.  
				if ( \App\Models\Product::where([ ['product_image', $row->product_image], ['created_by', $user_id], ['image_external_link', 0] ])->count() > 0 ) {
				\App\Models\Product::where('product_row_id', $row->product_row_id)->update(['image_external_link'=>0]);	
					continue;
				}*/

				// check whether image really exist or not
				$ch = curl_init('http://sales.onebellacasa.com/' . str_replace(' ', '%20', $row->product_image));    
				curl_setopt($ch, CURLOPT_NOBODY, true);
				curl_exec($ch);
				$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

				if($code == 200) {
				$status = true;
				} else {				
					     //image does not exist.
					\App\Models\Product::where('product_row_id', $row->product_row_id)->update(['image_external_link'=>0, 'product_image'=>'']);	
				  	curl_close($ch);				  
				  	continue;
				}
				curl_close($ch);
				
				// if image exist then create thumb.
				$createdImageInfo = $this->Thumbnail('http://sales.onebellacasa.com/' . str_replace(' ', '%20', $row->product_image), $row->product_image, 150, true, $row->created_by);

				if($createdImageInfo) {
					// if thumb created then update table
					\App\Models\Product::where('product_row_id', $row->product_row_id)->update(['image_external_link'=>0]);	
				} else {
					// thumbs is not created successfully.
					DB::table('no_thumbs')->insert(['product_row_id'=>$row->product_row_id, 'created_at'=>date('Y-m-d H:i:s')]);
				}

				} else {

					\App\Models\Product::where('product_row_id', $row->product_row_id)->update(['image_external_link'=>0]);	
				}
		}
	} 

	public function productListToCreateThumb($page) {
		$start = 0;
		if($page) {
		   $start = ($page - 1)*50;
		}
		$user_id = Auth::user()->id;
		
		$product_list = \App\Models\Product::where([ ['created_by', Auth::user()->id] ])->skip($start)->take(50)->get();


		if(!$product_list)
			return true;

		foreach($product_list as $row) {
			if($row->product_image) {

				//check whether this thumb already exist in DB with thumb already created. if exist then no need to create thumb again.
				if ( \App\Models\Product::where([ ['product_image', $row->product_image], ['created_by', $row->created_by], ['image_external_link', 0] ])->count() > 0 ) {
				\App\Models\Product::where('product_row_id', $row->product_row_id)->update(['image_external_link'=>0]);	
					continue;
				}

				// check whether image really exist or not
				$ch = curl_init('http://sales.onebellacasa.com/' . str_replace(' ', '%20', $row->product_image));    
				curl_setopt($ch, CURLOPT_NOBODY, true);
				curl_exec($ch);
				$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

				if($code == 200) {
				$status = true;
				} else { 
					//image does not exist
					\App\Models\Product::where('product_row_id', $row->product_row_id)->update(['image_external_link'=>0, 'product_image'=>'']);
				  	curl_close($ch);				  
				  	continue;
				}
				curl_close($ch);
			
				// create thumb as image exist.
				$createdImageInfo = $this->Thumbnail('http://sales.onebellacasa.com/' . str_replace(' ', '%20', $row->product_image), $row->product_image, 150, true, $row->created_by);

				if($createdImageInfo) {	
					// if thumb created then update table
					\App\Models\Product::where('product_row_id', $row->product_row_id)->update(['image_external_link'=>0]);	
				} else {
					// thumbs is not created successfully.
					DB::table('no_thumbs')->insert(['product_row_id'=>$row->product_row_id, 'created_at'=>date('Y-m-d H:i:s')]);
				}

				} else {
					\App\Models\Product::where('product_row_id', $row->product_row_id)->update(['image_external_link'=>0]);	
				}
		}
	} 

	public function cronCreateThumbBack() {

		DB::table('cron_records')->insert(['created_at'=>date('Y-m-d H:i:s')]);
		$product_list = \App\Models\Product::where('image_external_link', 1)->take(50)->get();

		
		if(! count($product_list)) {			
			if(DB::table('cron_completed')->first()->status == 0)
			{	
				DB::table('cron_completed')->update(['status' => 1, 'created_at'=>date('Y-m-d H:i:s')]);
				$to = 'gene@onebellacasa.com';
				//$to = 'enggmasud@gmail.com';
				$subject = "Import Thumbnail Images Complete";
				$message = "
				<html>
				<head>
				<title>Import Thumbnail Images Complete</title>
				</head>
				<body>
				<p>Import Thumbnail Images Complete.</p>
				</body>
				</html>";

				// Always set content-type when sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

				// More headers
				$headers .= 'From: <info@merchwareapp.com>' . "\r\n";
				$headers .= 'Cc: enggmasud1983@gmail.com' . "\r\n";
				mail($to,$subject,$message,$headers);
				
			}

			return true;
		} 
			

		foreach($product_list as $row) {
			if($row->product_image) {
				
				//check whether this thumb already exist in DB with thumb already created. if exist then no need to create thumb again.
				
				if ( \App\Models\Product::where([ ['product_image', $row->product_image], ['created_by', $row->created_by], ['image_external_link', 0] ])->count() > 0 ) {
				\App\Models\Product::where('product_row_id', $row->product_row_id)->update(['image_external_link'=>0]);	
					continue;
				}

				// check whether image really exist or not
				$ch = curl_init('http://sales.onebellacasa.com/' . str_replace(' ', '%20', $row->product_image));    
				curl_setopt($ch, CURLOPT_NOBODY, true);
				curl_exec($ch);
				$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

				if($code == 200){
				$status = true;
				}else{
					// imgae does not exist
				  \App\Models\Product::where('product_row_id', $row->product_row_id)->update(['image_external_link'=>0, 'product_image'=>'']);
				  curl_close($ch);				  
				  continue;
				}
				curl_close($ch);
			
				// as image exist so create thumb.
				$createdImageInfo =  $this->Thumbnail('http://sales.onebellacasa.com/' . str_replace(' ', '%20', $row->product_image), $row->product_image, 150, true, $row->created_by, $row->product_row_id);

				// if created then update table column.
				if($createdImageInfo) {
					// if thumb created then update table
					\App\Models\Product::where('product_row_id', $row->product_row_id)->update(['image_external_link'=>0]);	
				} else {
					// thumbs is not created successfully.
					DB::table('no_thumbs')->insert(['product_row_id'=>$row->product_row_id, 'created_at'=>date('Y-m-d H:i:s')]);
				}


				} else {					
					\App\Models\Product::where('product_row_id', $row->product_row_id)->update(['image_external_link'=>0]);	
				}
		}			
	
	} 
	
	public function cronCreateThumb() {		
		DB::table('cron_records')->insert(['created_at'=>date('Y-m-d H:i:s')]);
		$product_list = \App\Models\Product::where('image_external_link', 1)->take(50)->get();


		if(! count($product_list)) {
			return true;

			if(DB::table('cron_completed')->first()->status == 0)
			{	
				DB::table('cron_completed')->update(['status' => 1, 'created_at'=>date('Y-m-d H:i:s')]);
				$to = 'gene@onebellacasa.com';
				//$to = 'enggmasud@gmail.com';
				$subject = "Import Thumbnail Images Complete";
				$message = "
				<html>
				<head>
				<title>Import Thumbnail Images Complete</title>
				</head>
				<body>
				<p>Import Thumbnail Images Complete.</p>
				</body>
				</html>";

				// Always set content-type when sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

				// More headers
				$headers .= 'From: <info@merchwareapp.com>' . "\r\n";
				$headers .= 'Cc: enggmasud1983@gmail.com' . "\r\n";
				mail($to,$subject,$message,$headers);
				
			}

			return true;
		}

		require_once base_path('vendor/stefangabos/zebra_curl/Zebra_cURL.php');
		foreach($product_list as $row) {
			if($row->product_image) 
			{	

			/*  image name field contains http://sales.onebeall.com/image_name.png , so get image_name.png, as we will update products table by the image name only.*/
			$imageNameWithoutDomain = '';
			$productImageInfo  = explode('/', trim($row->product_image, '/'));
			if(count($productImageInfo)) {
			  $imageNameWithoutDomain =	$productImageInfo[count($productImageInfo)-1];	
			}

			// check whether is it sales.onebella.com or image_name.png
			$image_extension_arr = explode('.', $imageNameWithoutDomain);
			$image_extension = isset($image_extension_arr[1]) ? $image_extension_arr[1] : 'jpg';
			$image_correct_extensions = ['png', 'PNG', 'jpg', 'jpeg', 'JPG', 'JPEG', 'gif', 'GIF'];
			if( !in_array($image_extension, $image_correct_extensions)) {
				$imageNameWithoutDomain = ''; // in csv image name is like http://sales.onebella.com it means no image really.
			}

							
			//check whether this thumb already exist in DB with thumb already created. if exist then no need to create thumb again.
			if ( \App\Models\Product::where([ ['product_image', $imageNameWithoutDomain], ['created_by', $row->created_by], ['image_external_link', 0] ])->count() > 0 ) {
			   \App\Models\Product::where('product_row_id', $row->product_row_id)->update(['image_external_link'=>0, 'product_image'=>$imageNameWithoutDomain]);	
				continue;
			}

			// Update Products table so that if it arise error to process image below then, next attempt can does not need to face this product.  so make external_link to zero.
			\App\Models\Product::where('product_row_id', $row->product_row_id)->update(['image_external_link'=>0, 'product_image'=>$imageNameWithoutDomain]);


				// for the first image that is sales.onebella.com, it is used, othe that this it is not necessary.
			if(!$imageNameWithoutDomain) 
				continue;
			echo $row->product_image; exit;
			//if(strpos($row->product_image, "http://") !== false) {
				$source_image_with_path = str_replace(' ', '%20', $row->product_image);
			//} else {
				//$source_image_with_path = 'http://sales.onebellacasa.com/' . str_replace(' ', '%20', $row->product_image);
			//}

			// Download full  image to original_images location.
			$obZebra_cURL->download( $source_image_with_path , public_path(). '/uploads/product_images/' . $row->created_by . '/original_images');
			// Create thumb
			$withoutHttplink = str_replace('http://sales.onebellacasa.com/', '', $row->product_image);  
			$mainImagePath = public_path(). '/uploads/product_images/' . $row->created_by . '/original_images/'.$withoutHttplink;
			//exit;
			//$createdImageInfo =  $this->Thumbnail( public_path(). '/uploads/product_images/' . $row->created_by . '/original_images/' . $imageNameWithoutDomain, $imageNameWithoutDomain, 150, true, $row->created_by, $row->product_row_id);
			//$imagePath = public_path().'/uploads/product_images/'.$row->created_by.'/original_images/'.$row->product_image;
	    	$destinationPath = public_path().'/uploads/product_images/'.$row->created_by.'/';
	        $thumb_img = Image::make($source_image_with_path)->resize(150, 150);
	        $thumb_img->save($destinationPath.'/'.$withoutHttplink,80);

				// if created then update table column.
				/*if($createdImageInfo) {
					// if thumb created then update table
					\App\Models\Product::where('product_row_id', $row->product_row_id)->update(['image_external_link'=>0]);	
				} else {
					// thumbs is not created successfully.
					DB::table('no_thumbs')->insert(['product_row_id'=>$row->product_row_id, 'created_at'=>date('Y-m-d H:i:s')]);
				}
				*/

			

			} else { // product does not have image, so updat this field only.		
			   
				\App\Models\Product::where('product_row_id', $row->product_row_id)->update(['image_external_link'=>0]);	
			}
		}
	} 

	protected function Thumbnail($url, $filename, $width = 150, $height = true, $user_id=0, $product_row_id = 0) {	
	
	
	 // download and create gd image
	 $image = @ImageCreateFromString(file_get_contents(htmlentities($url)));
	 DB::table('cron_records')->insert(['comment'=>$url]);

	 if(!$image) {
	 	return false;
	 }

	 if(get_resource_type($image) != 'gd')
	 	return false;
	

	 // calculate resized ratio
	 // Note: if $height is set to TRUE then we automatically calculate the height based on the ratio
	 $height = $height === true ? (ImageSY($image) * $width / ImageSX($image)) : $height;

	 // create image 
	 $output = ImageCreateTrueColor($width, $height);
	 ImageCopyResampled($output, $image, 0, 0, 0, 0, $width, $height, ImageSX($image), ImageSY($image));
	 // save image
	 ImageJPEG($output, "public/uploads/product_images/" . $user_id . "/" . $filename, 95);
	 // return resized image
	 
	 return $output; // if you need to use it
	}
	public function get_dynamic_fields() {
		$dynamic_fields = DB::table('product_dynamic_fields')                                       
        ->select('field_name')
        ->distinct()
        ->where('created_by',  Auth::user()->id)
        ->orderBy('dynamic_field_row_id')
        ->get();

    	$html  = '';
        $html .= '<select class="form-control" name="dynamic_field_name[]" id="dynamic_field_name" autocomplete="off">
	                <option value="">Select</option>';
	                foreach($dynamic_fields as $fields) {
	    $html .=  '<option value="'.$fields->field_name.'">'.$fields->field_name.'</option>';
	                }
        $html .= '</select>';
        echo $html;
	}

	public function get_default_fields() {
		ob_start();
	?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="col-md-3">
                <select class="form-control" name="condition_type[]" autocomplete="off" conditionvalue="1">
                    <option value="product_name">Product Name</option>
                    <option value="product_sku">SKU</option>
                    <option value="product_price">Price</option>
                    <option value="vendor_name">Vendor</option>
                    <option value="vendor_sku">Vendor SKU</option>
                    <option value="collection_name">Collection</option>
                    <option value="folder_name">Folder</option>
                    <option value="aku">AKU</option>
                    <option value="category_name">Category</option>
                    <option value="product_type_name">Product Type</option>
                    <option value="dynamic_fields">Dynamic Fields</option>
                    <option value="print_mode">Print Mode</option>
                    <option value="production_art_url_1">Production Art url 1</option>
                    <option value="production_art_url_2">Production Art url 2</option>
                    <option value="total_amount">Sale Price</option>
                    <option value="quantity">Sale Quantity</option>
                    <option value="order_id">Sales Order Id</option>
                    <option value="customer_info">Customer</option>
                </select>
            </div>
            <div class="col-md-3 dynamic_fields_section" style="display: none">
                <?php $dynamic_fields = DB::table('product_dynamic_fields')                                       
                ->select('field_name')
                ->distinct()
                ->where('created_by',  Auth::user()->id)
                ->orderBy('dynamic_field_row_id')
                ->get();
            ?>
                <select class="form-control" name="dynamic_field_name[]" id="dynamic_field_name" autocomplete="off">
                <option value="">Select</option>
                    @foreach($dynamic_fields as $fields)
                        <option value="{{ $fields->field_name }}">{{ $fields->field_name }}</option>
                    @endforeach 
                </select>
            </div>

            <div class="col-md-2">
                <select class="form-control" name="condition[]" autocomplete="off">
                    <option value="equals">Is Equal To</option>
                    <option value="not_equals">Is Not Equal To</option>
                    <option value="greater_than">Is Greater Than</option>
                    <option value="less_than">Is Less Than</option>
                    <option value="starts_with">Starts With</option>
                    <option value="ends_with">Ends With</option>
                    <option value="contains">Contains</option>
                    <option value="not_contains">Does Not Contain</option>
                </select>
            </div>
            <div class="col-md-3 lastdiv">
                <input type="text" class="form-control" name="condition_value[]" autocomplete="off" />
            </div>
        </div>
    </div>
	                    	
	<?php 
		$html = ob_get_contents();
		ob_end_clean();
		echo $html;
	}

	public function placeOrder() {
		$countries = \App\Models\Country::all();
		$allProducts = \App\Models\Product::all();
		//dd($allProducts);
		return view('product.place_order', compact('countries', 'allProducts'));
	}

	public function testcsvupload() {
		// trying to export comma separated csv data within string and import that csv
		$product_data = \App\Models\Product::all()->toArray();
		//dd($product_data);
		$CsvDataImp = array();
		foreach($product_data as $data) {
			foreach ($data as $key => $value) {
				$CsvHead[] = $key;
				$CsvData[] = $value;
			}
		}

		$filename = date('Y-m-d').".csv";
        $file_path = base_path().'/public/csv/'.$filename;   
        $file = fopen($file_path,"w+");
        fputcsv($file, $CsvData); 
        fclose($file);          
 
        $headers = ['Content-Type' => 'application/csv'];

        $headOnly = implode(',', $CsvHead);
       

        $file = 'D:xampp/htdocs/merchwareapp/public/csv/2017-08-25.csv';
		$query = "LOAD DATA LOCAL INFILE '" . $file . "' INTO TABLE products_csv FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\\n' IGNORE 1 LINES
		        (".$headOnly.")";
		DB::connection()->getpdo()->exec($query);
      	exit;
	}

	public function importProductByVendor() {		
		$data = [];
		$data['search_result'] = 0;
		$data['product_dynamic_fields'] = [];
		$data['products_list']= [];
		$data['import_templates'] = [];
		$data['user_id'] = Auth::user()->id;
		return view('product.import-product-by-vendor', ['data'=>$data]);
	}

	public function manageVendorProduct() {
		$data['products_list'] = [];
		$data['search_result'] = 0;
		$data['product_dynamic_fields'] = config('site_config.product_dynamic_fields'); 
		$common_model = new Common();                         
	    $data['categories_list'] = $common_model->allCategories();
		$data['user_id'] = Auth::user()->id;
		$data['import_templates'] = \App\Models\ImportTemplate::where('created_by', Auth::user()->id)->get();
		return view('product.vendor_product_list', ['data'=>$data]);
	}


	function importArtist()
	{  			
	
		$data['categories_list'] = \App\Models\Category::where('created_by', Auth::user()->id)->get();
		$data['vendors_list'] = \App\Models\Vendor::where('created_by', Auth::user()->id)->get();
		$data['product_types_list'] = \App\Models\Product_type::where('created_by', Auth::user()->id)->get();
		$data['customer_groups_list'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->get();
		$data['tag_groups'] = \App\Models\Tag_group::where('created_by', Auth::user()->id)->get();
		$data['collection_list'] = \App\Models\Collection::where('created_by', Auth::user()->id)->get();
		$data['folder_list'] = \App\Models\Folder::where('created_by', Auth::user()->id)->get();	 
		$data['description_list'] = \App\Models\Description::where('created_by', Auth::user()->id)->get();
		$data['price_list'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->get();
		$data['products_list'] = DB::table('products')->where([ ['created_by', Auth::user()->id], ['is_deleted', '!=', 1]])->get();	
		return view('product.import_artist', ['data'=>$data]);
	   
	}

	function importArtistTemplate()
	{  			
	
		$data['categories_list'] = \App\Models\Category::where('created_by', Auth::user()->id)->get();
		$data['vendors_list'] = \App\Models\Vendor::where('created_by', Auth::user()->id)->get();
		$data['product_types_list'] = \App\Models\Product_type::where('created_by', Auth::user()->id)->get();
		$data['customer_groups_list'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->get();
		$data['tag_groups'] = \App\Models\Tag_group::where('created_by', Auth::user()->id)->get();
		$data['collection_list'] = \App\Models\Collection::where('created_by', Auth::user()->id)->get();
		$data['folder_list'] = \App\Models\Folder::where('created_by', Auth::user()->id)->get();	 
		$data['description_list'] = \App\Models\Description::where('created_by', Auth::user()->id)->get();
		$data['price_list'] = \App\Models\Customer_group::where('created_by', Auth::user()->id)->get();
		$data['products_list'] = DB::table('products')->where([ ['created_by', Auth::user()->id], ['is_deleted', '!=', 1]])->get();	
		return view('product.import_artist', ['data'=>$data]);
	   
	}

	
}
