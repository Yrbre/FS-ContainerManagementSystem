<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerDelegationDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'images' => 'array'
    ];

    public function containerDelegation()
    {
        return $this->belongsTo(ContainerDelegation::class, 'container_delegation_id', 'id')->withTrashed();
    }

    public function subDetails()
    {
        return $this->hasMany(ContainerDelegationSubDetail::class, 'ct_delegation_detail_id', 'id');
    }

    public function inspectionDetails()
    {
        return $this->hasMany(InspectionDetail::class, 'container_code');
    }

    public function container()
    {
        return $this->belongsTo(Container::class, 'container_code', 'code')->withTrashed();
    }
}
