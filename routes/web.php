<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication
Route::get('/cadastro', [AuthController::class, 'showRegister'])->name('register');
Route::post('/cadastro', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');
});

// Announcements
Route::get('/anuncios', [AnnouncementController::class, 'index'])->name('announcements.index');

Route::middleware('auth')->group(function () {
    Route::get('/anuncios/criar', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/anuncios', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/anuncios/{announcement}/editar', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/anuncios/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/anuncios/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
});

Route::get('/anuncios/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');


// Reviews (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/avaliar/{user}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/avaliar/{user}', [ReviewController::class, 'store'])->name('reviews.store');
});
