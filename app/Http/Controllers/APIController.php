<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;
use App\Models\Common;
use Session;
use DB;
use Auth;
use Excel;
use Illuminate\Support\Facades\Input;
use App\Classes\OrderDeskApiClientClass;

class APIController extends Controller
{
    //
    public function __construct() {
		//$this->middleware('auth');
    }

     public function apiKey() {
    	 $data['api_key'] =  Auth::user()->api_key;
    	 return view('api_key', ['data'=>$data]);
    }

    public function provideProduct(Request $request) {
    	
    	$apiKey = $request->api_key;
    	$sku = $request->sku;

    	$userExist = \App\User::where('api_key', $apiKey)->first();

    	if(!$userExist) {
    		$info['error'] = 'error-invalid API Key';   
    		echo json_encode($info);
    		exit; 		
    	}

    	$info = \App\Models\Product::where([ ['created_by', $userExist ->id], ['product_sku', $sku] ])->first();

    	if( !$info) {    			
    			$info['error'] = 'Product not found';
    			echo json_encode($info);
    			exit;
    	}

    	unset($info['product_row_id']);
    	echo json_encode($info);
    }
	
	public function getOrderDataFromOrderDesk(Request $request) {
		echo 'Processing Order Desk Data... Importing order from order desk to merchwareapp.';
	//	$orderData = json_decode($request->orderData);
		
		$str = '{"id":"7022496","email":"enggmasud1983@gmail.com","shipping_method":"","quantity_total":1,"weight_total":0,"product_total":40,"shipping_total":0,"handling_total":0,"tax_total":0,"discount_total":0,"order_total":40,"cc_number_masked":"","cc_exp":"","processor_response":"","payment_type":"","payment_status":"Approved","processor_balance":40,"customer_id":"","email_count":"10","ip_address":"103.78.54.50","tag_color":"","source_name":"Order Desk","source_id":"adsa","fulfillment_name":"","fulfillment_id":"","tag_name":"","folder_id":26401,"date_added":"2017-04-20 16:41:20","date_updated":"2017-04-20 16:41:54","shipping":{"first_name":"Asda","last_name":"Dasdas","company":"","address1":"","address2":"","address3":"","address4":"","city":"","state":"","postal_code":"","country":"US","phone":""},"customer":{"first_name":"Asda","last_name":"Dasdas","company":"","address1":"","address2":"","city":"","state":"","postal_code":"","country":"US","phone":""},"return_address":{"title":"","name":"","company":"","address1":"","address2":"","city":"","state":"","postal_code":"","country":"","phone":""},"checkout_data":[],"order_metadata":[],"discount_list":[],"order_notes":[],"order_items":[{"id":"10698353","name":"dsfsdf","price":40,"quantity":1,"weight":0,"code":"234","delivery_type":"ship","category_code":"","fulfillment_method":"","variation_list":[],"metadata":[]}],"order_shipments":[]}';
		$order = json_decode($str, 1);
 		echo '<br>';
		die('');

		$products = $order['order_items'];
				
		DB::table('orders')->insert([
			'product_name'=>'orderdeskAPI123',		
		]);	
			
		
		//Check For Order
		if (!isset($_POST['order'])) {			
			//die('No Data Found');
		}

		//Cbeck Store ID
		//Be sure to set your store ID. Ask Order Desk support if you aren't sure what it is.
		if (!isset($_SERVER['HTTP_X_ORDER_DESK_STORE_ID']) || $_SERVER['HTTP_X_ORDER_DESK_STORE_ID'] != 4409) {
			
			//die('Unauthorized Request');
		}

		//Check the Hash (optional)
		//The API Key can be found in the Advanced Settings section. Order Desk Pro only
		if (!isset($_SERVER['HTTP_X_ORDER_DESK_HASH']) || hash_hmac('sha256', rawurldecode($_POST['order']), 'dvmmAUsT02tL93VpGuKKj5DuhgcibLEpg0LRUeKVheGqiCQY7B') != $_SERVER['HTTP_X_ORDER_DESK_HASH']) {
			
			//die('Unauthorized Request');
		}
		
		
		//Check Order Data
		DB::table('orders')->insert([
			'product_name'=>'p12',		
		]);	
		
		DB::table('orders')->insert([
			'product_name'=>$_POST['order'],		
		]);	
		/*
		{"id":"7022496","email":"enggmasud1983@gmail.com","shipping_method":"","quantity_total":1,"weight_total":0,"product_total":40,"shipping_total":0,"handling_total":0,"tax_total":0,"discount_total":0,"order_total":40,"cc_number_masked":"","cc_exp":"","processor_response":"","payment_type":"","payment_status":"Approved","processor_balance":40,"customer_id":"","email_count":"10","ip_address":"103.78.54.50","tag_color":"","source_name":"Order Desk","source_id":"adsa","fulfillment_name":"","fulfillment_id":"","tag_name":"","folder_id":26401,"date_added":"2017-04-20 16:41:20","date_updated":"2017-04-20 16:41:54","shipping":{"first_name":"Asda","last_name":"Dasdas","company":"","address1":"","address2":"","address3":"","address4":"","city":"","state":"","postal_code":"","country":"US","phone":""},"customer":{"first_name":"Asda","last_name":"Dasdas","company":"","address1":"","address2":"","city":"","state":"","postal_code":"","country":"US","phone":""},"return_address":{"title":"","name":"","company":"","address1":"","address2":"","city":"","state":"","postal_code":"","country":"","phone":""},"checkout_data":[],"order_metadata":[],"discount_list":[],"order_notes":[],"order_items":[{"id":"10698353","name":"dsfsdf","price":40,"quantity":1,"weight":0,"code":"234","delivery_type":"ship","category_code":"","fulfillment_method":"","variation_list":[],"metadata":[]}],"order_shipments":[]}
		*/
		
		$order = json_decode($_POST['order']);
		DB::table('orders')->insert([
			'product_name'=>$order,		
		]);
		
		
		$order = json_decode($_POST['order'], 1);
		//Everything Checks Out -- do your thing
		//echo "<pre>" . print_r($order, 1) . "</pre>";
		
		DB::table('orders')->insert([
			'product_name'=>$_POST['order'],		
		]);	
	

    }

    public function showAllIntegrations() {
    	return view('integrations/manage_integration');
    }

    public function orderDeskIntegration() {
    	$data['user_orderdeskdetails'] = \App\Models\AccountOrderdesk::where('user_id', Auth::user()->id)->get()->toArray();
    	//dd($data['user_orderdeskdetails']);
    	return view('integrations/orderdesk_integration', ['data'=>$data]);

    }

    public function verifyOrderdeskDetails($store_id, $api_key) {
    	$orderdesk = new OrderDeskApiClientClass($store_id, $api_key);
    	//$od = new OrderDeskApiClient($storeid, $apikey);
		$result = $orderdesk->get("test");
		//echo "<pre>" . print_r($result, 1) . "</pre>";
		return json_encode($result);
    }

    public function storeOrderDeskIntegration(Request $request) {
    	//echo "<pre>".print_r($_POST, true) . "</pre>"; exit;
    	// check if the requested storeId and userid is already exist
    	$data['account_exist'] = \App\Models\AccountOrderdesk::where('user_id', Auth::user()->id)->first();
    	//dd($data['account_exist']);

    	if(!empty($data['account_exist'])) {
    		// Update the existing OrderDesk Information
    		$account_orderdesk = \App\Models\AccountOrderdesk::find($data['account_exist']['id']);
    		$account_orderdesk->store_id = $request->store_id;
	    	$account_orderdesk->api_key = $request->api_key;
    		$account_orderdesk->updated_at = \Carbon\Carbon::now();
    		$account_orderdesk->save();
    	} else {
    		$account_orderdesk = new \App\Models\AccountOrderdesk;
	    	$account_orderdesk->user_id = Auth::user()->id;
	    	$account_orderdesk->store_id = $request->store_id;
	    	$account_orderdesk->api_key = $request->api_key;
    		$account_orderdesk->created_at = \Carbon\Carbon::now();
    		$account_orderdesk->save();
    	}

    	Session::flash('success-message', 'OrderDesk Integration with your account has been done successfuly.');
		return Redirect::to('/orderdesk-integration');
    }
    
    public function sendProducts($apiKey, $sku, $meta='') {
        
        if(! $apiKey) {
          echo 'Provide API Key'; exit;
        }

	$apiKeyExist = \App\User::where('api_key', $apiKey )->first();
	if(! $apiKeyExist) {
	  echo 'Invalid API Key'; exit;	
	} else {
	    $user_id = $apiKeyExist->id;	
	}
	
        $skuPara = explode('=', trim($sku, ','));//sku=70274PL42L,sku2
        $skuPara = $skuPara[1];//sk121,sk232
        $skuArr = explode(',', $skuPara);
        
        $skuComma = "";
        for($i=0; $i<count($skuArr); $i++) {
           $skuComma = $skuComma. ',' .     '"' .$skuArr[$i] . '"';
        }
        $skuComma =trim($skuComma, ','); //"70274PL42L","sku2"
        
        //meta
        if($meta) {
	        $metaPara = explode('=', trim($meta, ','));//sku=70274PL42L,sku2
	        $metaPara = $metaPara[1];//sk121,sk232
	        $metaArr = explode(',', $metaPara );
	        
	        $metaComma = "";
	        for($i=0; $i<count($metaArr); $i++) {
	           $metaComma = $metaComma . ',' .     '"' .$metaArr[$i] . '"';
	        }
	        $metaComma =trim($metaComma , ','); //"70274PL42L","sku2"

	        
	        $sql ="SELECT product_name, product_sku,product_price, $metaComma FROM products WHERE created_by= $user_id AND product_sku IN($skuComma)";
	        echo json_encode( DB::select($sql));
        } else{
        	$sql ="SELECT product_name, product_sku,product_price FROM products WHERE created_by= $user_id AND product_sku IN($skuComma)";
       		 echo json_encode( DB::select($sql));        
        }
        
       
	
        
    }
}
