<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendedDate extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'start_date', 'end_date'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
