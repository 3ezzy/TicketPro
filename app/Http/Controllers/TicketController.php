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
    $tickets = Ticket::with(['user', 'software'])
        ->latest()
        ->paginate(10);
    return view('tickets.index', compact('tickets'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $software = Software::all();
        return view('tickets.create', compact('software'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        $ticket = Ticket::with(['user', 'software'])->findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $software = Software::all();
        return view('tickets.edit', compact('ticket', 'software'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'os' => 'required|in:windows,macos,linux,ios,android',
            'software_id' => 'required|exists:software,id',
        ]);

        // Update the ticket
        $ticket->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'os' => $request->os,
            'software_id' => $request->software_id,
        ]);

        // Redirect back with success message
        return redirect()->route('tickets.index')->with('success', 'Le ticket a été mis à jour avec succès.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }
}
