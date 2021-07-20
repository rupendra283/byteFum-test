<?php

use Illuminate\Http\Request;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::post('/register-user', function(Request $request){
//     return $request->all();
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/blogs', [App\Http\Controllers\BlogController::class, 'index'])->name('blogs.index');
    Route::get('/blog/create', [App\Http\Controllers\BlogController::class, 'create'])->name('blogs.create');
    Route::get('/blog/show/{blog:slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blogs.show');
    Route::get('/blog/{blog:slug}/edit', [App\Http\Controllers\BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blog/{blog:slug}/edit', [App\Http\Controllers\BlogController::class, 'update'])->name('blog.update');
    Route::get('/blog/delete/{id}', [App\Http\Controllers\BlogController::class, 'destroy'])->name('blogs.delete');
});

Route::get('/login/admin', [App\Http\Controllers\AdminLoginController::class, 'showAdminLoginForm']);
Route::post('/login/admin', [App\Http\Controllers\AdminLoginController::class, 'adminLogin']);

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin', [App\Http\Controllers\AdminLoginController::class, 'home'])->name('admin.home');
    Route::get('/admin/blogs', [App\Http\Controllers\AdminLoginController::class, 'blogs'])->name('admin.blogs');
    Route::get('/blog/delete-permenent/{slug}', [App\Http\Controllers\AdminLoginController::class, 'deleteBlog'])->name('admin.blogs');
});
