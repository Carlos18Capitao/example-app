<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\CasaController;
use App\Http\Controllers\CasaPhotoController;
use Inertia\Inertia;

Route::get('/', [PessoaController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('pessoas', PessoaController::class);
Route::resource('casas', CasaController::class);
Route::post('/casas/{casa}/photos', [CasaPhotoController::class, 'store'])->name('casas.photos.store');
Route::delete('photos/{photo}', [CasaPhotoController::class, 'destroy'])->name('casas.photos.destroy');

Route::get('casas/create/{pessoa}', [CasaController::class, 'create'])->name('casas.create.pessoa');
require __DIR__.'/auth.php';
