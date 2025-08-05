<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'trailer_url', 'actors', 'director', 'genre',
        'rating', 'description', 'duration', 'release_date', 'language', 'image'
    ];

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
}
