<?php
namespace App\Http\Controllers;

use App\Models\Assignment; // Ensure this model exists in the specified namespace
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    // Display all assignments
    public function index()
    {
        $assignments = Assignment::with('ticket', 'developer')->get();
        return view('assignments.index', compact('assignments'));
    }

    // Show the form for assigning a developer to a ticket
    public function create($id)
    {
        $ticket = Ticket::findOrFail($id);
        $developers = User::where('role', 'developer')->get();
        return view('assignments.create', compact('tickets', 'developers'));
    }

    // Store a new assignment
    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'developer_id' => 'required|exists:users,id'
        ]);

        Assignment::create([
            'ticket_id' => $request->ticket_id,
            'developer_id' => $request->developer_id
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket assigned successfully.');
    }

   
    // Show an assignment
    public function show(Assignment $assignment)
    {
        return view('assignments.show', compact('assignment'));
    }

    // Edit an assignment
    public function edit(Assignment $assignment)
    {
        $developers = User::where('role', 'developer')->get();
        return view('assignments.edit', compact('assignment', 'developers'));
    }

    // Update an assignment
    public function update(Request $request, Assignment $assignment)
    {
        $request->validate([
            'developer_id' => 'required|exists:users,id'
        ]);

        $assignment->update([
            'developer_id' => $request->developer_id
        ]);

        return redirect()->route('assignments.index')->with('success', 'Assignment updated successfully.');
    }

    // Delete an assignment (Unassign ticket)
    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('assignments.index')->with('success', 'Assignment removed.');
    }
}
