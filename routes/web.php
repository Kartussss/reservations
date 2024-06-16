<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/contact', function () {
    return Inertia::render('Contact');
})->middleware(['auth', 'verified'])->name('contact');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/reservations', [ReservationsController::class, 'index'])->name('reservations');
    Route::get('/reservations/myreservations', [ReservationsController::class, 'myReservations'])->name('myReservations');
    Route::post('/reservations/create', [ReservationsController::class, 'create'])->name('reservations.create');
    Route::delete('/reservations/{id}', [ReservationsController::class, 'delete'])->name('reservations.delete');


});

require __DIR__.'/auth.php';
