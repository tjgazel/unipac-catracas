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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::redirect('/', 'catracas/relatorios', 302);

Route::name('catracas')->resource('catracas/relatorios', 'CatracasRelatorioController')->only(['index', 'show']);
Route::resource('catracas', 'CatracasController')->only(['index', 'show']);

/*Route::name('calendarios.add-marcador')->post('calendarios/add-marcador', 'CalendarioController@addMarcador');
Route::resource('calendarios', 'CalendarioController');
Route::resource('marcadores', 'MarcadorController');*/
