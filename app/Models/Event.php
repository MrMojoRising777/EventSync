<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }
    public function recommendedDates()
    {
        return $this->hasMany(RecommendedDate::class);
    }

}