<?php

namespace App\Models;

use App\Traits\HasTransactionCode;
use App\Models\ContainerRepairDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContainerRepair extends Model
{
    use HasFactory, HasTransactionCode, SoftDeletes;

    protected $transactionCode = 'PRG';

    protected $guarded = [
        'id'
    ];

    protected $dates = [
        'action_date'
    ];

    public function vendor() {
        return $this->belongsTo(Vendor::class)->withTrashed();
    }

    public function location() {
        return $this->belongsTo(Location::class)->withTrashed();
    }

    public function details() {
        return $this->hasMany(ContainerRepairDetail::class);
    }

    public function approveBy() {
        return $this->belongsTo(Admin::class, 'approve_by', 'id')->withTrashed();
    }

    public function createdByUser() {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->withTrashed();
    }

}
