<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContainerScrapDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function scrap()
    {
        return $this->belongsTo(ContainerScrap::class, 'container_scrap_id', 'id');
    }

    public function containerScrap() {
        return $this->belongsTo(ContainerScrap::class, 'container_scrap_id', 'id')->withTrashed();
    }

    public function container()
    {
        return $this->belongsTo(Container::class, 'container_code', 'code')->withTrashed();
    }
}
