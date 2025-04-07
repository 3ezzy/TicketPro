<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Software;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // For clients, only show their own tickets
        if (Auth::user()->role === 'client') {
            $tickets = Ticket::with(['user', 'software'])
                ->where('user_id', Auth::id())
                ->latest()
                ->paginate(10);
        } else {
            // For admins and developers, show all tickets
            $tickets = Ticket::with(['user', 'software'])
                ->latest()
                ->paginate(10);
        }
        
        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only clients can create tickets
        if (Auth::user()->role !== 'client') {
            return redirect()->route('tickets.index')
                ->with('error', 'Vous n\'êtes pas autorisé à créer des tickets.');
        }
        
        $software = Software::all();
        return view('tickets.create', compact('software'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Only clients can create tickets
        if (Auth::user()->role !== 'client') {
            return redirect()->route('tickets.index')
                ->with('error', 'Vous n\'êtes pas autorisé à créer des tickets.');
        }
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'priority' => 'required|in:low,medium,high',
            'os' => 'required',
            'software_id' => 'required|exists:software,id'
        ]);

        $validated['user_id'] = Auth::user()->id;

        Ticket::create($validated);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $ticket = Ticket::with(['user', 'software', 'assignments.developer', 'resolution', 'resolution.developer', 'resolution.admin'])
        ->findOrFail($id);
        
    // If user is a client, ensure they can only view their own tickets
    if (Auth::user()->role === 'client' && $ticket->user_id !== Auth::id()) {
        return redirect()->route('tickets.index')
            ->with('error', 'Vous n\'êtes pas autorisé à voir ce ticket.');
    }
    
    // Developers can now view all tickets (no restrictions for viewing)
    // We removed the developer restriction check that was here
    
    return view('tickets.show', compact('ticket'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        
        // Only the client who created the ticket can edit it
        if (Auth::user()->role !== 'client' || $ticket->user_id !== Auth::id()) {
            return redirect()->route('tickets.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier ce ticket.');
        }
        
        $software = Software::all();
        return view('tickets.edit', compact('ticket', 'software'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        // Only the client who created the ticket can update it
        if (Auth::user()->role !== 'client' || $ticket->user_id !== Auth::id()) {
            return redirect()->route('tickets.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier ce ticket.');
        }
        
        // Validate the request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'os' => 'required|in:windows,macos,linux,ios,android',
            'software_id' => 'required|exists:software,id',
        ]);

        // Update the ticket
        $ticket->update($validated);

        // Redirect back with success message
        return redirect()->route('tickets.index')
            ->with('success', 'Le ticket a été mis à jour avec succès.');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        
        // Only admin or the client who created the ticket can delete it
        if (Auth::user()->role === 'developer' || 
            (Auth::user()->role === 'client' && $ticket->user_id !== Auth::id())) {
            return redirect()->route('tickets.index')
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer ce ticket.');
        }
        
        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket supprimé avec succès.');
    }
}