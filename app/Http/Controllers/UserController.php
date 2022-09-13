<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

class UserController extends Controller
{
    public function index(){
    	return view('auth.login');
    }


    public function register(){
    	return view('auth.register');
    }

    public function forgot(){
    	return view('auth.forgot');
    }

    public function reset(){
    	return view('auth.reset');
    }

//handle register user ajax request

    public function saveUser(Request $request){
    	$validator = Validator::make($request->all(),[

    	'name'=>'required|max:50',
    	'email'=>'required|email|unique:users|max:100',
    	'password'=>'required|min:6|max:50',
    	'cpassword'=>'required|min:6|same:password'

    	], [

    		'cpassword.same'=>'Password did not matched!',
    		'cpassword.required'=>'confirm password is required!'
    	]

    );
    	if($validator->fails()){
    		return response()->json([
    			'status'=>400,
    			'messages'=>$validator->getMessageBag()
            ]);
    	}else{
    		$user =new User();
    		$user->name =$request->name;
    		$user->email =$request->email;
    		$user->password = Hash::make($request->password);
    		$user->save();
    		return response()->json([
    			'status'=>200,
    			'messages'=>'Registered Successfully!'
    		]);
    	}

    }


}


