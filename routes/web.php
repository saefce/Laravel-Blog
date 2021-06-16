<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\PublicationController;
use App\Http\Controllers\Web\NewsController;
use App\Http\Controllers\Web\TeamMemberController;
/* */
use App\Http\Controllers\Panel\TeamController;
use App\Http\Controllers\Panel\MailboxController;
use App\Http\Controllers\Panel\SettingsController;
use App\Http\Controllers\Panel\PageController;
use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Panel\ArticleController;
use App\Http\Controllers\Panel\BlogController;
use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\UserController;
use App\Http\Controllers\Panel\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[HomeController::class,'index'])->name('web.index');
Route::get('/hakkimizda',[HomeController::class,'hakkimizda'])->name('web.hakkimizda');
Route::get('/iletisim',[HomeController::class,'contact'])->name('web.iletisim');
Route::post('/gonder',[HomeController::class,'contactpost'])->name('web.contactpost');
Route::get('/basinda-biz',[HomeController::class,'basindabiz'])->name('web.basindabiz');
Route::get('/panel/login',[LoginController::class,'login'])->name('panel.login');

Route::resource('/panel/haberbulteni', ArticleController::class);

Route::post('/login',[LoginController::class,'auth'])->name('panel.auth');

/* Ekibimiz Kişiler */
Route::group(['as'=>'web.ekibimiz.'],function(){
		
		Route::get('/muratoruc',[TeamMemberController::class,'muratOruc'])->name('muratOruc');
		Route::get('/dogan-ugur',[TeamMemberController::class,'doganUgur'])->name('doganUgur');
		Route::get('/sena-nur-tekin',[TeamMemberController::class,'senaNurTekin'])->name('senaNurTekin');
		Route::get('/sanem-nakis',[TeamMemberController::class,'sanemNakis'])->name('sanemNakis');
		Route::get('/halit-fikir',[TeamMemberController::class,'halitFikir'])->name('halitFikir');
		Route::get('/nuri-berkay-ozgenc',[TeamMemberController::class,'nuriBerkayOzgenc'])->name('nuriBerkayOzgenc');
		Route::get('/ramazan-durgut',[TeamMemberController::class,'ramazanDurgut'])->name('ramazanDurgut');

	});
/* Ekibimiz Kişiler */

/* Yayınlar */
Route::group(['as'=>'web.yayinlar.','prefix'=>'/yayinlar'],function(){
		
		Route::get('/kitaplar',[PublicationController::class,'kitaplar'])->name('kitaplar');
		Route::get('/makaleler',[PublicationController::class,'makaleler'])->name('makaleler');
		Route::get('/tebigler',[PublicationController::class,'tebligler'])->name('tebligler');

	});
/* Yayınlar */

/* Panel */
Route::group(['as'=>'panel.','prefix'=>'/panel','middleware'=>'auth'],function(){

	Route::get('/',[DashboardController::class,'index'])->name('index');
	Route::get('/home',[DashboardController::class,'home'])->name('home.index');
  Route::get('/logout',[LoginController::class,'logout'])->name('logout');
  Route::get('/haber-bulteni/silinenler',[ArticleController::class,'trashed'])->name('trashed.article');
  Route::resource('/haberbulteni', ArticleController::class);
  Route::get('/switcharticle', [ArticleController::class,'switch'])->name('switch.article');
  Route::get('/deletearticle/{id}',[ArticleController::class,'delete'])->name('delete.article');
  Route::get('/destroyarticle/{id}',[ArticleController::class,'silmek'])->name('destroy.article');
  Route::get('/recoverarticle/{id}',[ArticleController::class,'yenidena'])->name('recover.article');

	Route::group(['as'=>'category.','prefix'=>'/category'],function(){

		Route::resource('/', CategoryController::class);
		Route::post('/delete',[CategoryController::class,'delete'])->name('delete');
		Route::post('/update',[CategoryController::class,'update'])->name('update');
		Route::get('getData',[CategoryController::class,'getData'])->name('getdata');

	});

	Route::group(['as'=>'pages.','prefix'=>'/pages'],function(){
		Route::resource('/', PageController::class);
		Route::get('/guncelle/{id}',[PageController::class,'edit'])->name('edit');
		Route::post('/guncelle/{id}',[PageController::class,'update'])->name('update');
		Route::get('/switch', [PageController::class,'switch'])->name('switch');
		Route::get('/sil/{id}',[PageController::class,'delete'])->name('delete');
		Route::get('/siralama',[PageController::class,'orders'])->name('orders');
	});

	Route::group(['prefix' => 'laravel-filemanager'], function () {
     \UniSharp\LaravelFilemanager\Lfm::routes();
 });

	Route::group(['as'=>'user.','prefix'=>'/user'],function(){

		Route::resource('/', UserController::class);
		Route::get('/deleteuser/{id}',[UserController::class,'destroy'])->name('delete.user');
	});

	Route::group(['as'=>'settings.','prefix'=>'/settings'],function(){
		Route::resource('/', SettingsController::class);
		Route::post('/update', [SettingsController::class, 'update'])->name('update');
	});
	Route::group(['as'=>'mailbox.','prefix'=>'/posta'],function(){
		Route::resource('/', MailboxController::class);
	});
	Route::group(['as'=>'team.','prefix'=>'/ekibimiz'],function(){
		Route::resource('/', TeamController::class);
	});

});
/* Panel */

/* Blog */
Route::group(['as'=>'web.news.','prefix'=>'/haberbulteni'],function(){

	Route::get('/',[NewsController::class,'index'])->name('index');
	Route::get('/sayfa',[NewsController::class,'index']);
	Route::get('/{category}/{slug}',[NewsController::class,'single'])->name('single');
	Route::get('/{category}',[NewsController::class,'category'])->name('category');
	
});
/* Blog */

/* fonksiyonel sayfalar */

Route::get('/sayfalar/{sayfa}',[HomeController::class,'page'])->name('web.page');

/* fonksiyonel sayfalar */