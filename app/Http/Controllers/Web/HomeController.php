<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\NewsController;

use Illuminate\Support\Facades\Validator;

 // Models
use App\Models\Category;
use App\Models\Article;
use App\Models\Page;
use App\Models\Contact;
use App\Models\Setting;

class HomeController extends Controller
{
    public function __construct(){
        view()->share('pages',Page::orderBy('order','ASC')->get());
        view()->share('categories',Category::inRandomOrder()->get());
    }

    public function index(){
        $data['articles']=Article::orderBy('created_at','DESC')->paginate(2);
        $data['articles']->withPath(url('haberbulteni/sayfa'));
        return view('Web.Index',$data);

    }

    public function page($slug){
        $page=Page::whereSlug($slug)->first() ?? abort(403,'Böyle bir yazı bulunamadı.');
        $data['page']=$page;
        return view('Web.Layouts.Page',$data);
    }

    // *
    // *
    // *

    public function contact(){
        return view('Web.Layouts.Iletisim');
    }

    public function contactpost(Request $request){

        $rules=['name'=>'required|min:2',
                'email'=>'required|email',
                'topic'=>'required',
                'message'=>'required|min:10'];

        $validate=Validator::make($request->post(),$rules);

        if($validate->fails()){
            return redirect()->route('web.iletisim')->withErrors($validate)->withInput();
        }

        $contact = new contact;
        $contact->name=$request->name;
        $contact->email=$request->email;
        $contact->topic=$request->topic;
        $contact->message=$request->message;
        $contact->save();
        return redirect()->route('web.iletisim')->with('success','Mesajınız bize iletildi. Teşekkür Ederiz.');
    }

    /* public function hakkimizda()
    {
      return view('Web.Layouts.hakkimizda');

    } */

    public function basindabiz(){
        return view('Web.Layouts.BasindaBiz');
    }

    public function hakkimizda(){
        return view('Web.Layouts.Hakkimizda');
    }

}
