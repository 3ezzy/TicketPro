<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\DashboardtController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardtController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ticket routes
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');

    // Assignment routes
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/create/{ticket}', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::get('/assignments/{assignment}', [AssignmentController::class, 'show'])->name('assignments.show');
    Route::get('/assignments/{assignment}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
    Route::put('/assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
    Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');
    Route::post('/assign-ticket/{ticket}', [AssignmentController::class, 'assign'])->name('assignments.quick_assign');
    
    // Developer routes
    Route::get('/developers', [DeveloperController::class, 'index'])->name('developers.index');
    Route::get('/developers/{id}', [DeveloperController::class, 'show'])->name('developers.show');
    Route::get('/my-tickets', [DeveloperController::class, 'myTickets'])->name('developers.my-tickets');
    Route::put('/tickets/{ticketId}/status', [DeveloperController::class, 'updateTicketStatus'])->name('developers.update-ticket-status');
    
    // Admin pending approvals
    Route::get('/pending-approvals', [DeveloperController::class, 'pendingApprovals'])->name('developers.pending-approvals');
    Route::put('/resolve-ticket/{ticketId}', [DeveloperController::class, 'resolveTicket'])->name('developers.resolve-ticket');
});

require __DIR__ . '/auth.php';