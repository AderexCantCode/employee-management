<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sdm extends Model
{
    use HasFactory;

    protected $table = 'sdms';
    protected $fillable = [
        'project_id',
        'project_director',
        'backend_dev',
        'frontend_dev',
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

    public function projectDirector()
    {
        return $this->belongsTo(User::class, 'project_director');
    }

    public function backendDev()
    {
        return $this->belongsTo(User::class, 'backend_dev');
    }

    public function frontendDev()
    {
        return $this->belongsTo(User::class, 'frontend_dev');
    }

    public function analis()
    {
        return $this->belongsTo(User::class, 'analis');
    }

    public function engineerAndroid()
    {
        return $this->belongsTo(User::class, 'engineer_android');
    }

    public function engineerIos()
    {
        return $this->belongsTo(User::class, 'engineer_ios');
    }

    public function copywriter()
    {
        return $this->belongsTo(User::class, 'copywriter');
    }

    public function uiux()
    {
        return $this->belongsTo(User::class, 'uiux');
    }

    public function contentCreator()
    {
        return $this->belongsTo(User::class, 'content_creator');
    }

    public function tester()
    {
        return $this->belongsTo(User::class, 'tester');
    }
}
