<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketResolution extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ticket_id',
        'developer_id',
        'admin_id',
        'resolution_notes',
        'admin_notes',
        'status',
        'resolved_at',
        'approved_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'resolved_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    /**
     * Get the ticket that this resolution belongs to.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the developer who resolved this ticket.
     */
    public function developer()
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    /**
     * Get the admin who approved or rejected this resolution.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}