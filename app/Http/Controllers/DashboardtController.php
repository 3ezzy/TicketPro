<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class DashboardtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalTickets = Ticket::count();
        $resolvedTickets = Ticket::where('status', 'resolved')->count();
        $pendingTickets = Ticket::whereIn('status', ['open', 'pending'])->count();
        $urgentTickets = Ticket::where('priority', 'urgent')->count();
        
        // Get client tickets, sorted by most recent
        $clientTickets = Ticket::fromClients()
            ->with(['user', 'software']) // Eager load relationships
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        // Get total number for pagination info
        $totalClientTickets = Ticket::fromClients()->count();
        
        return view('dashboard', compact(
            'totalTickets', 
            'resolvedTickets', 
            'pendingTickets', 
            'urgentTickets',
            'clientTickets',
            'totalClientTickets'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
