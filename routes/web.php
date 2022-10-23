<?php

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
require 'web/user.php';
require 'web/chat.php';



