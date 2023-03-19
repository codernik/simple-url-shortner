<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LinkController;
use App\Http\Middleware\CheckAuth;

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

Route::get('/register', [UserController::class, 'create'])->name('register');
Route::post('/register', [UserController::class, 'register']);

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'authenticate']);

Route::middleware(['checkauth'])->group(function () {
    
    Route::get('/links', [LinkController::class, 'index'])->name('links.index');
    
    Route::get('/links/create', [LinkController::class, 'create'])->name('links.create');
    Route::post('/links/create', [LinkController::class, 'store'])->name('links.store');
    
    Route::get('/links/{link}/edit', [LinkController::class, 'edit'])->name('links.edit');
    Route::put('/links/{link}', [LinkController::class, 'update'])->name('links.update');
    
    Route::get('/links/delete/{id}', [LinkController::class, 'delete'])->name('links.delete');
    Route::get('/links/disable/{id}', [LinkController::class, 'disable'])->name('links.disable');
    Route::get('/links/enable/{id}', [LinkController::class, 'enable'])->name('links.enable');
    
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    
});

Route::get('/{hash}', [LinkController::class, 'processLink'])->where('hash', '[a-zA-Z0-9]+');