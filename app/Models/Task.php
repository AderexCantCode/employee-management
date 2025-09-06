<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'project_id',
        'created_by',
        'due_date',
        'work_hours', // tambahkan work_hours agar bisa diisi mass assignment
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relasi many-to-many ke user yang ditugaskan ke task
    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }

    // Relasi ke user yang membuat task
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Set work_hours otomatis berdasarkan priority
     */
    public static function getWorkHoursByPriority($priority)
    {
        return match ($priority) {
            'low' => 1,
            'medium' => 2,
            'high' => 3,
            default => 2,
        };
    }
}
