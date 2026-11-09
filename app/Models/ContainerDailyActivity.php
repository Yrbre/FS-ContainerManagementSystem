<?php

namespace App\Models;

use App\Traits\HasTransactionCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContainerDailyActivity extends Model
{
    use HasFactory, HasTransactionCode, SoftDeletes;

    protected $guarded = [];
    protected $transactionCode = 'AKT';
    protected $dates = [
        'action_date'
    ];

    public function details()
    {
        return $this->hasMany(ContainerDailyActivityDetail::class, 'ct_daily_activity_id', 'id');
    }

    public function createdByUser() {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }
}
