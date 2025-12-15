<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    
    public function tenant()
    {
        return $this->hasOne(Tenant::class);
    }

    protected $fillable = [
        'room_number',
        'size',
        'price_per_month',
        'status',
    ];
}
