<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles=Article::orderBy('created_at','ASC')->get();
        return view('Panel.Blog.Index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        return view('Panel.Blog.Create',compact('categories'));
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
            'title'=>'min:3',
            'image'=>'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $article=new Article;
        $article->title=$request->title;
        $article->category_id=$request->category;
        $article->content=$request->content;
        $article->slug=Str::slug($request->title);

        if(request()->hasFile('image')){
            $random = Str::random(5);
            $gorsel = request()->image;
            $dosyadi =  Str::slug($article->name) . "-" . $random . "." . $gorsel->extension();

            if($gorsel->isValid()){
                $gorsel->move('uploads/article/images', $dosyadi);
                $article->image = "/uploads/article/images/".$dosyadi;
            }
        }
        $article->save();
        toastr()->success('Başarıyla Yeni Bir Haber Oluşturuldu!');
        return redirect()->route('panel.haberbulteni.index');
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
        $article=Article::findOrFail($id);
        $categories=Category::all();
        return view('panel.blog.update',compact('categories','article'));
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

        $article=Article::findOrFail($id);
        $article->title=$request->title;
        $article->category_id=$request->category;
        $article->content=$request->content;
        $article->slug=str::slug($request->title);

        if(request()->hasFile('image')){
            $random = Str::random(5);
            $gorsel = request()->image;
            $dosyadi =  Str::slug($article->name) . "-" . $random . "." . $gorsel->extension();

            if($gorsel->isValid()){
                $gorsel->move('uploads/article/images', $dosyadi);
                $article->image = "/uploads/article/images/".$dosyadi;
            }
        }
        $article->save();
        toastr()->success('Başarıyla Bir Haber Güncellendi!');
        return redirect()->route('panel.haberbulteni.index');
    }

    /**
    * Switch
    */

    public function switch (Request $request) {
        $article=Article::findOrFail($request->id);
        $article->status=$request->statu=="true" ? 1 : 0 ;
        $article->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete($id)
    {
        Article::find($id)->delete();
        toastr()->success('Başarıyla Haberi Sildiniz!');
        return redirect()->route('panel.haberbulteni.index');
    }

    /**
    * 
    */

    public function trashed()
    {
        
        $articles=Article::onlyTrashed()->orderBy('deleted_at','DESC')->get();
        return view('Panel.Blog.Trashed',compact('articles'));
    }

    /**
    * 
    */

    public function silmek($id)
    {
        $article=Article::onlyTrashed()->find($id);
        $article->forceDelete();
        toastr()->success('Başarıyla Haberi Sildiniz!');
        return redirect()->route('panel.haberbulteni.index');
    }

    /**
    * 
    */

    public function yenidena($id)
    {
        $article=Article::onlyTrashed()->find($id);
        $article->restore();
        toastr()->success('Başarıyla Haberi Kurtardınız!');
        return redirect()->back();
    }
}
