<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CrudEvents extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'event_name', 
        'event_date',
        'lat',
        'long',
        'owner_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'crud_event_user');
    }
}