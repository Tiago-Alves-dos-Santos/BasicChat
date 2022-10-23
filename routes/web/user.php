<?php

use App\Http\Controllers\UserControl;
use Illuminate\Support\Facades\Route;
Route::group( [ 'prefix' => 'user/' ], function()
{
    Route::get('/cadastro', [UserControl::class, 'viewCadastro'])->name('view.user.cadastro');
    Route::post('/login', [UserControl::class, 'login'])->name('control.user.login');
    Route::post('/cadastrar', [UserControl::class, 'cadastrar'])->name('control.user.cadastrar');
    Route::group( ['middleware' => 'auth'], function()
    {
        Route::match(['get','post'],'/listagem', [UserControl::class, 'viewLista'])->name('view.user.lista');
        Route::get('/logout/{motivo?}', [UserControl::class, 'logout'])->name('control.user.logout');
        Route::get('/messages/not-read/', [UserControl::class, 'getMessagesNotReadCounter'])->name('control.user.getMessagesNotReadCounter');
    });
});

//verficar contato com mensagens nãi lidas

