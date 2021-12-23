<?php

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

Route::get('/', function () {
    return view('home');
});
//Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/popular', [App\Http\Controllers\EventController::class, 'popularEvent'])->name('popular');
Route::get('/search', [App\Http\Controllers\EventController::class, 'popularEventSearch'])->name('popular.search');
Route::get('/php', [App\Http\Controllers\EventController::class, 'phpEvent'])->name('php');
Route::get('/php_search', [App\Http\Controllers\EventController::class, 'phpEventSearch'])->name('php.search');
//問い合わせ入力ページ
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');
//問い合わせ確認ページ
Route::post('/contact/confirm', [App\Http\Controllers\ContactController::class, 'confirm'])->name('contact.confirm');
//問い合わせ送信完了ページ
Route::post('/contact/send', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');
Route::get('/contact/send', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');