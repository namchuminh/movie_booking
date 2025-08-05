<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPromotion extends Model
{
    use HasFactory;

    protected $table = 'ticket_promotions';

    public $incrementing = false;

    protected $primaryKey = 'showtime_id';

    protected $fillable = ['showtime_id', 'promo_id'];

    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promo_id');
    }
}
