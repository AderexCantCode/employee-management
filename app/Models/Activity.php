<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'model_type',
        'model_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
            return $this->belongsTo(Project::class);
     }


    public function getModelAttribute()
    {
        if ($this->model_type && $this->model_id) {
            return $this->model_type::find($this->model_id);
        }
        return null;
    }

    public function getFormattedActionAttribute()
    {
        $actions = [
            'created' => '🆕 Dibuat',
            'updated' => '✏️ Diperbarui',
            'deleted' => '🗑️ Dihapus',
            'completed' => '✅ Selesai',
            'started' => '🚀 Dimulai',
            'paused' => '⏸️ Dijeda',
            'resumed' => '▶️ Dilanjutkan'
        ];

        return $actions[$this->action] ?? $this->action;
    }
}
