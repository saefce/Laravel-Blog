<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use File;

use App\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages=Page::orderBy('created_at','ASC')->get();
        return view('Panel.Pages.Index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages=Page::all();
        return view('Panel.Pages.Create', compact('pages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image'=>'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $last=Page::orderBy('order','desc')->first();

        $page=new Page;
        $page->title=$request->title;
        $page->content=$request->content;
        $page->order=$last->order+1;
        $page->slug=Str::slug($request->slug);

        if(request()->hasFile('image')){
            $random = Str::random(5);
            $gorsel = request()->image;
            $dosyadi =  Str::slug($page->name) . "-" . $random . "." . $gorsel->extension();

            if($gorsel->isValid()){
                $gorsel->move('uploads/page/images', $dosyadi);
                $page->image = "/uploads/page/images/".$dosyadi;
            }
        }
        $page->save();
        toastr()->success('Başarıyla Yeni Bir Sayfa Oluşturuldu!');
        return redirect()->route('panel.pages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page=Page::findOrFail($id);
        $pages=Page::all();
        return view('Panel.Pages.Update', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>'min:3',
            'image'=>'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $page=Page::findOrFail($id);
        $page->title=$request->title;
        $page->content=$request->content;
        $page->slug=Str::slug($request->title);

        if(request()->hasFile('image')){
            $random = Str::random(5);
            $gorsel = request()->image;
            $dosyadi =  Str::slug($page->name) . "-" . $random . "." . $gorsel->extension();

            if($gorsel->isValid()){
                $gorsel->move('uploads/page/images', $dosyadi);
                $page->image = "/uploads/page/images/".$dosyadi;
            }
        }

        $page->save();
        toastr()->success('Başarıyla Bir Sayfa Güncellendi!');
        return redirect()->route('panel.pages.index');
    }

    /**
    * Switch
    */

    public function switch (Request $request) {
        $page=Page::findOrFail($request->id);
        $page->status=$request->statu=="true" ? 1 : 0 ;
        $page->save();
    }

    /**
    *
    */

    public function delete($id)
    {
        $page=Page::find($id);
        if(File::exists($page->image)){
           File::delete(public_path('uploads/images'),$page->image);
        }
        $page->delete();
        toastr()->success('Başarıyla Sayfayı Sildiniz!');
        return redirect()->route('panel.pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
    *
    */

    public function orders(Request $request){
        foreach($request->get('page') as $key => $order){
            Page::where('id',$order)->update(['order' => $key]);
        }
    }
}
