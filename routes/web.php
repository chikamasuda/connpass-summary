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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/popular', [App\Http\Controllers\PopularEventController::class, 'index'])->name('popular');
Route::get('/popular/csv', [App\Http\Controllers\PopularEventController::class, 'downloadPopularEvent'])->name('popular.csv');
Route::get('/search', [App\Http\Controllers\PopularEventController::class, 'search'])->name('popular.search');
Route::get('/php', [App\Http\Controllers\PhpEventController::class, 'index'])->name('php');
Route::get('/php_search', [App\Http\Controllers\PhpEventController::class, 'search'])->name('php.search');
Route::get('/php/csv', [App\Http\Controllers\PhpEventController::class, 'downloadPhpEvent'])->name('php.csv');
Route::get('/like', [App\Http\Controllers\LikeController::class, 'index'])->name('like');
Route::get('/like_search', [App\Http\Controllers\LikeController::class, 'search'])->name('like.search');
//問い合わせ入力ページ
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');
//問い合わせ確認ページ
Route::post('/contact/confirm', [App\Http\Controllers\ContactController::class, 'confirm'])->name('contact.confirm');
//問い合わせ送信完了ページ
Route::post('/contact/send', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');
//いいね機能・いいね削除機能
Route::prefix('events')->name('events.')->group(function () {
    Route::put('/{event}/like', [App\Http\Controllers\LikeController::class, 'like'])->name('like');
    Route::delete('/{event}/like', [App\Http\Controllers\LikeController::class, 'unlike'])->name('unlike');
});