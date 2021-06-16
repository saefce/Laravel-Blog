<?php

namespace App\Http\Controllers\Panel\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

  public function login(){

  	if(Auth::check()){
  		return redirect()->route('panel.index');
  	}else{
  		return view('Panel.Auth.Login');
  	}

  }

  public function auth(Request $request){

  	$kimlik = $request->only('email','password');

  		if(Auth::attempt($kimlik)){
  			$request->session()->regenerate();
        toastr()->success('Tekrardan Hoşgeldin! '.Auth::user()->name);
  			return redirect()->route('panel.index');

  		}else
  		{
  		return redirect()->route('panel.login');
  		}
  }
  public function logout(Request $request){
  	
  	Auth::logout();

  	return redirect()->route('panel.login');
  }

}