<?php

Route::redirect('/', 'catracas', 302);
Route::redirect('/home', 'catracas', 302);

Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::name('login')->post('/login', 'Auth\LoginController@login');


Route::middleware(['auth'])->group(function () {
    Route::name('logout')->post('/logout', 'Auth\LoginController@logout');

    Route::resource('gerenciar-usuarios', 'Auth\GerenciarUsuariosController')->except(['show']);

    /*Route::name('catracas.relatorios.alunos')->get('catracas/relatorios/alunos', 'CatracasRelatorioController@alunos');
    Route::name('catracas.relatorios.acessos')->get('catracas/relatorios/acessos','CatracasRelatorioController@acessos');*/
    Route::name('catracas.relatorios.index')->get('catracas/relatorios', 'CatracasRelatorioController@index');

    Route::name('catracas.relatorios')->resource('catracas/relatorios/ligacoes', 'LigacoesController');

    Route::resource('catracas', 'CatracasController')->only(['index', 'show']);


});
