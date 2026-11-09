<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerDailyActivityDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'ct_daily_activity_id', 'carriage_number', 'type', 'container_code', 'container_source'
    ];

    public function containerDailyActivity()
    {
        return $this->belongsTo(ContainerDailyActivity::class, 'ct_daily_activity_id', 'id')->withTrashed();
    }

    public function container()
    {
        return $this->belongsTo(Container::class, 'container_code', 'code')->withTrashed();
    }
}
