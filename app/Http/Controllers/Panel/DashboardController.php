<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
	public function index(){

      return view('Panel.Index');

  }
  
  public function home(){

      return view('Panel.Home.Index');

  }

}
