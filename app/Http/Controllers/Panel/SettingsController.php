<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setting;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings=Setting::find(1);
        return view('Panel.Setting.Index', compact('settings'));
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
        $setting=Setting::find(1);
        $setting->title     = $request->title;
        $setting->active    = $request->active;
        $setting->instagram = $request->instagram;
        $setting->youtube   = $request->youtube;
        $setting->twitter   = $request->twitter;

        if($request->hasFile('logo')){
            $logo='logo'.$request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('uploads/images'),$logo);
            $setting->logo='uploads/images/'.$logo;
        }
        if($request->hasFile('favicon')){
            $favicon='favicon'.$request->favicon->getClientOriginalExtension();
            $request->favicon->move(public_path('uploads/images'),$favicon);
            $setting->favicon='uploads/images/'.$favicon;
        }
        $setting->save();
        toastr()->success('Başarıyla ayarlar güncellendi!');
        return redirect()->back();
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
}
