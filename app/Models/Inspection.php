<?php

namespace App\Models;

use App\Models\Admin;
use App\Traits\MyModelTrait;
use App\Traits\HasTransactionCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inspection extends Model
{
    use HasFactory, HasTransactionCode, SoftDeletes;

    protected $guarded = [];
    protected $transactionCode = 'INP';
    protected $dates = [
        'action_date'
    ];

    public function details()
    {
        return $this->hasMany(InspectionDetail::class);
    }

    public function approveBy() {
        return $this->belongsTo(Admin::class, 'approve_by', 'id');
    }

    public function createdByUser() {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }
}
