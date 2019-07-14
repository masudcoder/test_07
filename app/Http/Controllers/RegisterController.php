<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Models\Folder;
use DB;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
       do {
                $randString = $this->generateRandomString();
                $count = \App\User::where('aku_prefix', $randString)->count();
            } while($count);
        
        $user = User::create([
         'name' => $data['name'],
         'email' => $data['email'],
         'phone' => $data['phone'],
         'company_name' => $data['company_name'],
         'aku_prefix' => $randString,			
         'password' => bcrypt($data['password']),
        ]);

        DB::table('users')->where('id', $user->id)->update([
                'api_key' => md5($user->id),
            ]);
		
		$folderDefaultData = [
						['folder_name' => 'New', 'created_by' => $user->id],
						['folder_name' => 'Favorite', 'created_by' => $user->id],
						['folder_name' => 'Archived', 'created_by' => $user->id],
						['folder_name' => 'To Review', 'created_by' => $user->id],
						['folder_name' => 'Best Sellers', 'created_by' => $user->id],
						['folder_name' => 'Trending', 'created_by' => $user->id],
		];		
		DB::table('folders')->insert($folderDefaultData);	
		
		$customerGroupDefaultData = [
						['customer_group_name' => 'Distributor', 'created_by' => $user->id],
						['customer_group_name' => 'Wholesale', 'created_by' => $user->id],
						['customer_group_name' => 'Retail', 'created_by' => $user->id],
		];		
		DB::table('customer_groups')->insert($customerGroupDefaultData);	
		
		
		return $user;
		
		
    }

    function generateRandomString($length = 5) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    
    return strtoupper($randomString);
   }

}
