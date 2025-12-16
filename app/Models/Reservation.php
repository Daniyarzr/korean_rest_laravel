<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'date',
        'time',
        'guests',
        'comment',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
