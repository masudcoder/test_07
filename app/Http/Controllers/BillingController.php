<?php
    namespace app\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;

    class BillingController extends Controller {
        public function form(Request $request) {
            return view('billing');
        }

        public function process(Request $request) {
            if($request->stripeToken) {
                try {
                    Auth::user()->newSubscription('main', 'monthly')->create($request->stripeToken);
                    Session::flash('success-message', 'You have successfully started your subscription.');
                } catch(\Exception $e) {
                    Session::flash('error-message', $e->getJsonBody()["error"]["message"]);
                }
                return back();
            }
        }
    }