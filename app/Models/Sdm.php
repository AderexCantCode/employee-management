<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sdm extends Model
{
    use HasFactory;

    protected $table = 'sdm';
    protected $fillable = [
        'project_id',
        'project_director',
        'engineer_web',
        'analis',
        'engineer_android',
        'engineer_ios',
        'copywriter',
        'uiux',
        'content_creator',
        'tester',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
