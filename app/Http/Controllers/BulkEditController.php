<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Auth;

class BulkEditController extends Controller {

    public function bulkEdit(Request $request) {
        $product_dynamic_fields = config('site_config.product_dynamic_fields');
        return view("product.product_bulk_edit", [
            "fields" => $this->editable_fields,
            "product_dynamic_fields" => $product_dynamic_fields
        ]);
    }

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
        "tags",
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

    public function search(Request $request) {
       
        $products = Product::where('created_by', Auth::user()->id);
        if($request->match != "listall") {
            foreach($request->conditions as $i => $condition) {
                if(in_array($condition["column"], array("product_name", "product_sku", "product_price", "vendor_name", "vendor_sku", "collection_name", "folder_name", "aku", "product_type_name", "dynamic_fields", "print_mode", "production_art_url_1", "production_art_url_2", "total_amount", "quantity", "order_id", "customer_info" ))) {
                    if($condition["column"] == "vendor_name") {
                       $condition["value"] = $this->getVendors($condition["column"], $condition["rule"], $condition["value"]);
                       $condition["column"] = 'vendor_row_id'; 
                       $condition["rule"] = 'array_in';
                    }

                    if($condition["column"] == "folder_name") {
                       $condition["value"] = $this->getFolders($condition["column"], $condition["rule"], $condition["value"]);
                       $condition["column"] = 'folder_row_id'; 
                       $condition["rule"] = 'array_in';
                    }

                    if($condition["column"] == "collection_name") {                        
                       $condition["value"] = $this->getCollections($condition["column"], $condition["rule"], $condition["value"]);
                       $condition["column"] = 'collection_row_id'; 
                       $condition["rule"] = 'array_in';
                    }
                    if($condition["column"] == "product_type_name") {
                       $condition["value"] = $this->getProductTypes($condition["column"], $condition["rule"], $condition["value"]);
                       $condition["column"] = 'product_type_row_id'; 
                       $condition["rule"] = 'array_in';
                    }
                    if($condition["column"] == "dynamic_fields") { 
                       $condition["value"] = $this->fromDynamicFields($condition["dynamic_field_name"], $condition["rule"], $condition["value"]);                      
                       $condition["column"] = 'product_row_id'; 
                       $condition["rule"] = 'array_in';
                    }
                    if($condition["column"] == "customer_info" || $condition["column"] == "order_id" || $condition["column"] == "total_amount" || $condition["column"] == "quantity") {                      
                       $condition["value"] = $this->fromSalesCustomer($condition["column"], $condition["rule"], $condition["value"]);
                       $condition["column"] = 'product_row_id'; 
                       $condition["rule"] = 'array_in';
                    }

                switch ($condition["rule"]) {
                        case "equals":
                            if($request->match == "all" || $i == 0) {
                                $products = $products->where($condition["column"], $condition["value"]);
                            } elseif($request->match == "any") {
                                $products = $products->orWhere($condition["column"], $condition["value"]);
                            }
                            break;

                        case "not_equals":
                            if($request->match == "all" || $i == 0) {
                                $products = $products->where($condition["column"], "<>", $condition["value"]);
                            } elseif($request->match == "any") {
                                $products = $products->orWhere($condition["column"], "<>", $condition["value"]);
                            }
                            break;
                        case "greater_than":
                            if($request->match == "all" || $i == 0) {
                                $products = $products->where($condition["column"], ">", $condition["value"]);
                            } elseif($request->match == "any") {
                                $products = $products->orWhere($condition["column"], ">", $condition["value"]);
                            }
                            break;
                        case "less_than":
                            if($request->match == "all" || $i == 0) {
                                $products = $products->where($condition["column"], "<", $condition["value"]);
                            } elseif($request->match == "any") {
                                $products = $products->orWhere($condition["column"], "<", $condition["value"]);
                            }
                            break;
                        case "starts_with":
                            if($request->match == "all" || $i == 0) {
                                $products = $products->where($condition["column"], "like", $condition["value"]."%");
                            } elseif($request->match == "any") {
                                $products = $products->orWhere($condition["column"], "like", $condition["value"]."%");
                            }
                            break;
                        case "ends_with":
                            if($request->match == "all" || $i == 0) {
                                $products = $products->where($condition["column"], "like", "%".$condition["value"]);
                            } elseif($request->match == "any") {
                                $products = $products->orWhere($condition["column"], "like", "%".$condition["value"]);
                            }
                            break;
                        case "contains":
                            if($request->match == "all" || $i == 0) {
                                $products = $products->where($condition["column"], "like", "%".$condition["value"]."%");
                            } elseif($request->match == "any") {
                                $products = $products->orWhere($condition["column"], "like", "%".$condition["value"]."%");
                            }
                            break;
                        case "not_contains":
                            if($request->match == "all" || $i == 0) {
                                $products = $products->where($condition["column"], "not like", "%".$condition["value"]."%");
                            } elseif($request->match == "any") {
                                $products = $products->orWhere($condition["column"], "not like", "%".$condition["value"]."%");
                            }
                            break;
                        case "array_in":
                            if($request->match == "all" || $i == 0) {
                                $products = $products->whereIn($condition["column"], $condition["value"]);
                            } elseif($request->match == "any") {                                
                                $products = $products->orWhereIn($condition["column"], $condition["value"]);
                            }
                            break; 
                    }
                }
            }
        }

        return response()->json($products->get(["product_row_id", "product_name", "product_sku", "image_external_link", "product_image"])->toArray());
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

    public function updateField(Request $request) {
        if($request->data) {
            Product::where('created_by', Auth::user()->id)->where("product_row_id", $request->product)->update(
                collect($request->data)->reject(function($value, $key) {
                    return !in_array($key, $this->editable_fields);
                })->toArray()
            );
        }
    }
}
