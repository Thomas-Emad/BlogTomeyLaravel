<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\ReportArticleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\MarkupArticlesController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Models\ReportArticle;
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

/* Locale Langs */

Route::get("lang/{locale}", function ($locale) {
  if (in_array($locale, config("app.available_locales"))) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
  } else {
    session()->put('locale', 'en');
  }
  return back();
});



Route::controller(IndexController::class)->group(function () {
  Route::get('/', 'index');
  Route::get('/index/{name?}', 'index');
});

Route::get('/home/{typeArticles?}', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/admin/types', TypeController::class)->middleware(['auth', 'permission:types']);
Route::resource('/articles', ArticleController::class);
Route::get('/articles/{id?}', [ArticleController::class, 'index']);
Route::controller(ArticleController::class)->group(function () {
  Route::get('/article/write', 'create')->middleware(['auth', 'verified']);
  Route::get('/Read/{user}/{id}', 'show')->name('read');
  Route::get('/edit/{user}/{id}', 'edit')->name('editArticle')->middleware(['auth', 'verified']);
  Route::post('/article/delete', 'destroy')->name('delArticle')->middleware(['auth', 'verified']);
  Route::get('/article/statistic/{user}/{id}', 'static')->name('statisticArticle')->middleware(['auth', 'verified']);
});
Route::controller(CommentController::class)->middleware(['auth', 'verified'])->group(function () {
  Route::post('/Read/{user}/{id}/Comment', 'store');
  Route::post('/Read/{user}/{id}/Comment/Refer', 'refer');
  Route::post('/Read/Comment/Edit', 'edit');
  Route::post('/Read/Comment/Delete', 'destroy');
});
Route::controller(MarkupArticlesController::class)->middleware(['auth', 'verified'])->group(function () {
  Route::get('/favorite', 'index');
  Route::get('/Read/{user}/{id}/MarkUp', 'markUp')->name("markUp");
  Route::get('/Read/{user}/{id}/unMark', 'unMark')->name("unMark");
});
Route::controller(HistoryController::class)->middleware(['auth', 'verified'])->group(function () {
  Route::get('/history', 'index');
  Route::get('/history/hidden/{id_user}/{id}', 'hidden')->name("hidden");
});
Route::get('Read/{user}/{id}/Reaction/{code}', ReactionController::class)->name('reaction')->middleware('verified');
Route::get('Read/{user}/{id}/Report', ReportArticleController::class)->name('report')->middleware('verified');
Route::controller(UserController::class)->group(function () {
  Route::get('/admin/users', 'index')->middleware(['auth', 'permission:users']);
  Route::get('/admin/users/roles/edit/{id}', 'edit')->name("users.edit")->middleware(['auth', 'permission:rolesPermissions']);
  Route::post('/admin/users/roles/edit/updateRoles', 'updateRoles')->name('users.updateRoles')->middleware(['auth', 'permission:rolesPermissions']);
  Route::get('/profile/{id?}', 'show')->name("profile");
  Route::post('/profile/update', 'update')->name("userUpdate")->middleware(['auth', 'verified', 'verified']);
  Route::get('/profile/{id}/follow', 'follow')->name("follow")->middleware(['auth']);
  Route::get('/profile/{id}/destroy', 'destroy')->name("userDestroy")->middleware(['auth', 'permission:users']);
  Route::get('/profile/{id}/banned', 'banned')->name("userBanned")->middleware(['auth', 'permission:users']);
  Route::get('/ReadAllNotifications', 'notifReadAll')->name("notifReadAll")->middleware(['auth']);
});

Route::get('search/{type?}/{title?}', [SearchController::class, 'index'])->name('search');
Route::get('searchForm')->middleware('CleanSearchURL')->name('searchForm');

Route::get('statistic', [StatisticController::class, '__invoke'])->middleware(['auth', 'verified']);
Route::get('admin/statistic', [\App\Http\Controllers\admin\StatisticController::class, '__invoke'])->middleware(['auth', 'verified', 'permission:admin-statistics']);
Route::get('admin/articles/{title?}', [\App\Http\Controllers\admin\ArticlesController::class, 'index'])->middleware(['auth', 'verified', 'permission:articles-show|articles-controll']);
Route::get('admin/articles/statusArticle/{user}/{id}', [\App\Http\Controllers\admin\ArticlesController::class, 'statusArticle'])->name("statusArticle")->middleware(['auth', 'verified', 'permission:articles-show|articles-controll']);
Route::resource('admin/roles', RoleController::class)->middleware(['auth', 'verified', 'permission:rolesPermissions']);
Route::get('admin/role/{roleID}', [RoleController::class, 'roleInfo'])->middleware(['auth', 'verified', 'permission:rolesPermissions']);

Auth::routes(['verify' => true]);

Route::get('/{page}', [AdminController::class, "index"]);
