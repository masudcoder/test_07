<?php
    namespace App\Http\Controllers;
    use Chumper\Zipper\Zipper;
    use Illuminate\Http\Request;
    use App\Http\Requests;
    use Illuminate\Support\Facades\File;

    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Redirect;

    use Intervention\Image\Exception\NotReadableException;
    use Intervention\Image\ImageManagerStatic as Image;
    use Session;
    use DB;
    use Auth;
    use Excel;
    use Illuminate\Support\Facades\Input;
    use PDF;
    use App\Models\Product;
    use App\Library\CommonLib;
    

    class ReportController extends Controller
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
        "product_meta_description",
        "production_art_url_1",
        "production_art_url_2",
    ];

    public function __construct() {
            $this->middleware('auth');
    }

    function downloadImageFromUrl($imageLinkURL, $saveLocationPath) {
       $channel = curl_init();
       $curl_setopt($channel, CURLOPT_URL, $imageLinkURL);
       $curl_setopt($channel, CURLOPT_POST, 0);
       $curl_setopt($channel, CURLOPT_RETURNTRANSFER, 1);
       $fileBytes = curl_exec($channel); 
       curl_close($channel);   
       $saveLocationPath = public_path('uploads\product_images');
       $fileWritter = fopen($saveLocationPath, 'w');
       fwrite($fileWritter, $fileBytes);
       fclose($fileWritter); 
    }
        public function index() {
           //echo $contents = file_get_contents('http://www.google.com/images/logos/ps_logo2.png');

            //$this->downloadImageFromUrl("http://www.google.com/images/logos/ps_logo2.png", "/tmp/ps_logo2.png");
            $data = array();
            $data['categories_list'] = \App\Models\Category::where('created_by', Auth::user()->id)->get();
            $data['vendors_list'] = \App\Models\Vendor::where('created_by', Auth::user()->id)->get();
            $data['product_types_list'] = \App\Models\Product_type::where('created_by', Auth::user()->id)->get();
            $data['collections'] = \App\Models\Collection::where('created_by', Auth::user()->id)->get();
            $data['folders_list'] = \App\Models\Folder::where('created_by', Auth::user()->id)->get();
			$data['export_templates'] = \App\Models\Template::where('created_by', Auth::user()->id)->get();
            $data['vendor_row_id'] = 0;
            $data['products_list'] = array();
            $data['user_id'] = Auth::user()->id;
            $data['product_dynamic_fields'] = config('site_config.product_dynamic_fields');     
            return view('reports.report_home', ['data'=>$data, 'fields'=>$this->editable_fields]);
            //
        }

    public function searchProductAndSalesData(Request $request) {

    $products = Product::where('created_by', Auth::user()->id); 
        if($request->match !== "listall") {            
            if($request->conditions) {
                foreach ($request->conditions as $i => $condition) {
                    if (in_array($condition["column"], array("product_name", "product_sku", "product_price"))) {
                        switch ($condition["rule"]) {
                            case "equals":
                                if ($request->match == "all" || $i == 0) {
                                    $products = $products->where($condition["column"], $condition["value"]);
                                } elseif ($request->match == "any") {
                                    $products = $products->orWhere($condition["column"], $condition["value"]);
                                }
                                break;
                            case "not_equals":
                                if ($request->match == "all" || $i == 0) {
                                    $products = $products->where($condition["column"], "<>", $condition["value"]);
                                } elseif ($request->match == "any") {
                                    $products = $products->orWhere($condition["column"], "<>", $condition["value"]);
                                }
                                break;
                            case "greater_than":
                                if ($request->match == "all" || $i == 0) {
                                    $products = $products->where($condition["column"], ">", $condition["value"]);
                                } elseif ($request->match == "any") {
                                    $products = $products->orWhere($condition["column"], ">", $condition["value"]);
                                }
                                break;
                            case "less_than":
                                if ($request->match == "all" || $i == 0) {
                                    $products = $products->where($condition["column"], "<", $condition["value"]);
                                } elseif ($request->match == "any") {
                                    $products = $products->orWhere($condition["column"], "<", $condition["value"]);
                                }
                                break;
                            case "starts_with":
                                if ($request->match == "all" || $i == 0) {
                                    $products = $products->where($condition["column"], "like", $condition["value"] . "%");
                                } elseif ($request->match == "any") {
                                    $products = $products->orWhere($condition["column"], "like", $condition["value"] . "%");
                                }
                                break;
                            case "ends_with":
                                if ($request->match == "all" || $i == 0) {
                                    $products = $products->where($condition["column"], "like", "%" . $condition["value"]);
                                } elseif ($request->match == "any") {
                                    $products = $products->orWhere($condition["column"], "like", "%" . $condition["value"]);
                                }
                                break;
                            case "contains":
                                if ($request->match == "all" || $i == 0) {
                                    $products = $products->where($condition["column"], "like", "%" . $condition["value"] . "%");
                                } elseif ($request->match == "any") {
                                    $products = $products->orWhere($condition["column"], "like", "%" . $condition["value"] . "%");
                                }
                                break;
                            case "not_contains":
                                if ($request->match == "all" || $i == 0) {
                                    $products = $products->where($condition["column"], "not like", "%" . $condition["value"] . "%");
                                } elseif ($request->match == "any") {
                                    $products = $products->orWhere($condition["column"], "not like", "%" . $condition["value"] . "%");
                                }
                                break;
                        }
                    }
                }
            }
        }

    return response()->json($products->get(array_merge($this->editable_fields, ["product_row_id"]))->toArray());
    }    

/*
    public function searchProductBefore($request) {
        $products = Product::where('created_by', Auth::user()->id);
        if($request->collection_match !== "listall") {   
        $request->match = $request->collection_match;
        if($request->condition) {
                foreach ($request->condition as $i => $condition) {
                    if (in_array($request->condition_type[$i], array("product_name", "product_sku", "product_price"))) {
                        switch ($request->condition[$i]) {
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
                        }
                    }
                }
            }
        }

     

        return $products;
    }
*/
    
  public function searchProduct($request) {   
        $products = Product::where('created_by', Auth::user()->id);
        if($request->collection_match !== "listall") {   
        $request->match = $request->collection_match;
        if($request->condition) {           
                foreach ($request->condition as $i => $condition) {
                    if (in_array($request->condition_type[$i], array("product_name", "product_sku", "product_price", "vendor_name", "vendor_sku", "collection_name", "folder_name", "aku", "category_name", "product_type_name", "dynamic_fields", "print_mode", "production_art_url_1", "production_art_url_2", "total_amount", "quantity", "order_id", "customer_info" ) ) ) {

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
                            $value = $this->fromDynamicFields($request->dynamic_field_name[$i], $request->condition[$i], $request->condition_value[$i]);
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

    
    public function generateReport(Request $request)
        {

            //$products = $this->searchProduct($request);
            //$data['products_list'] = $products->get(array_merge($this->editable_fields, ["product_row_id"]))->toArray();
            //dd($request);

            $obCommonLib = new CommonLib();
            $products = $obCommonLib->searchProduct($request);
            $r = \App\Models\ProductSalesData::get();
            //dd($products);
            //exit;
            //echo '<pre>'.print_r($products, true).'</pre>'; exit;
            // make selected in the form.
            $data['collection_match'] = $request->collection_match;
            $data['condition'] = $request->condition;
            $data['condition_type'] = $request->condition_type;
            $data['condition_value'] = $request->condition_value;
            $data['dynamic_field_name'] = $request->dynamic_field_name;

            $data['sales_data_from'] = date('Y-m-d', strtotime($request->sales_data_from));
            $data['sales_data_to'] = date('Y-m-d', strtotime($request->sales_data_to));          
            $data['categories_list'] = \App\Models\Category::where('created_by', Auth::user()->id)->get();
            $data['vendors_list'] = \App\Models\Vendor::where('created_by', Auth::user()->id)->get();
            $data['product_types_list'] = \App\Models\Product_type::where('created_by', Auth::user()->id)->get();
            $data['collections'] = \App\Models\Collection::where('created_by', Auth::user()->id)->get();
            $data['folders_list'] = \App\Models\Folder::where('created_by', Auth::user()->id)->get();
            $data['vendor_row_id'] = $request->vendor_row_id;
            $data['category_row_id'] = $request->category_row_id;
            $data['collection_row_id'] = $request->collection_row_id;
            $data['product_type_row_id'] = $request->product_type_row_id;
            $data['folder_row_id'] = $request->folder_row_id;
            $data['inventory_serial'] = $request->inventory_serial;
            $data['product_name'] = $request->product_name;
            $data['product_sku'] = $request->product_sku;
            $data['aku_code'] = $request->aku_code;
			$data['export_templates'] = \App\Models\Template::where('created_by', Auth::user()->id)->get();
            $aku_prefix_code = Auth::user()->aku_prefix . '_' . $request->aku_code;
            $data['upc'] = $request->upc;

            $data['advanced_search'] = 0;

            $data['search_by_title'] = '';

            $data['user_id'] = Auth::user()->id;
            
            $searchCond = '';
            $searchBy = '';
            if( $data['vendor_row_id'] ) {
                $searchCond .= ' AND vendor_row_id = ' . $data['vendor_row_id'];
                $searchBy .= ' Vendor';

            }
            if( $data['category_row_id'] ) {
                $searchCond .= ' AND category_row_id = ' . $data['category_row_id'];
                if($searchBy)
                    $searchBy .= ',';

                $searchBy .= ' Category';
            }
            if( $data['collection_row_id'] ) {
                $searchCond .= ' AND collection_row_id = ' . $data['collection_row_id'];
                if($searchBy)
                    $searchBy .= ',';
                $searchBy .= ' Collection';
            }
            if( $data['product_type_row_id'] ) {
                $searchCond .= ' AND product_type_row_id = ' . $data['product_type_row_id'];
                if($searchBy)
                    $searchBy .= ',';
                $searchBy .= ' Product Type';
            }
            if( $data['folder_row_id'] ) {
                $searchCond .= ' AND folder_row_id = ' . $data['folder_row_id'];
                if($searchBy)
                    $searchBy .= ',';
                $searchBy .= ' Folder';
            }

            if( $data['inventory_serial']) {
                $searchCond .= ' AND inventory_serial  LIKE \'%' . $data['inventory_serial'] . '%\'' ;
                if($searchBy)
                    $searchBy .= ',';
                $searchBy .= ' Inventory Serial';
            }

            if( $data['product_name']) {
                $searchCond .= ' AND product_name  LIKE \'%' . $data['product_name'] . '%\'' ;
                if($searchBy)
                    $searchBy .= ',';
                $searchBy .= ' Product Name';
            }
            if( $data['product_sku']) {
                $searchCond .= ' AND product_sku  LIKE \'%' . $data['product_sku'] . '%\'' ;
                if($searchBy)
                    $searchBy .= ',';
                $searchBy .= ' Product Sku';
            }
            if( $data['aku_code'] ) {
                $searchCond .= ' AND aku_code  LIKE \'%' . $aku_prefix_code . '%\'' ;
                if($searchBy)
                    $searchBy .= ',';
                $searchBy .= ' Aku Code';

            }
            if( $data['upc'] ) {
                $searchCond .= ' AND upc  LIKE \'%' . $data['upc'] . '%\'' ;
                if($searchBy)
                    $searchBy .= ',';
                $searchBy .= ' Barcode';
            }


            if(!$searchCond)
            {
                $data['search_by_title']= 'All';
            }
            else
            {
                $data['search_by_title'] = 'Search By' . $searchBy;
            }



            $data['search_result_page'] = 1;
            $data['product_dynamic_fields'] = config('site_config.product_dynamic_fields');
             if($request->submit == 'search') {                      
                  $data['products_list'] = $products->paginate(5000);
                  $data['search_result'] = 1;  
                  return view('reports.report_home', ['data'=>$data, 'fields'=>$this->editable_fields]);
            }



            $data['products_list'] = $products->get(array_merge($this->editable_fields, ["product_row_id"]))->toArray();
            
            if($request->submit == 'csv')
            {
                if($request->template_row_id) {
                    $template_row_id = $request->template_row_id;
                    $template_info = \App\Models\Template::where('template_row_id', $template_row_id)->first();
                    
                    if($template_info->file_name) {
                        $file_info = explode(".", $template_info->file_name);
                        $template_csv_file = $file_info[0];
                    }
                    
                    $template_fields = json_decode($template_info->template_fields);
                    $results = $data['products_list'];
                    //dd($results);
                    $data = array();
                    for ($i=0; $i<count($results); $i++) 
                    {
                        for($j = 0; $j<count($template_fields); $j++) 
                        {
                            $field_name = $template_fields[$j];
                            

                            if(array_key_exists($field_name, $results[$i]) )
                            {
                                $a[$field_name] = $results[$i][$field_name] ? $results[$i][$field_name] : '' ; // Field availabe in products table
                            } 
                            else
                            {
                                // take decision whether the template field is dyncamic field?. 
                                //if it is suppose dynamic__Artist.
                                //echo $field_name.'<br>';
                                //$dynamic_field_decide_only = explode('__', $field_name);

                                /*if($dynamic_field_decide_only[0] == 'dynamic') // it is dynamic field
                                {
                                    $dynamic_field_info = \App\Models\ProductDynamicField::where('product_row_id', $results[$i]['product_row_id'])->where('field_name', $dynamic_field_decide_only[1])->first();
                                    dd($dynamic_field_info);
                                    if(!$dynamic_field_info)
                                        continue;
                                    
                                   $a[$dynamic_field_info->field_name] =  $dynamic_field_info->field_value;
                                }*/
                                $product_dynamic_fields_array = config('site_config.product_dynamic_fields');
                                if(array_key_exists($field_name, $product_dynamic_fields_array)) {
                                    $pdfield = \App\Models\Product::select('product_dynamic_fields')->where('product_row_id', $results[$i]['product_row_id'])->first()->toArray();
                                    $dbDynamicFields = json_decode($pdfield['product_dynamic_fields'],true);
                                    if(array_key_exists($field_name, $dbDynamicFields)) {
                                      $a[$field_name] =  $dbDynamicFields[$field_name];
                                    }
                                }
                                else //Asssume it as price level.
                                {
                                     //$price_level_group_info = \App\Models\Customer_group::where([ ['customer_group_name',  $field_name], ['created_by', Auth::user()->id] ] )->first();

                                    /*if($price_level_group_info) 
                                    {
                                        $price_group_row_id = $price_level_group_info->customer_group_row_id;
                                        $price_level_amount_info = \App\Models\Product_price_level::where([ ['price_group_row_id', $price_group_row_id], ['product_row_id', $results[$i]['product_row_id']] ])->first();
                                    
                                        if($price_level_amount_info) {
                                            $a[$field_name] =  $price_level_amount_info->price_level_amount;
                                        } else {
                                            $a[$field_name] =  0;
                                        }
                                    }*/
                                    $pos = strpos($field_name, 'PT-');
                                    if ($pos !== false) {
                                        $pricetypes = explode('-', $field_name);
                                        $pricetypeid = $pricetypes[1];

                                        //Get price type name
                                        $price_type_title = \App\Models\Customer_group::where([ ['customer_group_row_id',  $pricetypeid], ['created_by', Auth::user()->id] ] )->value('customer_group_name');

                                        // Get product price type fields data
                                        $product_price_types = \App\Models\Product::where([ ['product_row_id',  $results[$i]['product_row_id']], ['created_by', Auth::user()->id] ] )->value('product_price_types');
                                        $ptype_values = json_decode($product_price_types, 1);
                                        //dd($ptype_values);
                                        if(array_key_exists($pricetypeid, $ptype_values)) {
                                            $a[$price_type_title] = $ptype_values[$pricetypeid];
                                        } else {
                                            $a[$price_type_title] = 0;
                                        }
                                    }



                                }
                            }
                        }
                     $data[] = (array)$a;
                    }
                } 
                else {
                    $results = $data['products_list'];
                    $data = array();
                    for ($i=0; $i<count($results); $i++)
                    {

                        $a['ProductName'] = $results[$i]['product_name'];
                        $a['Sku'] = $results[$i]['product_sku'];
                        $a['Price'] = $results[$i]['product_price'];
                        $a['Primary image'] = $results[$i]['product_image'];
                        $data[] = (array)$a;                 
                    }
                   
                }

            $data['products_list'] = $data;
            $this->exportProductToCsv($data['products_list']);
            }
            else if($request->submit == 'pdf')
            {
                $template_type = $request->template_type;
                $sorting_order = $request->sorting_order;

                $results = $data['products_list'];
                //dd($results);
                $user_id = Auth::user()->id;
                $data = array();

                for ($i=0; $i<count($results); $i++) {
                    $product_dynamic_fields = \App\Models\Product::where('product_row_id', $results[$i]['product_row_id'])->value('product_dynamic_fields');
                    $dynamic_fds = json_decode($product_dynamic_fields, 1);
                    
                    $a['ProductName'] = $results[$i]['product_name'];
                    $a['Sku'] = $results[$i]['product_sku'];
                    $a['Price'] = $results[$i]['product_price'];
                    $a['Primaryimage'] = $results[$i]['product_image'];
                    $a['image_external_link'] = $results[$i]['image_external_link'];
                    if(array_key_exists('color', $dynamic_fds)) {
                        $a['color'] = $dynamic_fds['color'];
                    }
                    $data[] = (array)$a;                  
                }

                $data['products_list'] = $data;
                $pdfprodata = $data['products_list'];
                //dd($pdfprodata);
                $format = '';
                $search_by_title = '';

                // Check various conditions from sorting order
                if($sorting_order == 1) {
                    //SKU – Lowest to highest.
                    $skuname = array();
                    foreach ($pdfprodata as $key => $row) {
                        $skuname[$key] = $row['Sku'];
                    }
                    array_multisort($skuname, SORT_ASC, $pdfprodata);
                } else if($sorting_order == 2) {
                    //Product Name – Alphabetical
                    $proname = array();
                    foreach ($pdfprodata as $key => $row) {
                        $proname[$key] = $row['ProductName'];
                    }
                    array_multisort($proname, SORT_ASC, $pdfprodata);
                } else if($sorting_order == 3) {
                    //Price (high to low) – descending order
                    $proprice = array();
                    foreach ($pdfprodata as $key => $row) {
                        $proprice[$key] = $row['Price'];
                    }
                    array_multisort($proprice, SORT_DESC, $pdfprodata);
                } else if($sorting_order == 4) {
                    //Price (low to high) – ascending order
                    $proprice = array();
                    foreach ($pdfprodata as $key => $row) {
                        $proprice[$key] = $row['Price'];
                    }
                    array_multisort($proprice, SORT_ASC, $pdfprodata);
                } else if($sorting_order == 5) {
                    //Color – Alphabetical
                    $procolor = array();
                    foreach ($pdfprodata as $key => $row) {
                        $procolor[$key] = $row['color'];
                    }
                    array_multisort($procolor, SORT_ASC, $pdfprodata);
                } else {
                    //
                }

                //dd($pdfprodata);
                if($template_type == 1) {
                $html = '<style type="text/css">
            					body{color:#333; font-family: Helvetica Neue,Helvetica,Arial,sans-serif; }
            					h1{font-size:18px}
            				</style>
            			<div class="container">
            				<div class="row text-center"> 
            					<h1>Products List ' . $search_by_title . '</h1>
            				</div>	
            				<div class="row">
            					<div class="col-md-12">
            						<div class="portlet light bordered">                              
            							<div class="portlet-body">
            								<div class="table-toolbar">							
            									</div>
            										<table cellspacing="0" cellpadding="4" style="width:100%" border="1" style="width:1000px">
            											<thead>
            												<tr>
                                                                <th style="width:10%;">SL.</th>
            													<th style="width:40%;">Product Name</th>              
            													<th style="width:10%;text-align:left;padding-left:20px">Price</th>   
            													<th style="width:20%;text-align:left;padding-left:20px"> SKU</th>     
            													<th style="width:20%;text-align:left;padding-left:20px">Primary Image</th>
            												</tr>
            											</thead>
            											<tbody>';
                            $products_list_string = '';
                            $slcount = 1;
                            foreach($pdfprodata as $row) {
                                    
                                if($row['Primaryimage']) {
            						
            						// added for external link.
            						if($row['image_external_link']) {
            							 $productImage = '';
            						} else {
            							$productImageUrl = public_path().'/uploads/product_images/' . $user_id . '/' . $row['Primaryimage'];
                                         $productImage = '<img src="'.$productImageUrl.'" width="80" height="75" />';
                                    }
            						
                                } else {
                                    $productImage = '';
                                }


                                $products_list_string .= '<tr class="odd gradeX">
                                                                <td style="width:10%;">'.$slcount.'.'.'</td>
                                                                <td style="width:40%;">' . $row['ProductName'] . '</td>
                                                                <td style="width:10%;text-align:left;padding-left:20px"> ' .  $row['Price'] . ' </td>
            													<td style="width:20%;text-align:left;padding-left:20px"> ' . $row['Sku'] . '</td>
            													<td style="width:20%;text-align:left;padding-left:20px">' . $productImage . ' </td>
            												</tr>';
                                $slcount++;
                            }

                            $html .= $products_list_string;
                            $html .= '</tbody>
            										</table>
            							</div>
            						</div>
            					</div>
            				</div>
            			</div>';

                    $error_level = error_reporting();
                    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
                    
                    if($format == 'viewpdf') {
                        $pdf = PDF::loadHTML($html)->save(public_path().'/products_list.pdf');
                        return $pdf->stream('products_list.pdf');
                    } else {
                        $pdf = PDF::loadHTML($html)->save(public_path().'/products_list.pdf');
                        return $pdf->download('products_list.pdf');
                    }
                    error_reporting($error_level);   
                }
                if($template_type == 2) {
                    //return view('reports.no_price_product_pdf', compact('pdfprodata', 'user_id'));
                    $error_level = error_reporting();
                    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

                    $pdf = PDF::loadView('reports.no_price_product_pdf', compact('pdfprodata', 'user_id'));
                    return $pdf->stream('products_list.pdf');

                    error_reporting($error_level);
                }        

                
            }

            else if($request->submit == 'imagesOnly') 
            {
                if(count($data['products_list'])) {

                    $filename = $request->filename ? : "images";
                    $zip_path = public_path() . "/uploads/" . $filename . ".zip";
                    
                    if (file_exists($zip_path)) {
                        File::delete($zip_path);
                    }

                    $zip = new Zipper();
                    $zip->make($zip_path);
 
                    $rename = "";
                    $i = 2;

                    foreach ($data['products_list'] as $row) {
                        if($request->rename != "" && in_array($request->rename, ["product_sku", "vendor_sku", "aku_code", "upc"])) {
                            if($rename == $row[$request->rename]) {
                                $rename = $row[$request->rename] . "_" . $i++;
                            } else {
                                $rename = $row[$request->rename];
                                $i = 2;
                            }
                        }
                        if($row['product_image']) {
                            if ($row['image_external_link'] == "1") {                               
                                /*
                                $image = public_path() . '/uploads/' . ($rename ?: time()) . ".jpg";
                                Image::make(str_replace(" ", "%20", $row->product_image))->save($image);
                                if (file_exists($image)) {
                                    $zip->add($image);
                                }
                                */
                            } else {                
                                $image = public_path() . '/uploads/product_images/' . $data['user_id'] . '/' . $row['product_image'];
                                if (file_exists($image)) {
                                    $zip->add($image, $rename ? ($rename.".jpg") : null);
                                }
                            }
                        }
                    }

                    $zip->close();
                     if (file_exists($zip_path)) {
                        return response()->download($zip_path)->deleteFileAfterSend(true);
                    } else {
                        Session::flash('error-message', 'There is no image to download.');
                        return back();
                    }
                  
                    
                } else {
                    Session::flash('error-message', 'No image found according to your search criteria.');
                    return back();
                }

            }
            else if($request->submit == 'hireimagesOnly') 
            {

                require_once base_path('vendor/stefangabos/zebra_curl/Zebra_cURL.php');                
                if(count($data['products_list'])) {

                    $filename = $request->filename ? : "images";
                    $zip_path = public_path() . "/uploads/" . $filename . ".zip";
                    
                    if (file_exists($zip_path)) {
                        File::delete($zip_path);
                    }

                    $zip = new Zipper();
                    $zip->make($zip_path);
 
                    $rename = "";
                    $i = 2;
                    //$countHireImage = 0;
                   // $n = 1000;// Download maximum Hire images.

                    foreach ($data['products_list'] as $row) {
                      // if($countHireImage >= $n) 
                       // continue;

                        if($request->rename != "" && in_array($request->rename, ["product_sku", "vendor_sku", "aku_code", "upc"])) {
                            if($rename == $row[$request->rename]) {
                                $rename = $row[$request->rename] . "_" . $i++;
                            } else {
                                $rename = $row[$request->rename];
                                $i = 2;
                            }
                        }
                        
                        if($row['product_image']) 
                        {
                            $product_image =   str_replace(" ", "%20", $row['product_image']);

                            /*if (! file_exists(public_path() . '/uploads/product_images/'. $data['user_id'] . '/original_images/' . $product_image) ) {
                                $obZebra_cURL->download('http://sales.onebellacasa.com/' . $product_image , public_path(). '/uploads/product_images/' . $data['user_id'] . '/original_images');
                                 $countHireImage++;
                            }*/

                            if (file_exists(public_path() . '/uploads/product_images/'. $data['user_id'] . '/original_images/' . $product_image) )
                            {
                                $zip->add(public_path(). '/uploads/product_images/'. $data['user_id'] . '/original_images/' . $product_image  , $rename ? ($rename.".jpg") : null);
                            }
                        }
                    }

                    $zip->close();
                     if (file_exists($zip_path)) {
                        return response()->download($zip_path)->deleteFileAfterSend(true);
                    } else {
                        Session::flash('error-message', 'There is no image to download.');
                        return back();
                    }
                  
                    
                } else {
                    Session::flash('error-message', 'No image found according to your search criteria.');
                    return back();
                }

            }
            $data['product_dynamic_fields'] = config('site_config.product_dynamic_fields');
            return view('reports.report_home', ['data'=>$data]);
        }

        public function search()
        {
            $data = array();
            $data['categories_list'] = \App\Models\Category::where('created_by', Auth::user()->id)->get();
            $data['vendors_list'] = \App\Models\Vendor::where('created_by', Auth::user()->id)->get();
            $data['product_types_list'] = \App\Models\Product_type::where('created_by', Auth::user()->id)->get();
            $data['collections'] = \App\Models\Collection::where('created_by', Auth::user()->id)->get();
            $data['vendor_row_id'] = 0;
            $data['products_list'] = array();
            $data['user_id'] = Auth::user()->id;

            return view('reports.report_search', ['data'=>$data]);
            //
        }

        public function generateSearchReport(Request $request)
        {
            $data = array();
            $data['categories_list'] = \App\Models\Category::where('created_by', Auth::user()->id)->get();
            $data['vendors_list'] = \App\Models\Vendor::where('created_by', Auth::user()->id)->get();
            $data['product_types_list'] = \App\Models\Product_type::where('created_by', Auth::user()->id)->get();
            $data['collections'] = \App\Models\Collection::where('created_by', Auth::user()->id)->get();
            $data['vendor_row_id'] = $request->vendor_row_id;
            $data['category_row_id'] = $request->category_row_id;
            $data['collection_row_id'] = $request->collection_row_id;
            $data['product_type_row_id'] = $request->product_type_row_id;
            $data['product_status'] = $request->product_status;
            $data['product_name'] = $request->product_name;
            $data['product_sku'] = $request->product_sku;
            $data['advanced_search'] = 0;


            $data['user_id'] = Auth::user()->id;

            $searchCond = '';
            if( $data['vendor_row_id'] ) {
                $searchCond .= ' AND vendor_row_id = ' . $data['vendor_row_id'];
            }
            if( $data['category_row_id'] ) {
                $searchCond .= ' AND category_row_id = ' . $data['category_row_id'];
            }
            if( $data['collection_row_id'] ) {
                $searchCond .= ' AND collection_row_id = ' . $data['collection_row_id'];
            }
            if( $data['product_type_row_id'] ) {
                $searchCond .= ' AND product_type_row_id = ' . $data['product_type_row_id'];
            }
            if( $data['product_name']) {
                $searchCond .= ' AND product_name  LIKE \'%' . $data['product_name'] . '%\'' ;
            }
            if( $data['product_sku']) {
                $searchCond .= ' AND product_sku  LIKE \'%' . $data['product_sku'] . '%\'' ;
            }
            if( $data['product_status'] == 3) {
                $searchCond .= ' AND is_favourite = 1';
            }

            //$data['products_list'] = \App\Models\Product::where('created_by', Auth::user()->id)->get();
            $sql= "SELECT product_row_id, product_name As ProductName, product_sku As Sku, product_price As Price, product_image as Image, uploaded_design_image, image_external_link  FROM products WHERE  created_by = " . Auth::user()->id . " " . $searchCond  . " ";
            $data['products_list'] = DB::select($sql);


            if($request->submit == 'csv')
            {
                $results = $data['products_list'];
                $data = array();
                for ($i=0; $i<count($results); $i++)
                {
                    $a['ProductName'] = $results[$i]->ProductName;
                    $a['Sku'] = $results[$i]->Sku;
                    $a['Price'] = $results[$i]->Price;
                    $a['Design image'] = $results[$i]->uploaded_design_image;
                    $data[] = (array)$a;
                }
                $data['products_list'] = $data;
                $this->exportProductToCsv($data['products_list']);
            }
            else if($request->submit == 'pdf')
            {

                $pdf = PDF::loadView('reports.report_pdf', ['data'=>$data]);
                return $pdf->download('products_list.pdf');
                exit;
            }
            return view('reports.report_search', ['data'=>$data]);
        }

        public function exportProductToCsv($data) {

            Excel::create('product', function($excel) use ($data) {
                $excel->sheet('mySheet', function($sheet) use ($data)
                {
                    $sheet->fromArray($data);
                });
            })->download('csv');

            exit;

        }

        public function exportProductToPdf($data) {
            //$data = $data->toArray();
            return Excel::create('product', function($excel) use ($data) {
                $excel->sheet('mySheet', function($sheet) use ($data)
                {
                    $sheet->fromArray($data);
                });
            })->download("pdf");
        }

        public function reportBuilder() {
            $data = array();
            $data['folders_list'] = \App\Models\Folder::where('created_by', Auth::user()->id)->get();
            $data['products_list'] = array();
            $data['user_id'] = Auth::user()->id;
            return view('reports.report_builder', ['data'=>$data]);
        }

        public function generateReportBuilder(Request $request) {



            $searchCond = '';
            $data = array();
            $data['categories_list'] = \App\Models\Category::where('created_by', Auth::user()->id)->get();
            $data['vendors_list'] = \App\Models\Vendor::where('created_by', Auth::user()->id)->get();
            $data['product_types_list'] = \App\Models\Product_type::where('created_by', Auth::user()->id)->get();
            $data['collections'] = \App\Models\Collection::where('created_by', Auth::user()->id)->get();
            $data['folders_list'] = \App\Models\Folder::where('created_by', Auth::user()->id)->get();
            $data['product_name'] = $request->product_name;
            $data['group_by_element'] = $request->group_by_element;


            $data['user_id'] = Auth::user()->id;

            if( $data['group_by_element'] ) {
                $searchCond .= ' GROUP BY ' . $data['group_by_element'];
            }

            if( $data['product_name']) {
                $searchCond .= ' AND product_name  LIKE \'%' . $data['product_name'] . '%\'' ;
            }

            //SELECT count(`product_row_id`), v. vendor_name FROM `products` p LEFT JOIN vendors v ON p.vendor_row_id = v.vendor_row_id GROUP BY p.`vendor_row_id`
            //WHERE  p.created_by = " . Auth::user()->id . "

            //	$sql ="SELECT count(product_row_id), v.vendor_name FROM products p left join vendors v ON p.vendor_row_id = v.vendor_row_id GROUP BY p.vendor_row_id";

            $sql ="SELECT count(product_row_id) as count, vendor_row_id FROM products WHERE  created_by = " . Auth::user()->id . " GROUP BY vendor_row_id  ";

            $data['products_list'] = DB::select($sql);


            $data['user_id'] = Auth::user()->id;
            return view('reports.report_builder', ['data'=>$data]);
        }



    public function getSalesData(Request $request) {
        $sales_data_from = date('Y-m-d', strtotime($request->sales_data_from));
        $sales_data_to = date('Y-m-d', strtotime($request->sales_data_to));
        
        if($sales_data_from  && $sales_data_from != '1970-01-01') {
            $sales_data = \App\Models\ProductSalesData::where('product_row_id', $request->product_row_id)
                                                    ->whereBetween('order_date',[$sales_data_from, $sales_data_to])
                                                    ->get();
        } else{
            $sales_data = \App\Models\ProductSalesData::where('product_row_id', $request->product_row_id)
                                                    ->get();
        }
        
       
        echo '<table class="table table-responsive table-bordered">';
        echo '<thead>';
        echo '<tr>';
        echo '<th> Order Date </th>';
        echo '<th> Customer </th>';
        echo '<th> Quantity </th>';
        echo '<th> Total Amount </th>';
        echo '</tr>';
        echo '</thead>';

        if( count($sales_data) ) {          
            foreach ($sales_data as $row) {
                echo '<tr>';
                echo '<td>'. $row->order_date .'</td>';
                echo '<td>' . $row->customer_info . ' </td>';
                echo '<td>'. $row->quantity .'</td>';
                echo '<td>'. number_format($row->total_amount, 2, '.', '') .'</td>';
                echo '</tr>';
            }
        } else {
                echo '<tr>';
                echo '<td colspan="4"> No Sales Data Available.</td>';                
                echo '</tr>';
        }

        echo '</table>';

    }


     public function getVendors($col, $rule, $val ) {
        switch ($rule) {     
            case "equals":
               return \App\Models\Vendor::where('created_by', Auth::user()->id)->where($col, "=" , $val)->pluck('vendor_row_id');
                break;            
            case "not_equals":
                return \App\Models\Vendor::where('created_by', Auth::user()->id)->where($col, "<>" , $val)->pluck('vendor_row_id');
                break;            
            case "starts_with":
                return \App\Models\Vendor::where('created_by', Auth::user()->id)->where($col, "like" , $val . "%")->pluck('vendor_row_id');
                break;            
            case "ends_with":
                return \App\Models\Vendor::where('created_by', Auth::user()->id)->where($col, "like" , "%" . $val)->pluck('vendor_row_id');
                break;            
            case "contains":
                return \App\Models\Vendor::where('created_by', Auth::user()->id)->where($col, "like" , "%" . $val . "%")->pluck('vendor_row_id');
                break;        
            case "not_contains":
                return \App\Models\Vendor::where('created_by', Auth::user()->id)->where($col, "not like" , "%" . $val . "%")->pluck('vendor_row_id');
                break;
        }

    }

     public function getFolders($col, $rule, $val ) {
        switch ($rule) {     
            case "equals":
               return \App\Models\Folder::where('created_by', Auth::user()->id)->where($col, "=" , $val)->pluck('folder_row_id');
                break;            
            case "not_equals":
                return \App\Models\Folder::where('created_by', Auth::user()->id)->where($col, "<>" , $val)->pluck('folder_row_id');
                break;            
            case "starts_with":
                return \App\Models\Folder::where('created_by', Auth::user()->id)->where($col, "like" , $val . "%")->pluck('folder_row_id');
                break;            
            case "ends_with":
                return \App\Models\Folder::where('created_by', Auth::user()->id)->where($col, "like" , "%" . $val)->pluck('folder_row_id');
                break;            
            case "contains":
                return \App\Models\Folder::where('created_by', Auth::user()->id)->where($col, "like" , "%" . $val . "%")->pluck('folder_row_id');
                break;        
            case "not_contains":
                return \App\Models\Folder::where('created_by', Auth::user()->id)->where($col, "not like" , "%" . $val . "%")->pluck('folder_row_id');
                break;
        }

    }

    

    public function getCollections($col, $rule, $val ) {
        switch ($rule) {     
            case "equals":
               return \App\Models\Collection::where('created_by', Auth::user()->id)->where($col, "=" , $val)->pluck('collection_row_id');
                break;            
            case "not_equals":
                return \App\Models\Collection::where('created_by', Auth::user()->id)->where($col, "<>" , $val)->pluck('collection_row_id');
                break;            
            case "starts_with":
                return \App\Models\Collection::where('created_by', Auth::user()->id)->where($col, "like" , $val . "%")->pluck('collection_row_id');
                break;            
            case "ends_with":
                return \App\Models\Collection::where('created_by', Auth::user()->id)->where($col, "like" , "%" . $val)->pluck('collection_row_id');
                break;            
            case "contains":
                return \App\Models\Collection::where('created_by', Auth::user()->id)->where($col, "like" , "%" . $val . "%")->pluck('collection_row_id');
                break;        
            case "not_contains":
                return \App\Models\Collection::where('created_by', Auth::user()->id)->where($col, "not like" , "%" . $val . "%")->pluck('collection_row_id');
                break;
        }

    }

    public function getCategories($col, $rule, $val ) {
        switch ($rule) {     
            case "equals":
               return \App\Models\Category::where('created_by', Auth::user()->id)->where($col, "=" , $val)->pluck('category_row_id');
                break;            
            case "not_equals":
                return \App\Models\Category::where('created_by', Auth::user()->id)->where($col, "<>" , $val)->pluck('category_row_id');
                break;            
            case "starts_with":
                return \App\Models\Category::where('created_by', Auth::user()->id)->where($col, "like" , $val . "%")->pluck('category_row_id');
                break;            
            case "ends_with":
                return \App\Models\Category::where('created_by', Auth::user()->id)->where($col, "like" , "%" . $val)->pluck('category_row_id');
                break;            
            case "contains":
                return \App\Models\Category::where('created_by', Auth::user()->id)->where($col, "like" , "%" . $val . "%")->pluck('category_row_id');
                break;        
            case "not_contains":
                return \App\Models\Category::where('created_by', Auth::user()->id)->where($col, "not like" , "%" . $val . "%")->pluck('category_row_id');
                break;
        }

    }

     public function getProductTypes($col, $rule, $val ) {
        switch ($rule) {     
            case "equals":
               return \App\Models\Product_type::where('created_by', Auth::user()->id)->where($col, "=" , $val)->pluck('product_type_row_id');
                break;            
            case "not_equals":
                return \App\Models\Product_type::where('created_by', Auth::user()->id)->where($col, "<>" , $val)->pluck('product_type_row_id');
                break;            
            case "starts_with":
                return \App\Models\Product_type::where('created_by', Auth::user()->id)->where($col, "like" , $val . "%")->pluck('product_type_row_id');
                break;            
            case "ends_with":
                return \App\Models\Product_type::where('created_by', Auth::user()->id)->where($col, "like" , "%" . $val)->pluck('product_type_row_id');
                break;            
            case "contains":
                return \App\Models\Product_type::where('created_by', Auth::user()->id)->where($col, "like" , "%" . $val . "%")->pluck('product_type_row_id');
                break;        
            case "not_contains":
                return \App\Models\Product_type::where('created_by', Auth::user()->id)->where($col, "not like" , "%" . $val . "%")->pluck('product_type_row_id');
                break;
        }

    }

    public function fromDynamicFields($col, $rule, $val ) {       
        switch ($rule) {     
            case "equals":
               return \App\Models\ProductDynamicField::where('created_by', Auth::user()->id)->where('field_name', "=" , $col)->where('field_value', "=" , $val)->pluck('product_row_id');
                break;            
            case "not_equals":
                return \App\Models\ProductDynamicField::where('created_by', Auth::user()->id)->where('field_name', "=" , $col)->where('field_value', "<>" , $val)->pluck('product_row_id');
                break;            
            case "starts_with":                      
                return \App\Models\ProductDynamicField::where('created_by', Auth::user()->id)->where('field_name', "=" , $col)->where('field_value', "like" , $val . "%")->pluck('product_row_id');
                break;            
            case "ends_with":
                return \App\Models\ProductDynamicField::where('created_by', Auth::user()->id)->where('field_name', "=" , $col)->where('field_value', "like" , "%" . $val)->pluck('product_row_id');
                break;            
            case "contains":
                return \App\Models\ProductDynamicField::where('created_by', Auth::user()->id)->where('field_name', "=" , $col)->where('field_value', "like" , "%" . $val . "%")->pluck('product_row_id');
                break;        
            case "not_contains":
                return \App\Models\ProductDynamicField::where('created_by', Auth::user()->id)->where('field_name', "=" , $col)->where('field_value', "not like" , "%" . $val . "%")->pluck('product_row_id');
                break;
        }
    }

     public function fromSalesCustomer($col, $rule, $val ) {       
        switch ($rule) {     
           case "equals":
               return \App\Models\ProductSalesData::where('created_by', Auth::user()->id)->where($col, "=" , $val)->pluck('product_row_id');
                break;            
            case "not_equals":
                return \App\Models\ProductSalesData::where('created_by', Auth::user()->id)->where($col, "<>" , $val)->pluck('product_row_id');
                break;            
             case "greater_than":
                return \App\Models\ProductSalesData::where('created_by', Auth::user()->id)->where($col, ">" , $val)->pluck('product_row_id');
                break;
            case "less_than":
                return \App\Models\ProductSalesData::where('created_by', Auth::user()->id)->where($col, "<" , $val)->pluck('product_row_id');
                break;                                
            case "starts_with":
                return \App\Models\ProductSalesData::where('created_by', Auth::user()->id)->where($col, "like" , $val . "%")->pluck('product_row_id');
                break;            
            case "ends_with":
                return \App\Models\ProductSalesData::where('created_by', Auth::user()->id)->where($col, "like" , "%" . $val)->pluck('product_row_id');
                break;            
            case "contains":
                return \App\Models\ProductSalesData::where('created_by', Auth::user()->id)->where($col, "like" , "%" . $val . "%")->pluck('product_row_id');
                break;        
            case "not_contains":
                return \App\Models\ProductSalesData::where('created_by', Auth::user()->id)->where($col, "not like" , "%" . $val . "%")->pluck('product_row_id');
                break;
        }
    }

    }
