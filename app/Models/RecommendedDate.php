<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model representing a recommended date for an event.
 */
class RecommendedDate extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'start_date', 'end_date'];

    /**
     * Get the event associated with the recommended date.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}