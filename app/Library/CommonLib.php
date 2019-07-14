<?php
namespace App\Library;
use App\Models\Product;
use DB;
use Auth;

Class CommonLib {

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

    public function fromDynamicFields($col, $rule, $val) {
        //echo $col.'   '.$val; exit;
         $getAllData = \App\Models\Product::select('product_row_id', 'product_dynamic_fields')->where('created_by', Auth::user()->id)->get();
        switch ($rule) {     
            case "equals":
               //return \App\Models\ProductDynamicField::where('created_by', Auth::user()->id)->where('field_name', "=" , $col)->where('field_value', "=" , $val)->pluck('product_row_id');
                foreach ($getAllData as $data) {
                    $allpdf = json_decode($data['product_dynamic_fields']);
                    foreach ($allpdf as $key => $value) {
                        if(($key == $col) && ($value == $val)) {
                            $pid[] = $data['product_row_id'];
                        }
                    }
                }
                return !empty($pid) ? $pid : [];
                break;            
            case "not_equals":
                //return \App\Models\ProductDynamicField::where('created_by', Auth::user()->id)->where('field_name', "=" , $col)->where('field_value', "<>" , $val)->pluck('product_row_id');
                foreach ($getAllData as $data) {
                    $allpdf = json_decode($data['product_dynamic_fields']);
                    foreach ($allpdf as $key => $value) {
                        if(($key == $col) && ($value != $val)) {
                            $pid[] = $data['product_row_id'];
                            continue;
                        }
                    }
                }
                return !empty($pid) ? $pid : [];
                break;            
            case "starts_with":                      
                //return \App\Models\ProductDynamicField::where('created_by', Auth::user()->id)->where('field_name', "=" , $col)->where('field_value', "like" , $val . "%")->pluck('product_row_id');
                foreach ($getAllData as $data) {
                    $allpdf = json_decode($data['product_dynamic_fields']);
                    foreach ($allpdf as $key => $value) {
                        if($key == $col) {
                            if (0 === strpos($value, $val)) {
                                $pid[] = $data['product_row_id'];
                                continue;
                            }
                        }
                    }

                }
                return !empty($pid) ? $pid : [];
                break;            
            case "ends_with":
                //return \App\Models\ProductDynamicField::where('created_by', Auth::user()->id)->where('field_name', "=" , $col)->where('field_value', "like" , "%" . $val)->pluck('product_row_id');
                foreach ($getAllData as $data) {
                    $allpdf = json_decode($data['product_dynamic_fields']);
                    foreach ($allpdf as $key => $value) {
                        if($key == $col) {
                            if (substr($value, -1) == $val) {    
                                $pid[] = $data['product_row_id'];
                                continue;
                            }
                        }
                    }
                }
                return !empty($pid) ? $pid : [];
                break;            
            case "contains":
                //return \App\Models\ProductDynamicField::where('created_by', Auth::user()->id)->where('field_name', "=" , $col)->where('field_value', "like" , "%" . $val . "%")->pluck('product_row_id');

                foreach ($getAllData as $data) {
                    $allpdf = json_decode($data['product_dynamic_fields']);
                    foreach ($allpdf as $key => $value) {
                        if($key == $col) {
                            if (strpos($value, $val) !== false) {   
                                $pid[] = $data['product_row_id'];
                                continue;
                            }
                        }
                    }
                }
                return !empty($pid) ? $pid : [];
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
    
    public function getOrderDeskAccountByUser($userid) {
        $orderdesk = \App\Models\AccountOrderdesk::where('user_id', $userid)->first();
        return $orderdesk;
    }   


    public function getFieldNameByField($inputFieldName='id', $inputFieldVal=0, $returnFieldName='', $modelName='') {
        $Models = "\App\Models\'" . $modelName;
        $r = str_replace("'", '', $Models) ::where($inputFieldName, $inputFieldVal)->first();
        if(isset($r) && count($r)) {
            return $r->$returnFieldName;
        }
    }

    }    
