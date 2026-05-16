<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prayer extends Model
{
    protected $fillable = [
        'name','order','start_time','end_time','late_minutes','is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

