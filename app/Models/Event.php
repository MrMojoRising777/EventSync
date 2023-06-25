<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Model representing an event.
 */
class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'lat',
        'long',
        'owner_id',
        'address',
        'zipcode',
        'city',
    ];

    /**
     * Get the users associated with the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the availabilities associated with the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    /**
     * Get the recommended dates associated with the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recommendedDates()
    {
        return $this->hasMany(RecommendedDate::class);
    }
}