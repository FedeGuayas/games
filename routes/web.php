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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::middleware('auth')->prefix('/app')->group(function () {

    Route::get('loadathletes', function () {
        return view('athletes.load');
    });


    Route::get('/credenciales/athletes','AthleteController@printAthletes')->name('print_athletes');
    Route::get('/credenciales/get','AthleteController@getCredencials')->name('getCredencials');

    Route::get('/reportes/credenciales/export','AthleteController@exportCredenciales')->name('export-credenciales');

    Route::get('/athletes/get','AthleteController@getAllAthletes')->name('getAllAthletes');

    Route::post('/athletes/admin/import','AthleteController@importAthletes')->name('import');

    Route::resource('athletes', 'AthleteController',['except'=>['show']]);





});