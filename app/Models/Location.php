<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $guarded = [
        'id'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }

    public function containerDownLocation()
    {
        return $this->belongsTo(Container::class, 'down_location_id', 'id');
    }

    public function containerUpLocation()
    {
        return $this->belongsTo(Container::class, 'up_location_id', 'id');
    }

    public function createdByUser() {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->withTrashed();
    }
}
