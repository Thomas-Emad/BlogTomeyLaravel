<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\MarkupArticlesController;
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

Route::controller(IndexController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/index', 'index');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/types-tags', TypeController::class);
Route::resource('/articles', ArticleController::class);
Route::controller(ArticleController::class)->group(function () {
    Route::get('/article/write', 'create')->middleware('auth');
    Route::get('/Read/{user}/{id}', 'show')->name('read');
});
Route::controller(CommentController::class)->middleware('auth')->group(function () {
    Route::post('/Read/{user}/{id}/Comment', 'store');
    Route::post('/Read/{user}/{id}/Comment/Refer', 'refer');
    Route::post('/Read/Comment/Edit', 'edit');
    Route::post('/Read/Comment/Delete', 'destroy');
});
Route::controller(MarkupArticlesController::class)->middleware('auth')->group(function () {
    Route::get('/favorite', 'index');
    Route::get('/Read/{user}/{id}/MarkUp', 'markUp')->name("markUp");
    Route::get('/Read/{user}/{id}/unMark', 'unMark')->name("unMark");
});

Auth::routes();

Route::get('/{page}', [AdminController::class, "index"]);
