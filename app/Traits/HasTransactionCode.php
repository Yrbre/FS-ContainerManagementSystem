<?php

namespace App\Traits;

use App\Models\Location;
use Exception;

trait HasTransactionCode
{
    public static function bootHasTransactionCode()
    {
        static::creating(function ($model) {
            if(!$model->transactionCode) throw new Exception('property $model->transactionCode not defind');
            $model->code = $model->generate();
        });
    }

    private function generate()
    {
        $cnt = str_pad($this->newQuery()->withTrashed()->count() + 1, 3, "0", STR_PAD_LEFT) ;
        

        return sprintf("%s/%s/%s/%s", $cnt, $this->transactionCode, $this->location->code, date('Y'));
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
