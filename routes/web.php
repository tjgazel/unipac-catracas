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

Route::name('catracas.relatorios.alunos')->get('catracas/relatorios/alunos', 'CatracasRelatorioController@alunos');
Route::name('catracas.relatorios.acessos')->get('catracas/relatorios/acessos', 'CatracasRelatorioController@acessos');
Route::name('catracas.relatorios.index2')->get('catracas/relatorios/index', 'CatracasRelatorioController@index2');
Route::name('catracas.relatorios.index')->get('catracas/relatorios', 'CatracasRelatorioController@index');

Route::resource('catracas', 'CatracasController')->only(['index', 'show']);
