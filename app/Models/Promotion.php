<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'start_date', 'end_date', 'image'];

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class, 'ticket_promotions');
    }
}
