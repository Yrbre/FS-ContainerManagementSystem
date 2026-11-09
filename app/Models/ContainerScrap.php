<?php

namespace App\Models;

use App\Traits\HasTransactionCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContainerScrap extends Model
{
    use HasFactory, SoftDeletes, HasTransactionCode;
    protected $guarded = [];
    protected $transactionCode = 'SCRP';
    protected $dates = [
        'action_date'
    ];
    public function createdByUser()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->withTrashed();
    }

    protected $casts = [
        'documents' => 'array',
    ];

    public function lastUpdatedBy()
    {
        return $this->belongsTo(Admin::class, 'last_updated_by', 'id')->withTrashed();
    }

    public function details()
    {
        return $this->hasMany(ContainerScrapDetail::class, 'container_scrap_id', 'id');
    }

    public function detailsNotDone()
    {
        return $this->hasMany(ContainerScrapDetail::class, 'container_scrap_id', 'id')
            ->whereHas('containerScrap', function ($query) {
                $query->whereIn('status', ['DRAFT', 'POSTED']);
            });
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id')->withTrashed();
    }
}