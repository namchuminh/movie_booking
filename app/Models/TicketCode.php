<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCode extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'code'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
