<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Conditions;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests;  
use Illuminate\Support\Facades\Redirect;
use Auth;
use Session;
use DB;
use App\Library\CommonLib;
class CollectionManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('collection.collection_home', [
            "collections" => Collection::where('created_by', Auth::user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = array();
        /*$data['dynamic_fields'] = DB::table('product_dynamic_fields As df')
            ->join('products As p', 'df.product_row_id', '=', 'p.product_row_id')
            ->select('df.dynamic_field_row_id', 'df.field_name')
            ->where('p.created_by',  Auth::user()->id)
            ->orderBy('df.dynamic_field_row_id')
            ->get(); */
        $data['dynamic_fields'] = config('site_config.product_dynamic_fields');
        return view('collection.collection_create', ['data' => $data]);
    }
    

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
        /*switch ($rule) {     
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
        }*/

        $getAllData = \App\Models\Product::select('product_row_id', 'product_dynamic_fields')->where('created_by', Auth::user()->id)->get();
        
        switch ($rule) {
            case "equals":
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

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if($request->edit_row_id) {
            $collection = Collection::where("created_by", Auth::user()->id)->find($request->edit_row_id);
            $collection->updated_by = Auth::user()->id;

            Product::where('created_by', Auth::user()->id)->where("collection_row_id", $collection->collection_row_id)->update(["collection_row_id" => null]);

            Session::flash('success-message', 'Collection has beed updated successfully.');
        } else {
            $collection = new Collection();
            $collection->created_by = Auth::user()->id;

            Session::flash('success-message', 'Collection has beed added successfully.');
        }
        $collection->collection_name = $request->collection_name;
        $collection->collection_description = $request->collection_description;
        $collection->save();
        if(count($request->products)) {
            Product::where('created_by', Auth::user()->id)->whereIn('product_row_id', $request->products)->update(["collection_row_id" => $collection->collection_row_id]);
        }

        return redirect('/manage-collection');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Respoase
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
      
        $data['dynamic_fields'] = DB::table('product_dynamic_fields As df')
            ->join('products As p', 'df.product_row_id', '=', 'p.product_row_id')
            ->select('df.dynamic_field_row_id', 'df.field_name')
            ->where('p.created_by',  Auth::user()->id)
            ->orderBy('df.dynamic_field_row_id')
            ->get();
      

        return view('collection.collection_create', [
            "data" => Collection::where([
                'created_by' => Auth::user()->id,
                'collection_row_id' => $id,
            ])->first(),
            "products" => Product::where('created_by', Auth::user()->id)->where("collection_row_id", $id)->get(),
            
        ]);
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
        $collection_model = new \App\Models\Collection;
        $collection_model = $collection_model::where('created_by', Auth::user()->id)->find($id);
        $collection_model->delete();

        Session::flash('success-message', "Collection has been deleted successfully.");
        return Redirect::to('/manage-collection');
    }
}
