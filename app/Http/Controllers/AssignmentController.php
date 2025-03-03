<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    // Display all assignments
    public function index()
    {
        $assignments = Assignment::with(['ticket', 'developer', 'admin'])->orderBy('created_at', 'desc')->get();
        return view('assignments.index', compact('assignments'));
    }

    // Show the form for assigning a developer to a ticket
    public function create($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        // Changed 'Développeur' to 'developer' to match the database value
        $developers = User::where('role', 'developer')->get();
        
        return view('assignments.create', compact('ticket', 'developers'));
    }

    // Store a new assignment
    public function store(Request $request)
    {
      // Validate the request
    $validated = $request->validate([
        'ticket_id' => 'required|exists:tickets,id',
        'developer_id' => 'required|exists:users,id'
    ]);

    // Create the new assignment
    $assignment = new Assignment();
    $assignment->ticket_id = $request->ticket_id;
    $assignment->developer_id = $request->developer_id;
    $assignment->admin_id = Auth::id(); // Add this line to set the admin_id
    $assignment->assigned_by = Auth::id();
    $assignment->assigned_at = now();
    $assignment->save();

    // Redirect with success message
    return redirect()->route('assignments.index')
        ->with('success', 'Ticket successfully assigned to developer.');
    }

    // Show an assignment
    public function show(Assignment $assignment)
    {
        return view('assignments.show', compact('assignment'));
    }

    // Edit an assignment
    public function edit(Assignment $assignment)
    {
        $developers = User::where('role', 'Développeur')->get(); // Updated to match your database value
        return view('assignments.edit', compact('assignment', 'developers'));
    }

    // Update an assignment
    public function update(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'ticket_info' => 'required',
            'developer_id' => 'required|exists:users,id',
        ]);
        
        $assignment = new Assignment();
        $assignment->ticket_id = $request->ticket_id;
        $assignment->developer_id = $request->developer_id;
        $assignment->save();

        return redirect()->route('assignments.index')->with('success', 'Assignment updated successfully.');
    }

    // Delete an assignment (Unassign ticket)
    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('assignments.index')->with('success', 'Assignment removed.');
    }
}