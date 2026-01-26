<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\MicrosoftAuthController;
// use App\Http\Controllers\Microsoft\SharepointController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Microsoft\GraphController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/auth/microsoft', [MicrosoftAuthController::class, 'redirect'])->name('auth.microsoft');
    Route::get('/auth/microsoft/callback', [MicrosoftAuthController::class, 'callback']);
    Route::post('/auth/microsoft/disconnect', [MicrosoftAuthController::class, 'disconnect'])->name('microsoft.disconnect');
});


Route::middleware(['auth', 'ms.token'])->group(function () {
    Route::get('/documents', [GraphController::class, 'getDocuments'])->name('graph.documents');
    Route::post('/documents/create', [GraphController::class, 'create'])->name('documents.create');
    // Route::get('/document/edit/{id}', [SharepointController::class, 'showEditor'])->name('sharepoint.edit');
});


require __DIR__.'/auth.php';
