<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerDelegationSubDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'images' => 'array'
    ];

    public function details()
    {
        return $this->belongsTo(ContainerDelegationDetail::class, 'ct_delegation_detail_id', 'id');
    }
}
