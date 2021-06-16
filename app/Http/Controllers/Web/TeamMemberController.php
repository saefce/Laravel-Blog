<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class TeamMemberController extends Controller
{
    public function muratOruc(){
      $pages=Page::get();
      return view('Web.Layouts.Ekibimiz.Kisiler.MuratOruc', compact('pages'));
    }

    public function doganUgur(){
      $pages=Page::get();
      return view('Web.Layouts.Ekibimiz.Kisiler.DoganUgur', compact('pages'));
    }

    public function senaNurTekin(){
      $pages=Page::get();
      return view('Web.Layouts.Ekibimiz.Kisiler.SenaNurTekin', compact('pages'));
    }

    public function sanemNakis(){
      $pages=Page::get();
      return view('Web.Layouts.Ekibimiz.Kisiler.SanemNakis', compact('pages'));
    }

    public function halitFikir(){
      $pages=Page::get();
      return view('Web.Layouts.Ekibimiz.Kisiler.HalitFikir', compact('pages'));
    }

    public function nuriBerkayOzgenc(){
      $pages=Page::get();
      return view('Web.Layouts.Ekibimiz.Kisiler.NuriBerkayOzgenc', compact('pages'));
    }

    public function ramazanDurgut(){
      $pages=Page::get();
      return view('Web.Layouts.Ekibimiz.Kisiler.RamazanDurgut', compact('pages'));
    }
}