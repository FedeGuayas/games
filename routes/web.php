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


    Route::get('credenciales/athletes','AthleteController@printAthletes')->name('print_athletes');
    Route::get('credenciales/get','AthleteController@getCredencials')->name('getCredencials');

    Route::get('reportes/credenciales/export','AthleteController@exportCredenciales')->name('export-credenciales');

    Route::get('athletes/get','AthleteController@getAllAthletes')->name('getAllAthletes');

    Route::get('athletes/getImport','AthleteController@getImport')->name('getImport');
    Route::post('athletes/import','AthleteController@importAthletes')->name('import');

    Route::get('athletes/getAcreditar','AthleteController@indexAcreditar')->name('indexAcreditar');
    Route::get('athletes/getAllAcreditar','AthleteController@getAllAcreditar')->name('getAllAcreditar');
    Route::post('athletes/acreditar{athletes?}','AthleteController@acreditar')->name('acreditar');

    Route::get('athletes/getAcreditados','AthleteController@indexAcreditados')->name('indexAcreditados');
    Route::get('athletes/getAllAcreditados','AthleteController@getAllAcreditados')->name('getAllAcreditados');

    Route::get('events/provincia/deportes/countAtletas','EventController@countAtletas')->name('events.countAtletas');
    Route::get('events/provincia/deportes/getAtletas','EventController@loadAtletas')->name('events.loadAtletas');

    Route::get('events/comandas/create','EventController@createComanda')->name('events.createComanda');
    Route::get('events/comandas/getPersons','EventController@listPersonasComandas')->name('events.listPersonasComandas');
    Route::get('events/comandas/exportPDF','ReportesController@comandaPDF')->name('comandasPDF');

    Route::resource('athletes', 'AthleteController',['except'=>['show']]);
    Route::resource('residencias', 'ResidenciaController',['except'=>['show']]);
    Route::resource('events', 'EventController');







});