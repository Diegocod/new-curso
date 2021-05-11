<?php

use App\Http\Controllers\{
    PostController
};
use Illuminate\Support\Facades\Route;

Route::post('/posts', [PostController::class, 'store'] )->name('posts.store'); /*não tem problema ter duas urls com
o mesmo nome, desde que a requisição seja diferente ex: post!=get   */

Route::get('/posts/create',[PostController::class, 'create'])->name('posts.create');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');



Route::get('/', function () {
    return view('welcome');
});
