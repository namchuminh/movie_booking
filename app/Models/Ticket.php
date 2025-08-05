<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'showtime_id', 'seat_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function ticketCode()
    {
        return $this->hasOne(TicketCode::class);
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'ticket_promotions');
    }
}
