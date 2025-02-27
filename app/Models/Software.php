<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Software extends Model
{
    //
    use HasFactory;

    protected $fillable = ['name', 'version', 'description'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
