<?php
    namespace app\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use App\Classes\OrderDeskApiClientClass;
    use App\Library\CommonLib;

    class OrderDeskApiController extends Controller {
        
        public function orderDeskProductSubmit() {
            
            // Fetch all userids from AccountOrderDesk table
            $allOdeskAccount = \App\Models\AccountOrderdesk::where('order_served_status', 0)->orderBy('user_id', 'asc')->take(1)->first();

            if(!empty($allOdeskAccount)) {
                $proinfo = \App\Models\Product::where([ ['created_by', $allOdeskAccount->user_id], ['in_orderdesk', 0] ])->skip(0)->take(200)->get()->toArray();
            
                foreach ($proinfo as $pinfo) {
                    if(isset($pinfo['vendor_row_id']) && ($pinfo['vendor_row_id'] > 0)) {
                        $location = \App\Models\Vendor::where('vendor_row_id', $pinfo['vendor_row_id'])->value('vendor_name');
                    } else {
                        $location = '';
                    }

                    //$obCommonLib = new CommonLib();
                   // $userid = Auth::user()->id;
                    //$orderdeskDetails = $obCommonLib->getOrderDeskAccountByUser($userid);
                    $orderdesk = new OrderDeskApiClientClass($allOdeskAccount->store_id, $allOdeskAccount->api_key);
                    $metaarray = array();
                    $dynamicFieldsArray = array();

                    $metaarray['print_sku'] = $pinfo['vendor_sku'];
                    $metaarray['print_url_1'] = $pinfo['production_art_url_1'];
                    $metaarray['print_url_2'] = $pinfo['production_art_url_2'];
                    $metaarray['print_location_1'] = $pinfo['print_location'];
                    $metaarray['print_location_2'] = $pinfo['print_location2'];
                    $metaarray['print_mode'] = $pinfo['print_mode'];

                    $dynamicFieldsArray = json_decode($pinfo['product_dynamic_fields'], 1);
                    
                    $metadata = array_merge($metaarray, $dynamicFieldsArray); 
                    //dd($metadata);

                    $args = array(
                      "name"    => $pinfo['product_name'],
                      "code"    => $pinfo['product_sku'],
                      "price"   => $pinfo['product_price'],
                      "cost"    => $pinfo['product_price'],
                      "weight"  => $pinfo['product_weight'],
                      "stock"   => $pinfo['product_stock'],
                      "location" => $location,
                      "metadata" => $metadata
                    );

                    $result = $orderdesk->post("inventory-items", $args);

                    if($result['status'] == 'success') {
                        \App\Models\Product::where('product_row_id', $pinfo['product_row_id'])->update(['in_orderdesk' => 1]);
                    }
                }

                \App\Models\AccountOrderdesk::where('user_id', $allOdeskAccount->user_id)->update(['order_served_status' => 1]);
            } else {
                $countAllAccount = \App\Models\AccountOrderdesk::count();
                $accountByStatus = \App\Models\AccountOrderdesk::where('order_served_status', 1)->count();

                if($countAllAccount == $accountByStatus) {
                    \App\Models\AccountOrderdesk::where('order_served_status', 1)->update(['order_served_status' => 0]);
                }

            }
        
        }

    }