<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'os',
        'status',
        'user_id',
        'software_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function software()
    {
        return $this->belongsTo(Software::class);
    }

    public function scopeFromClients($query)
    {
        return $query->whereHas('user', function($q) {
            $q->where('role', 'client');
        });
    }
}
