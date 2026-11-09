<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerDelegationFromVendorSubDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
        'images_after' => 'array'
    ];

    public function detail()
    {
        return $this->belongsTo(ContainerDelegationFromVendorDetail::class, 'ct_from_vendor_detail_id', 'id');
    }

    public function contractDetail()
    {
        return $this->belongsTo(ContractDetail::class);
    }
}
