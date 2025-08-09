<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPromotion extends Model
{
    use HasFactory;

    protected $table = 'ticket_promotions';

    public $incrementing = false;

    protected $primaryKey = 'movie_id';

    protected $fillable = ['movie_id', 'promo_id'];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promo_id');
    }
}
