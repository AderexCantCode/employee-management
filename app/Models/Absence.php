<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'leave_category',
        'start_date',
        'end_date',
        'description',
        'has_laptop',
        'can_contact',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'has_laptop' => 'boolean',
        'can_contact' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
