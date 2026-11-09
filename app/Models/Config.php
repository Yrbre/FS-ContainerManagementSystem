<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends Model
{
    use HasFactory, SoftDeletes; // Enable soft deletes

    protected $fillable = ['name', 'status']; // Define fillable fields
    protected $dates = ['deleted_at']; // Define the column as a date for soft deletes
}
