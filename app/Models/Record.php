<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $table = 'v_ct_record';


    public function container_code()
    {
        return $this->belongsTo(Container::class)->withTrashed();
    }
}