<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        view()->share('settings',Setting::find(1));

        Route::resourceVerbs([
            'create'=>'olustur',
            'edit'=>'guncelle',
        ]);

        setlocale(LC_TIME, 'tr_TR.utf8');
    }
}
