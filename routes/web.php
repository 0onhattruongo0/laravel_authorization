<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\GroupsController;
use App\Http\Controllers\Admin\UsersController;

use App\Models\Post;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    // Posts
    Route::prefix('posts')->name('posts.')->middleware('can:posts')->group(function(){
        Route::get('/',[PostsController::class, 'index'])->name('index');
        Route::get('/add',[PostsController::class, 'add'])->name('add')->can('posts.add');
        Route::post('/add',[PostsController::class, 'postAdd'])->name('postAdd')->can('posts.add');
        Route::get('/edit/{post}',[PostsController::class, 'edit'])->name('edit')->can('posts.edit');
        Route::post('/edit/{post}',[PostsController::class, 'postEdit'])->name('postEdit')->can('posts.edit');
        Route::get('/delete/{post}',[PostsController::class, 'delete'])->name('delete')->can('posts.delete');
    });

    // Groups
    Route::prefix('groups')->name('groups.')->middleware('can:groups')->group(function(){
        Route::get('/',[GroupsController::class, 'index'])->name('index');
        Route::get('/add',[GroupsController::class, 'add'])->name('add')->can('groups.add');
        Route::post('/add',[GroupsController::class, 'postAdd'])->name('postAdd')->can('groups.add');
        Route::get('/edit/{group}',[GroupsController::class, 'edit'])->name('edit')->can('groups.edit');
        Route::post('/edit/{group}',[GroupsController::class, 'postEdit'])->name('postEdit')->can('groups.edit');
        Route::get('/delete/{group}',[GroupsController::class, 'delete'])->name('delete')->can('groups.delete');
        Route::get('/permission/{group}',[GroupsController::class, 'permission'])->name('permission')->can('groups.permission');
        Route::post('/permission/{group}',[GroupsController::class, 'postPermission'])->can('groups.permission');
    });

    // Posts
    Route::prefix('users')->name('users.')->middleware('can:users')->group(function(){
        Route::get('/',[UsersController::class, 'index'])->name('index');
        Route::get('/add',[UsersController::class, 'add'])->name('add')->can('users.add');
        Route::post('/add',[UsersController::class, 'postAdd'])->name('postAdd')->can('users.add');
        Route::get('/edit/{user}',[UsersController::class, 'edit'])->name('edit')->can('users.edit');
        Route::post('/edit/{user}',[UsersController::class, 'postEdit'])->name('postEdit')->can('users.edit');
        Route::get('/delete/{user}',[UsersController::class, 'delete'])->name('delete')->can('users.delete');
    });
});
