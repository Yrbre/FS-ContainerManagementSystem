<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'created_by'
    ];

    public function admin() {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->withTrashed();
    }

    public function createdByUser() {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->withTrashed();
    }
}
