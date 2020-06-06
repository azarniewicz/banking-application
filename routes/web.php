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
    Route::get('/', 'HomeController@index');

    Route::get('/start', 'KlientController@index');

    Route::get('/przelew', 'TransakcjaController@index');

    Route::post('/przelew', 'TransakcjaController@store');

    Route::get('/historia', function () {
        return view('uzytkownik/historia');
    });
    Route::get('/staliodbiorcy', function () {
        return view('uzytkownik/staliodbiorcy');
    });
    Route::get('/planowanetransakcje', function () {
        return view('uzytkownik/planowanetransakcje');
    });
    Route::get('/kredyty', function () {
        return view('uzytkownik/kredyty');
    });
    Route::get('/mojedane', function () {
        return view('uzytkownik/mojedane');
    });
    Route::get('/raty', function () {
        return view('uzytkownik/raty');
    });
    Route::get('/ustawienia', function () {
        return view('uzytkownik/ustawienia');
    });


    Route::post('/wyloguj','\App\Http\Controllers\Auth\LoginController@wyloguj');



});


Route::group([
    'middleware'=>'auth:administrator'
],function(){
    Route::get('/adminpanel','AdministratorController@index');
    Route::post('/user','UserController@store');
});

