<?php

namespace App\Models;

use App\Traits\HasTransactionCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContainerDelegationFromVendor extends Model
{
    use HasFactory, SoftDeletes, HasTransactionCode;

    protected $guarded = [];
    protected $transactionCode = 'BAST2';

    protected $dates = [
        'action_date'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id')->withTrashed();
    }

    public function details()
    {
        return $this->hasMany(ContainerDelegationFromVendorDetail::class, 'from_vendor_id', 'id');
    }

    public function createdByUser()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->withTrashed();
    }

    public function lastUpdatedBy() 
    {
        return $this->belongsTo(Admin::class, 'last_updated_by', 'id')->withTrashed();
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id')->withTrashed();
    }
}
