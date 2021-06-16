<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::orderBy('created_at','ASC')->get();
        return view('Panel.User.Index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users=User::get();
        return view('Panel.User.Create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate(request(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'image'=>'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = User::create([
            'name'     => $request['name'],
            'email'    => $request['email'] ,
            'password' => Hash::make($request['password']),
            'image'    => $request['image']
        ]);


        if(request()->hasFile('image')){
            $random = Str::random(5);
            $gorsel = request()->image;
            $dosyadi =  Str::slug($user->name) . "-" . $random . "." . $gorsel->extension();

            if($gorsel->isValid()){
                $gorsel->move('uploads/users/images', $dosyadi);
                $user->image = "/uploads/users/images/".$dosyadi;
            }
        }
        $user->save();
        toastr()->success('Başarıyla Yeni Bir Üyelik Oluşturuldu!');
        return redirect()->route('panel.user.index');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::find($id);
        $user->forceDelete();
        toastr()->success('Başarıyla Kullanıcıyı Sildiniz!');
        return redirect()->route('panel.user.index');
    }
}
