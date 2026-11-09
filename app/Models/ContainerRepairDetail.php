<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContainerRepairDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [
        'id'
    ];

    public function repair()
    {
        return $this->belongsTo(ContainerRepair::class, 'container_repair_id', 'id');
    }
}
