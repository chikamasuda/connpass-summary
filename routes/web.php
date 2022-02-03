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

//TOPページ
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//人気イベントページ
Route::prefix('popular')->name('popular.')->group(function () {
    Route::get('/index', [App\Http\Controllers\PopularEventController::class, 'index'])->name('index');
    Route::get('/csv', [App\Http\Controllers\PopularEventController::class, 'downloadPopularEvent'])->name('csv');
});

//PHPイベントページ
Route::prefix('php')->name('php.')->group(function () {
    Route::get('/index', [App\Http\Controllers\PhpEventController::class, 'index'])->name('index');
    Route::get('/csv', [App\Http\Controllers\PhpEventController::class, 'downloadPhpEvent'])->name('csv');
});

//お気に入りページ
Route::prefix('like')->name('like.')->group(function () {
    Route::get('/index', [App\Http\Controllers\LikeController::class, 'index'])->name('index');
    Route::get('/csv', [App\Http\Controllers\LikeController::class, 'downloadLikeEvent'])->name('csv');
});

//問い合わせページ
Route::prefix('contact')->name('contact.')->group(function () {
    Route::get('/index', [App\Http\Controllers\ContactController::class, 'index'])->name('index');
    Route::post('/confirm', [App\Http\Controllers\ContactController::class, 'confirm'])->name('confirm');
    Route::post('/send', [App\Http\Controllers\ContactController::class, 'send'])->name('send');
});

//お気に入り機能・お気に入り削除機能
Route::prefix('events')->name('events.')->group(function () {
    Route::put('/{event}/like', [App\Http\Controllers\LikeController::class, 'like'])->name('like');
    Route::delete('/{event}/like', [App\Http\Controllers\LikeController::class, 'unlike'])->name('unlike');
});