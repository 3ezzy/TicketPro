<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

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


    // Display all tickets
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');

    // Show the form to create a new ticket
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');

    // Store a newly created ticket
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

    // Display a specific ticket
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');

    // Show the form to edit a ticket
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');

    // Update a specific ticket
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');

    // Delete a specific ticket
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
});



require __DIR__ . '/auth.php';
