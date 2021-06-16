<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

use App\Models\Category;
use App\Models\Article;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::all();
        return view('Panel.Category.Index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $isExist=Category::whereSlug(str::slug($request->category))->first();
        if($isExist){
            toastr()->error('Zaten '.$request->category.' adında bir kategori bulunuyor!');
            return redirect()->back();
        }
        $category = new Category;
        $category->name=$request->category;
        $category->slug=str::slug($request->category);
        $category->save();
        toastr()->success('Başarıyla Yeni Bir Kategori Oluşturuldu!');
        return redirect()->back();
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $isExist=Category::whereSlug(str::slug($request->category))->whereNotIn('id',[$request->id])->first();
        if($isExist){
            toastr()->error('Zaten '.$request->category.' adında bir kategori bulunuyor!');
            return redirect()->back();
        }
        $category = Category::find($request->id);
        $category->name=$request->category;
        $category->slug=str::slug($request->category);
        $category->save();
        toastr()->success('Başarıyla Bir Kategori Güncellendi!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function getData(Request $request)
    {
        $category=Category::findOrFail($request->id);
        return Response()->json($category);
    }

    /**
    *
    */

    public function delete(Request $request)
    {
        $category=Category::findOrFail($request->id);
        if($category->id==1){
            toastr()->error('Bu kategori silinemez!');
            return redirect()->back();
        }
        $message='';
        $count=$category->articleCount();
        if ($count>0) {
            Article::where('category_id',$category->id)->update(['category_id'=>1]);
            $defaultCategory=Category::find(1);
            $message='Bu kategoriye ait '.$count.' tane haberiniz '.$defaultCategory->name.' kategorisine taşındı.';
        }
        $category->delete();
        toastr()->success($message,'Kategori Başarıyla Silindi.');
        return redirect()->back();
    }
}
