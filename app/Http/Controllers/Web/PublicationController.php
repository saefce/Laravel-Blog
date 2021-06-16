<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Page;
use App\Models\Setting;

class PublicationController extends Controller
{
    public function Kitaplar(){
    	$pages=Page::get();
      return view('Web.Layouts.Yayınlar.Kitaplar', compact('pages'));
    }

    public function Makaleler(){
      $pages=Page::get();
      return view('Web.Layouts.Yayınlar.Makaleler', compact('pages'));
    }

    public function Tebligler(){
      $pages=Page::get();
      return view('Web.Layouts.Yayınlar.Tebligler', compact('pages'));
    }

}
