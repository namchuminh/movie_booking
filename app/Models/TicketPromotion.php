<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPromotion extends Model
{
    use HasFactory;

    protected $table = 'ticket_promotions';

    public $incrementing = false; // Vì bảng có khóa chính là composite (ticket_id + promo_id)

    protected $fillable = ['ticket_id', 'promo_id'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
}
