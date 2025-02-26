<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AssignmentController;
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

    // Display all assignments
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    
    // Show the form to assign a ticket
    Route::post('/assignments/create/{ticket}', [AssignmentController::class, 'create'])->name('assignments.create');
    
    // Store a new assignment (Assign a developer to a ticket)
    Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    
    // Show a specific assignment
    Route::get('/assignments/{assignment}', [AssignmentController::class, 'show'])->name('assignments.show');
    
    // Edit an assignment
    Route::get('/assignments/{assignment}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
    
    // Update an assignment (Reassign ticket)
    Route::put('/assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
    
    // Delete an assignment (Unassign a developer)
    Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');
    
    // Quick Assign Route (From Tickets Page)
    Route::post('/assign-ticket/{ticket}', [AssignmentController::class, 'assign'])->name('assignments.quick_assign');
    
});



require __DIR__ . '/auth.php';
