<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'avatar',
        'phone',
        'address',
        'birth',
        'divisi',
        'work_hours', // tambahkan agar bisa mass assignment
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'manager_id');
    }

    // Relasi many-to-many ke task
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_user');
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    // ...existing code...

    public function leaves()
    {
        return $this->hasMany(Absence::class);
    }

    // Relasi ke task yang sudah complete
    public function completedTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to')->where('status', 'complete');
    }

    // Hitung ulang total work_hours dari semua task yang sudah complete
    public function recalculateWorkHours()
    {
        $this->work_hours = $this->completedTasks()->sum('work_hours');
        $this->save();
    }
}
