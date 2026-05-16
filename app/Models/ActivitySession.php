<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivitySession extends Model
{
    protected $fillable = [
        'activity_id',
        'started_at',
        'ended_at',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function attendances()
    {
        return $this->hasMany(ActivityAttendance::class);
    }
}