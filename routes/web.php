<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

// --- Početna stranica ---
Route::get('/', function () {
    return view('welcome');
});

// --- Dashboard ---
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- Profile ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Posts ---
// Resource rute za kreiranje, editovanje i brisanje (samo admin i editor)
Route::middleware(['auth', 'role:admin,editor'])->group(function () {
    Route::resource('posts', PostController::class)->except(['index', 'show']);
});

// Index i show rute za postove (svi prijavljeni korisnici)
Route::middleware('auth')->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');
});

// --- Komentari ---
Route::middleware('auth')->group(function () {
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// --- Categories & Tags ---
Route::resource('categories', CategoryController::class)->middleware('auth');
Route::resource('tags', TagController::class)->middleware('auth');

// --- Auth routes ---
require __DIR__.'/auth.php';
