<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Routing\Controller as BaseController;

class AssignmentController extends BaseController
{
    /**
     * Constructor - add middleware to restrict assignments to admins only
     */
    public function __construct()
    {
        // Add middleware to check if user is admin before allowing access to any method
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('dashboard')
                    ->with('error', 'Seuls les administrateurs peuvent gérer les assignations de tickets.');
            }
            return $next($request);
        });
    }

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
        
        // Check if ticket is already assigned
        if ($ticket->assignments()->count() > 0) {
            return redirect()->route('tickets.show', $ticket->id)
                ->with('warning', 'Ce ticket est déjà assigné à un développeur.');
        }
        
        // Get all developers
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

        // Check if assignment already exists
        $existingAssignment = Assignment::where('ticket_id', $request->ticket_id)->first();
        
        if ($existingAssignment) {
            return redirect()->route('assignments.index')
                ->with('warning', 'Ce ticket est déjà assigné à un développeur.');
        }

        // Verify the developer exists and has developer role
        $developer = User::findOrFail($request->developer_id);
        if ($developer->role !== 'developer') {
            return redirect()->route('assignments.index')
                ->with('error', 'L\'utilisateur sélectionné n\'est pas un développeur.');
        }

        // Create the new assignment
        $assignment = new Assignment();
        $assignment->ticket_id = $request->ticket_id;
        $assignment->developer_id = $request->developer_id;
        $assignment->admin_id = Auth::id();
        $assignment->assigned_by = Auth::id();
        $assignment->assigned_at = now();
        $assignment->save();
        
        // Update ticket status to in_progress
        $ticket = Ticket::findOrFail($request->ticket_id);
        $ticket->status = 'in_progress';
        $ticket->save();

        // Redirect with success message
        return redirect()->route('assignments.index')
            ->with('success', 'Ticket assigné avec succès au développeur.');
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
        $validated = $request->validate([
            'developer_id' => 'required|exists:users,id',
        ]);
        
        // Verify the developer exists and has developer role
        $developer = User::findOrFail($request->developer_id);
        if ($developer->role !== 'developer') {
            return redirect()->route('assignments.index')
                ->with('error', 'L\'utilisateur sélectionné n\'est pas un développeur.');
        }
        
        // Update the assignment
        $assignment->developer_id = $request->developer_id;
        $assignment->admin_id = Auth::id(); // Update who made the change
        $assignment->assigned_at = now();
        $assignment->save();

        return redirect()->route('assignments.index')->with('success', 'Assignation mise à jour avec succès.');
    }

    // Delete an assignment (Unassign ticket)
    public function destroy(Assignment $assignment)
    {
        // Update ticket status back to open
        $ticket = Ticket::findOrFail($assignment->ticket_id);
        $ticket->status = 'open';
        $ticket->save();
        
        // Delete assignment
        $assignment->delete();
        
        return redirect()->route('assignments.index')->with('success', 'Assignation supprimée.');
    }

    // Quick assign method from ticket page
    public function assign(Request $request, $ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        
        // Check if ticket is already assigned
        if ($ticket->assignments()->count() > 0) {
            return redirect()->route('tickets.show', $ticket->id)
                ->with('warning', 'Ce ticket est déjà assigné à un développeur.');
        }
        
        $developers = User::where('role', 'developer')->get();
        
        return view('assignments.create', compact('ticket', 'developers'));
    }
}