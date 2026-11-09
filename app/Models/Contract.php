<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id'
    ];

    protected $dates = [
        // 'active_date_start',
        // 'active_date_end',
        // 'warranty_date_start',
        // 'warranty_date_end',
    ];

    public function contract()
    {
        return $this->hasOne(Container::class);
    }
    
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id')->withTrashed();
    }

    public function contract_detail() {
        return $this->hasMany(ContractDetail::class, 'contract_id', 'id');
    }

    public function createdByUser() {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->withTrashed();
    }
}
