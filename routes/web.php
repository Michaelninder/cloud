<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Base\PageController;
use App\Http\Controllers\Cloud\FileController;
use App\Http\Controllers\Cloud\FolderController;
use App\Http\Controllers\Cloud\TagController;
use App\Http\Controllers\Cloud\LinkController;

Route::get('/', [PageController::class, 'lander'])->name('lander');
Route::redirect('/home', '/')->name('home');

Route::get('/dashboard', [PageController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->name('cloud.')->prefix('cloud')->group(function () {
    Route::resource('tags', TagController::class);
    Route::resource('files', FileController::class);
    Route::resource('folders', FolderController::class);
    Route::resource('links', LinkController::class);
});


require __DIR__.'/auth.php';


Route::get('/{link}', [LinkController::class , 'redirect'])->name('cloud.links.redirect');