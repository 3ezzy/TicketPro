<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Assignment;
use App\Models\Ticket;
use App\Models\TicketResolution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeveloperController extends Controller
{
    /**
     * Display a listing of the developers with their stats
     */
    public function index()
    {
        // Get all developers
        $developers = User::where('role', 'developer')->get();
        
        // Calculate statistics for each developer
        foreach ($developers as $developer) {
            // Assigned tickets count
            $developer->assigned_tickets = Assignment::where('developer_id', $developer->id)->count();
            
            // Completed tickets count
            $developer->completed_tickets = Assignment::where('developer_id', $developer->id)
                ->whereHas('ticket', function($query) {
                    $query->where('status', 'closed');
                })->count();
            
            // Current active tickets
            $developer->active_tickets = Assignment::where('developer_id', $developer->id)
                ->whereHas('ticket', function($query) {
                    $query->where('status', 'in_progress');
                })->count();
                
            // Pending approval tickets
            $developer->pending_tickets = Assignment::where('developer_id', $developer->id)
                ->whereHas('ticket', function($query) {
                    $query->where('status', 'pending_approval');
                })->count();
            
            // Calculate resolution rate
            $developer->resolution_rate = $developer->assigned_tickets > 0
                ? round(($developer->completed_tickets / $developer->assigned_tickets) * 100, 2)
                : 0;
                
            // Average resolution time - PostgreSQL compatible
            $avgTime = Assignment::where('developer_id', $developer->id)
                ->join('tickets', 'assignments.ticket_id', '=', 'tickets.id')
                ->where('tickets.status', 'closed')
                ->select(DB::raw('AVG(EXTRACT(EPOCH FROM (tickets.updated_at - assignments.assigned_at))/86400) as avg_time'))
                ->first();
                
            $developer->avg_resolution_time = $avgTime && $avgTime->avg_time ? round($avgTime->avg_time, 1) : 0;
        }
        
        // Get total developers count
        $totalDevelopers = $developers->count();
        
        // Get available developers (not currently assigned to any in-progress tickets)
        $availableDevelopers = $developers->filter(function($developer) {
            return $developer->active_tickets == 0;
        })->count();
        
        // Get busy developers
        $busyDevelopers = $totalDevelopers - $availableDevelopers;
        
        // Calculate overall resolution rate
        $overallResolutionRate = $developers->sum('assigned_tickets') > 0
            ? round(($developers->sum('completed_tickets') / $developers->sum('assigned_tickets')) * 100, 2)
            : 0;
        
        return view('developers.index', compact(
            'developers', 
            'totalDevelopers', 
            'availableDevelopers', 
            'busyDevelopers', 
            'overallResolutionRate'
        ));
    }

    /**
     * Display the specified developer's profile.
     */
    public function show($id)
    {
        $developer = User::findOrFail($id);
        
        // Get developer's assignments
        $assignments = Assignment::with(['ticket', 'ticket.user'])
            ->where('developer_id', $developer->id)
            ->get();
            
        // Calculate stats
        $totalTickets = $assignments->count();
        $completedTickets = $assignments->filter(function($assignment) {
            return $assignment->ticket->status === 'closed';
        })->count();
        
        $inProgressTickets = $assignments->filter(function($assignment) {
            return $assignment->ticket->status === 'in_progress';
        })->count();
        
        $pendingApprovalTickets = $assignments->filter(function($assignment) {
            return $assignment->ticket->status === 'pending_approval';
        })->count();
        
        $resolutionRate = $totalTickets > 0 ? round(($completedTickets / $totalTickets) * 100, 2) : 0;
        
        return view('developers.show', compact(
            'developer', 
            'assignments', 
            'totalTickets', 
            'completedTickets', 
            'inProgressTickets',
            'pendingApprovalTickets',
            'resolutionRate'
        ));
    }
    
    /**
     * Show assigned tickets for the authenticated developer
     */
    public function myTickets()
    {
        // Ensure the authenticated user is a developer
        if (Auth::user()->role !== 'developer') {
            return redirect()->route('dashboard')
                ->with('error', 'Only developers can access their ticket assignments.');
        }
        
        $assignments = Assignment::with(['ticket', 'ticket.user', 'ticket.software'])
            ->where('developer_id', Auth::id())
            ->get();
            
        // Get resolutions for tickets
        $ticketResolutions = TicketResolution::whereIn('ticket_id', $assignments->pluck('ticket_id')->toArray())
            ->get()
            ->keyBy('ticket_id');
            
        return view('developers.my-tickets', compact('assignments', 'ticketResolutions'));
    }
    
    /**
     * Update ticket status by the developer
     */
    public function updateTicketStatus(Request $request, $ticketId)
    {
        $validated = $request->validate([
            'status' => 'required|in:in_progress,pending_approval,closed',
            'resolution_notes' => 'required_if:status,pending_approval',
        ]);
        
        // Ensure the authenticated user is assigned to this ticket
        $assignment = Assignment::where('ticket_id', $ticketId)
            ->where('developer_id', Auth::id())
            ->firstOrFail();
            
        $ticket = Ticket::findOrFail($ticketId);
        $ticket->status = $validated['status'];
        $ticket->save();
        
        // If the developer is marking the ticket as completed, save the resolution details
        if ($validated['status'] === 'pending_approval') {
            // Create or update resolution record
            TicketResolution::updateOrCreate(
                ['ticket_id' => $ticketId],
                [
                    'developer_id' => Auth::id(),
                    'resolution_notes' => $validated['resolution_notes'],
                    'resolved_at' => now(),
                    'status' => 'pending'
                ]
            );
            
            return redirect()->route('developers.my-tickets')
                ->with('success', 'Ticket marked as resolved and submitted for approval.');
        }
        
        return redirect()->route('developers.my-tickets')
            ->with('success', 'Ticket status updated successfully.');
    }

    /**
     * Admin approval of completed tickets
     */
    public function pendingApprovals()
    {
        // Ensure the authenticated user is an admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')
                ->with('error', 'Only administrators can approve ticket resolutions.');
        }
        
        $pendingTickets = Ticket::with(['user', 'software', 'assignments.developer', 'resolution'])
            ->where('status', 'pending_approval')
            ->get();
            
        return view('developers.pending-approvals', compact('pendingTickets'));
    }
    
    /**
     * Admin approves or rejects a resolution
     */
    public function resolveTicket(Request $request, $ticketId)
    {
        // Ensure the authenticated user is an admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')
                ->with('error', 'Only administrators can approve ticket resolutions.');
        }
        
        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
            'admin_notes' => 'nullable|string',
        ]);
        
        $ticket = Ticket::with('resolution')->findOrFail($ticketId);
        
        if ($validated['action'] === 'approve') {
            // Mark ticket as closed
            $ticket->status = 'closed';
            $ticket->save();
            
            // Update resolution record
            if ($ticket->resolution) {
                $ticket->resolution->status = 'approved';
                $ticket->resolution->admin_id = Auth::id();
                $ticket->resolution->admin_notes = $validated['admin_notes'];
                $ticket->resolution->approved_at = now();
                $ticket->resolution->save();
            }
            
            return redirect()->route('developers.pending-approvals')
                ->with('success', 'Ticket resolution approved and ticket marked as closed.');
        } else {
            // Mark ticket back as in progress
            $ticket->status = 'in_progress';
            $ticket->save();
            
            // Update resolution record
            if ($ticket->resolution) {
                $ticket->resolution->status = 'rejected';
                $ticket->resolution->admin_id = Auth::id();
                $ticket->resolution->admin_notes = $validated['admin_notes'];
                $ticket->resolution->save();
            }
            
            return redirect()->route('developers.pending-approvals')
                ->with('success', 'Ticket resolution rejected and ticket returned to in-progress status.');
        }
    }
}