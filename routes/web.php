<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/admin/users/{id}/edit', [HomeController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [HomeController::class, 'update'])->name('admin.users.update');
    Route::get('/admin', [HomeController::class, 'index'])->name('admin.index');
    Route::post('/save-budget', [HomeController::class, 'saveBudget'])->name('save-budget');
    Route::post('/save-categorie', [HomeController::class, 'savecategorie'])->name('save-categorie');
       
});
require __DIR__.'/auth.php';
