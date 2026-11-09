<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionDetail extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'images' => 'array'
    ];

    public function container()
    {
        return $this->belongsTo(Container::class, 'container_code', 'code');
    }

    public function containerDelegationDetail()
    {
        return $this->hasMany(ContainerDelegationDetail::class, 'container_code');
    }

    public function inspection()
    {
        return $this->belongsTo(Inspection::class, 'inspection_id', 'id');
    }

    public function containerDelegationSubDetail()
    {
        return $this->belongsTo(ContainerDelegationSubDetail::class, 'inspection_detail_id', 'id');
    }
}
