<?php

Route::redirect('/', 'catracas/relatorios', 302);
Route::redirect('/home', 'catracas/relatorios', 302);

Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::name('login')->post('/login', 'Auth\LoginController@login');


Route::middleware(['auth'])->group(function () {
    Route::name('logout')->post('/logout', 'Auth\LoginController@logout');

    Route::resource('gerenciar-usuarios', 'Auth\GerenciarUsuariosController')->except(['create', 'store', 'show']);
    Route::name('gerenciar-usuarios.store')->post('/gerenciar-usuarios', 'Auth\RegisterController@register');
    Route::name('gerenciar-usuarios.create')->get('/gerenciar-usuarios/create', 'Auth\RegisterController@showRegistrationForm');

    Route::name('catracas.relatorios.alunos')->get('catracas/relatorios/alunos', 'CatracasRelatorioController@alunos');
    Route::name('catracas.relatorios.acessos')->get('catracas/relatorios/acessos',
        'CatracasRelatorioController@acessos');
    Route::name('catracas.relatorios.index2')->get('catracas/relatorios/index', 'CatracasRelatorioController@index2');
    Route::name('catracas.relatorios.index')->get('catracas/relatorios', 'CatracasRelatorioController@index');

    Route::resource('catracas', 'CatracasController')->only(['index', 'show']);


});
