<?php
use App\Http\Controllers\ChatControl;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GrupoGlobalControl;
Route::group( [ 'prefix' => 'chat/', 'middleware' => 'auth' ], function()
{
    Route::group([ 'prefix' => 'private/' ], function()
    {
        Route::get('/private/{user_id}', [ChatControl::class, 'index'])->name('view.chat.index');
        Route::post('/chat/enviar-messagem', [ChatControl::class, 'sendMessage'])->name('control.chat.sendMessage');
        Route::post('/chat/ler-mensagens', [ChatControl::class, 'messageRead'])->name('control.chat.messageRead');
    });
    Route::group([ 'prefix' => 'global/' ], function()
    {
        Route::get('/grupo', [GrupoGlobalControl::class, 'index'])->name('view.grupo-global.index');
        Route::post('/grupo/enviar-messagem', [GrupoGlobalControl::class, 'sendMessage'])->name('control.grupo-global.sendMessage');
    });
});