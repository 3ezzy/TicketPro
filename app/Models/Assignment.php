<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'developer_id',
        'admin_id',
    ];

    // Relationship to the Ticket model
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    // Relationship to the Developer (User) model
    public function developer()
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    // Relationship to the Admin (User) model
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
