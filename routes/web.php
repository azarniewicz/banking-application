<?php

use Illuminate\Support\Facades\Route;

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


// Route::get('/test','HomeController@test');

Auth::routes(['register'=>false]);



Route::group([
    'middleware' => 'auth'
],function(){
    Route::get('/', 'KlientController@index');

    Route::get('/przelew', function () {
        return view('przelew');
    });
    Route::get('/historia', function () {
        return view('historia');
    });
    Route::get('/staliodbiorcy', function () {
        return view('staliodbiorcy');
    });
    Route::get('/planowanetransakcje', function () {
        return view('planowanetransakcje');
    });
    Route::get('/kredyty', function () {
        return view('kredyty');
    });
    Route::get('/mojedane', function () {
        return view('mojedane');
    });
    Route::get('/raty', function () {
        return view('raty');
    });
    Route::get('/ustawienia', function () {
        return view('ustawienia');
    });
    Route::post('/wyloguj','\App\Http\Controllers\Auth\LoginController@wyloguj');

});

