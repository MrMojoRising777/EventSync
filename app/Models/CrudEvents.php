<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
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
    
    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}