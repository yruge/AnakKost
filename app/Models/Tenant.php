<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    protected $fillable = [
        'name',
        'phone_number',
        'move_in_date',
        'room_id',
    ];
}
