<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContainerDelegationFromVendorDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // protected $fillable = [
    //     'from_vendor_id',
    //     'container_code',
    //     'images',
    //     'delegation_to_vendor_date',
    //     'progress',
    //     'container_damage'
    // ];

    protected $casts = [
        'images' => 'array',
    ];

    // public function delegationFromVendor()
    // {
    //     return $this->hasMany(ContainerDelegationFromVendor::class, 'from_vendor_id', 'id');
    // }

    public function delegationFromVendor() {
        return $this->belongsTo(ContainerDelegationFromVendor::class, 'from_vendor_id', 'id')->withTrashed();
    }

    public function container()
    {
        return $this->belongsTo(Container::class, 'container_code', 'code')->withTrashed();
    }

    public function sub()
    {
        return $this->hasMany(ContainerDelegationFromVendorSubDetail::class, 'ct_from_vendor_detail_id', 'id');
    }

    public function delegationToVendorDetail() {
        return $this->belongsTo(ContainerDelegationDetail::class, 'container_delegation_detail_id', 'id');
    }
}
