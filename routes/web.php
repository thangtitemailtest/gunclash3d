<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*API*/
Route::post('servicelogin', 'ApiController@getServicelogin')->name('get-servicelogin');
Route::post('serviceupdatemyinfo', 'ApiController@getServiceupdatemyinfo')->name('get-serviceupdatemyinfo');
Route::post('servicegetmytowerinfo', 'ApiController@getServicegetmytowerinfo')->name('get-servicegetmytowerinfo');
Route::post('servicegetotherplayer', 'ApiController@getServicegetotherplayer')->name('get-servicegetotherplayer');
Route::post('serviceupdateotherplayertower', 'ApiController@getServiceupdateotherplayertower')->name('get-serviceupdateotherplayertower');
Route::post('savelogs', 'ApiController@getSavelogs')->name('get-savelogs');
Route::post('servicegcmid', 'ApiController@getServicegcmid')->name('get-servicegcmid');

Route::get('updateconfig', 'ApiController@updateConfig')->name('updateconfig');

Route::post('test', 'ApiController@test')->name('get-test');
/*END API*/

/*API Gun2*/
Route::group(['prefix' => 'gun2'], function () {
	Route::post('servicelogin', 'ApiController_2@getServicelogin')->name('get-servicelogin_2');
	Route::post('serviceupdatemyinfo', 'ApiController_2@getServiceupdatemyinfo')->name('get-serviceupdatemyinfo_2');
	Route::post('servicegetmytowerinfo', 'ApiController_2@getServicegetmytowerinfo')->name('get-servicegetmytowerinfo_2');
	Route::post('servicegetotherplayer', 'ApiController_2@getServicegetotherplayer')->name('get-servicegetotherplayer_2');
	Route::post('serviceupdateotherplayertower', 'ApiController_2@getServiceupdateotherplayertower')->name('get-serviceupdateotherplayertower_2');
	Route::post('savelogs', 'ApiController_2@getSavelogs')->name('get-savelogs_2');
	Route::post('servicegcmid', 'ApiController_2@getServicegcmid')->name('get-servicegcmid_2');

	Route::post('test', 'ApiController_2@test')->name('get-test_2');
});
/*END API Gun2*/

Route::get('/login', 'HomeController@getLogin')->name('get-login');
Route::post('/login-post', 'HomeController@postLogin')->name('post-login');
Route::get('/logout', 'HomeController@logout')->name('get-logout');
Route::post('/thaydoithongtin-post', 'HomeController@postThaydoithongtin')->name('post-thaydoithongtin');
Route::post('/themmoiuser-post', 'HomeController@postThemmoiuser')->name('post-themmoiuser');
Route::post('/phanquyenuser-post', 'HomeController@postPhanquyenuser')->name('post-phanquyenuser');

Route::get('/khongcoquyentruycap', 'HomeController@getKhongcoquyen')->name('get-khongcoquyen');
Route::get('/thaydoithongtin', 'HomeController@getThaydoithongtin')->name('get-thaydoithongtin');

Route::middleware('Checklogin')->group(function () {
	Route::get('/', 'HomeController@getIndex')->name('get-index');

	Route::get('/danhsachuser', 'HomeController@getDanhsachuser')->name('get-danhsachuser');
	Route::get('/themmoiuser', 'HomeController@getThemmoiuser')->name('get-themmoiuser');
	Route::get('/xoauser/{id}', 'HomeController@getXoauser')->name('get-xoauser');
	Route::get('/resetpassword/{id}', 'HomeController@getResetpassword')->name('get-resetpassword');

	Route::get('/phanquyenuser/{id}', 'HomeController@getPhanquyenuser')->name('get-phanquyenuser');


	/*Report*/
	Route::group(['prefix' => 'report'], function () {
		//Route::get('/', 'chartController@index')->name('get.report');
		Route::get('/userconlaisaulevel', 'ReportController@getUserconlaisaulevel')->name('get-userconlaisaulevel');
		Route::get('/sotiencuausertheolevel', 'ReportController@getSotiencuausertheolevel')->name('get-sotiencuausertheolevel');
		Route::get('/levelusermuainapp', 'ReportController@getLevelusermuainapp')->name('get-levelusermuainapp');
		Route::get('/locsonguoichoistart', 'ReportController@getLocsonguoichoistart')->name('get-locsonguoichoistart');
		Route::get('/locsonguoichoipass', 'ReportController@getLocsonguoichoipass')->name('get-locsonguoichoipass');
		Route::get('/locsonguoichoilose', 'ReportController@getLocsonguoichoilose')->name('get-locsonguoichoilose');
		Route::get('/locsotiennguoichoipass', 'ReportController@getLocsotiennguoichoipass')->name('get-locsotiennguoichoipass');
		Route::get('/locsotiennguoichoilose', 'ReportController@getLocsotiennguoichoilose')->name('get-locsotiennguoichoilose');
		//Route::get('/locsonguoiupgradebulletlevel', 'ReportController@getLocsonguoiupgradebulletlevel')->name('get-locsonguoiupgradebulletlevel');
		//Route::get('/locsonguoiupgradebulletpower', 'ReportController@getLocsonguoiupgradebulletpower')->name('get-locsonguoiupgradebulletpower');
		Route::get('/quocgiacosologinnhieunhat', 'ReportController@getQuocgiacosologinnhieunhat')->name('get-quocgiacosologinnhieunhat');
		//Route::get('/locsonguoichoigamelandau', 'ReportController@getLocsonguoichoigamelandau')->name('get-locsonguoichoigamelandau');
		Route::get('/logevent', 'ReportController@getLogevent')->name('get-logevent');
	});
	/*END Report*/
});

/*Test*/
Route::get('/test1', 'ReportController@test1')->name('get-test1');
Route::get('/test2', 'ReportController@test2')->name('get-test2');
Route::get('/test3', 'ReportController@test3')->name('get-test3');
/*END Test*/

Route::get('/sendnoti', 'Notification@sendNotiTest')->name('get-sendnoti');

//Auth::routes();