<?php

use App\Http\Controllers\ChatControl;
use App\Http\Controllers\GrupoGlobalControl;
use App\Http\Controllers\UserControl;
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

Route::get('/', [UserControl::class, 'index'])->name('view.user.login');
Route::get('/cadastro', [UserControl::class, 'viewCadastro'])->name('view.user.cadastro');
Route::get('/listagem', [UserControl::class, 'viewLista'])->name('view.user.lista');

Route::post('/cadastrar', [UserControl::class, 'cadastrar'])->name('control.user.cadastrar');

Route::post('/login', [UserControl::class, 'login'])->name('control.user.login');
Route::get('/logout', [UserControl::class, 'logout'])->name('control.user.logout');

//chat
Route::get('/private/{user_id}', [ChatControl::class, 'index'])->name('view.chat.index');

//grupo global
Route::get('/grupo', [GrupoGlobalControl::class, 'index'])->name('view.grupo-global.index');
Route::post('/grupo/enviar-messagem', [GrupoGlobalControl::class, 'sendMessage'])->name('control.grupo-global.sendMessage');

