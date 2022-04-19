<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RssController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\News\NewsCategoryController;
use App\Http\Controllers\News\NewsArticleController;
use App\Http\Controllers\News\AuthController;
use App\Http\Controllers\News\NotifyController;
use App\Http\Controllers\News\RssNewsController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\News\HomeController;
use App\Http\Controllers\Admin\DashboardController;

$prefixAdmin = config('phon.url.prefix_admin');


//$prefixAdmin = Config::get('phon.url.prefix_admin', '123');


Route::group(['prefix' => $prefixAdmin, 'middleware' => 'permission.admin'], function () {
    //=======================DASHBOARD=====================
    $prefix = 'dashboard';
    Route::group(['prefix' => $prefix], function () use ($prefix) {
        Route::get('', [DashboardController::class, 'index'])->name($prefix);
    });

    //=======================SLIDER=====================
    $prefix = 'slider';
    Route::group(['prefix' => $prefix], function () use ($prefix) {
        Route::get('',                              [SliderController::class, 'index'])->name($prefix);
        Route::get('form/{id?}',                    [SliderController::class, 'form'])->where('id', '[0-9]+')->name($prefix . '/form');
        Route::post('save',                         [SliderController::class, 'save'])->name($prefix . '/save');
        Route::get('delete/{id}',                   [SliderController::class, 'delete'])->where('id', '[0-9]+')->name($prefix . '/delete');
        Route::get('change-status-{status}/{id}',   [SliderController::class, 'status'])->where(['id' => '[0-9]+', 'status' => '[a-z]+'])->name($prefix . '/status');
    });
    //=======================CATEGORY=====================
    $prefix = 'category';
    Route::group(['prefix' => $prefix], function () use ($prefix) {
        Route::get('',                                  [CategoryController::class, 'index'])->name($prefix);
        Route::get('form/{id?}',                        [CategoryController::class, 'form'])->where('id', '[0-9]+')->name($prefix . '/form');
        Route::post('save',                             [CategoryController::class, 'save'])->name($prefix . '/save');
        Route::get('delete/{id}',                       [CategoryController::class, 'delete'])->where('id', '[0-9]+')->name($prefix . '/delete');
        Route::get('change-status-{status}/{id}',       [CategoryController::class, 'status'])->where(['id' => '[0-9]+', 'status' => '[a-z]+'])->name($prefix . '/status');
        Route::get('change-is-home-{isHome}/{id}',      [CategoryController::class, 'isHome'])->where(['id' => '[0-9]+', 'isHome' => '[0-9]+'])->name($prefix . '/isHome');
        Route::get('change-display-{display}/{id}',     [CategoryController::class, 'display'])->where(['id' => '[0-9]+', 'display' => '[a-z]+'])->name($prefix . '/display');
    });
    //=======================ARTICLE=====================
    $prefix = 'article';
    Route::group(['prefix' => $prefix], function () use ($prefix) {
        Route::get('',                            [ArticleController::class, 'index'])->name($prefix);
        Route::get('form/{id?}',                  [ArticleController::class, 'form'])->where('id', '[0-9]+')->name($prefix . '/form');
        Route::post('save',                       [ArticleController::class, 'save'])->name($prefix . '/save');
        Route::get('delete/{id}',                 [ArticleController::class, 'delete'])->where('id', '[0-9]+')->name($prefix . '/delete');
        Route::get('change-status-{status}/{id}', [ArticleController::class, 'status'])->where(['id' => '[0-9]+', 'status' => '[a-z]+'])->name($prefix . '/status');
        Route::get('change-type-{type}/{id}',     [ArticleController::class, 'type'])->where(['id' => '[0-9]+', 'type' => '[a-z]+'])->name($prefix . '/type');
    });
    //=======================USER=====================
    $prefix = 'user';
    Route::group(['prefix' => $prefix], function () use ($prefix) {
        Route::get('',                            [UserController::class, 'index'])->name($prefix);
        Route::get('form/{id?}',                  [UserController::class, 'form'])->where('id', '[0-9]+')->name($prefix . '/form');
        Route::post('change-password',            [UserController::class, 'changePassword'])->name($prefix . '/change-password');
        Route::post('change-level',               [UserController::class, 'changeLevel'])->name($prefix . '/change-level');
        Route::post('save',                       [UserController::class, 'save'])->name($prefix . '/save');
        Route::get('delete/{id}',                 [UserController::class, 'delete'])->where('id', '[0-9]+')->name($prefix . '/delete');
        Route::get('change-status-{status}/{id}', [UserController::class, 'status'])->where(['id' => '[0-9]+', 'status' => '[a-z]+'])->name($prefix . '/status');
        Route::get('change-level-{level}/{id}',   [UserController::class, 'level'])->where(['id' => '[0-9]+', 'level' => '[a-z]+'])->name($prefix . '/level');
    });
    //=======================RSS=====================
    $prefix = 'rss';
    Route::group(['prefix' => $prefix], function () use ($prefix) {
        Route::get('',                              [RssController::class, 'index'])->name($prefix);
        Route::get('form/{id?}',                    [RssController::class, 'form'])->where('id', '[0-9]+')->name($prefix . '/form');
        Route::post('save',                         [RssController::class, 'save'])->name($prefix . '/save');
        Route::get('delete/{id}',                   [RssController::class, 'delete'])->where('id', '[0-9]+')->name($prefix . '/delete');
        Route::get('change-status-{status}/{id}',   [RssController::class, 'status'])->where(['id' => '[0-9]+', 'status' => '[a-z]+'])->name($prefix . '/status');
    });
});
$prefixNews = config('phon.url.prefix_news');
Route::group(['prefix' => $prefixNews, 'namespace' => 'News'], function () {
    //=======================HOMEPAGE=====================
    $prefix = 'home';
    Route::group(['prefix' => $prefix], function () use ($prefix) {
        Route::get('', [HomeController::class, 'index'])->name($prefix);
    });
    //=======================CATEGORY=====================
    $prefix = 'chuyen-muc';
    Route::group(['prefix' => $prefix], function () use ($prefix) {
        Route::get('/{category_name}-{category_id}.html', [NewsCategoryController::class, 'index'])
            ->where(['category_name' => '[0-9a-zA-Z_-]+', 'category_id' => '[0-9]+',])
            ->name($prefix . '/index');
    });
    //=======================ARTICLE=====================
    $prefix = 'bai-viet';
    Route::group(['prefix' => $prefix], function () use ($prefix) {
        Route::get('/{article_name}-{article_id}.html', [NewsArticleController::class, 'index'])
            ->where(['article_name' => '[0-9a-zA-Z_-]+', 'article_id' => '[0-9]+',])
            ->name($prefix . '/index');
    });
    //=======================NOTIFY=====================
    $prefix = 'notify';
    Route::group(['prefix' => $prefix], function () use ($prefix) {
        Route::get('/no-permission', [NotifyController::class, 'noPermission'])->name($prefix . '/noPermission');
    });
    //=======================LOGIN=====================
    $prefix = 'auth';
    Route::group(['prefix' => $prefix], function () use ($prefix) {
        Route::get('/login',        [AuthController::class, 'login'])->name($prefix . '/login')->middleware('check.login');
        Route::post('/postLogin',   [AuthController::class, 'postLogin'])->name($prefix . '/postLogin');
        Route::get('/register',     [AuthController::class, 'register'])->name($prefix . '/register');
        Route::post('/postRegister', [AuthController::class, 'postRegister'])->name($prefix . '/postRegister');
        //=======================LOGOUT=====================
        Route::get('/logout',       [AuthController::class, 'logout'])->name($prefix . '/logout');
    });
    //=======================RSS=====================
    $prefix = 'rss';
    Route::group(['prefix' => $prefix], function () use ($prefix) {
        Route::get('/tin-tuc-tong-hop', [RssNewsController::class, 'index'])->name($prefix . '/tin-tuc-tong-hop');
        Route::get('/get-gold', [RssNewsController::class, 'getGold'])->name($prefix . '/get-gold');
        Route::get('/get-coin', [RssNewsController::class, 'getCoin'])->name($prefix . '/get-coin');
    });
});
