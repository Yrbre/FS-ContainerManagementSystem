<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractDetail extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    // public function getPriceAttribute($value)
    // {
    //     $price = $value ? number_format($value, 0, ',', '.') : '';
    //     return $price;
    // }

    public function contract() {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

   
    public function unit() {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
}
