<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'user_id',
        'deadline',
        'progress',
        'start_date',
        'end_date',
        'manager_id',
    ];

    protected $dates = [
        'deadline',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';
    const STATUS_ON_HOLD = 'on_hold';
    const STATUS_CANCELLED = 'cancelled';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'model_id')
                   ->where('model_type', 'App\\Models\\Project');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id');
    }

    public function sdm()
    {
        return $this->hasOne(Sdm::class);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => '<span class="badge bg-primary">Aktif</span>',
            'completed' => '<span class="badge bg-success">Selesai</span>',
            'on_hold' => '<span class="badge bg-warning">Tertunda</span>',
            'cancelled' => '<span class="badge bg-danger">Dibatalkan</span>'
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    public function getProgressPercentageAttribute()
    {
        return min(100, max(0, $this->progress ?? 0));
    }
}
