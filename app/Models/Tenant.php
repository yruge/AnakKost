<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    protected $fillable = [
        'user_id',
        'name',
        'room_id',
        'phone_number',
        'ktp_photo',
        'move_in_date',
    ];

    protected $casts = [
        'move_in_date' => 'date',
    ];

}
