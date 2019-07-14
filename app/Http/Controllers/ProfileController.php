<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Session;
use Hash;
class ProfileController extends Controller
{
    public function index()
    {
		$data['user'] = Auth::user();	
		return view('auth.my_profile', ['data'=>$data]);
    }

	public function updateProfile(Request $request)
    { 
	    $user = \App\User::find(Auth::user()->id);
		$user->name = $request->name;
		$user->company_name = $request->company_name;
		$user->phone = $request->phone;
		$user->save();						
		Session::flash('success-message', 'Profile has been updated successfully.'); 
		return redirect('/my-profile');
		
    }
	
	public function changePassword()
    {
		$data['user'] = Auth::user();
		return view('auth.change_password', ['data'=>$data]);
    }
	
	public function updatePassword(Request $request)
    {
	    //validation
		
		
		if( !$request->current_password  || !$request->new_password || !$request->confirm_new_password)
		{
		   Session::flash('error-message', 'Fill up all the fields.'); 
		   return redirect('/change-password');				  
		}
		
		if($request->new_password != $request->confirm_new_password)
		{
		   Session::flash('error-message', 'Password and confirm password does not match.'); 
		   return redirect('/change-password');				  
		}		
	
		if(! Hash::check($request->current_password, Auth::user()->password) )
		{
		   Session::flash('error-message', 'Invalid current password.'); 
		   return redirect('/change-password');				  
		}				
				
		$user = \App\User::find(Auth::user()->id);		
		$user->password = Hash::make($request->new_password);		
		$user->save();		
		
		Session::flash('success-message', 'Password has been changed successfully.'); 
		return redirect('/change-password');	
    }
   
}
